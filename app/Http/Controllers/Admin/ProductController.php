<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        // Get the search query and category filter from the request
        $searchQuery = $request->get('search', '');
        $categoryId = $request->get('category', '');

        // Query products with their categories and apply search/filter conditions
        $productsQuery = Product::with('category')
            ->when($searchQuery, function($query, $searchQuery) {
                return $query->where(function($query) use ($searchQuery) {
                    $query->where('ar_name', 'like', "%$searchQuery%")
                        ->orWhere('en_name', 'like', "%$searchQuery%");
                });
            })
            ->when($categoryId, function($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
        ;

        // Order by `order` column when it exists; otherwise keep default ordering
        if (Schema::hasColumn('products', 'order')) {
            $productsQuery = $productsQuery->orderBy('order', 'asc');
        }

        $products = $productsQuery->paginate(10); // Paginate with 10 items per page

        // Get all categories for the filter dropdown ordered
        $categories = Category::orderBy('order','asc')->get();

        // Return the view with the products, categories, and filters
        return view('admin.products.index', compact('products', 'categories', 'searchQuery', 'categoryId'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('order','asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar_name' => 'required|string',
            'en_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'ar_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ar_features' => 'required|array|min:1', // Must be an array with at least one entry
            'ar_features.*' => 'string|max:255', // Validate each feature
            'en_features' => 'required|array|min:1', // Must be an array with at least one entry
            'en_features.*' => 'string|max:255', // Validate each feature
            'images' => 'nullable|string', // Validate as a JSON string (optional)
            'ar_manufacturer' => 'nullable|string',
            'en_manufacturer' => 'nullable|string',
            'primary_image' => 'nullable|string',
        ]);
        $processedImages = [];

        // Only process images if they were sent and the decoded array is non-empty
        if ($request->has('images') && strlen(trim((string) $request->images)) > 0) {
            if (is_array($request->images)) {
                $imagesArray = $request->images;
            } else {
                $imagesArray = json_decode($request->images, true); // Decode JSON into an array
            }

            // If decoding failed or it's not an array, treat as no images provided
            if (!is_array($imagesArray)) {
                $imagesArray = [];
            }

            if (count($imagesArray) > 0) {
                try {
                    // Process images array
                    $processedImages = collect($imagesArray)->map(function ($image) use ($request) {
                        $decodedImage = is_string($image) ? json_decode($image, true) : $image;
                        $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                        $newPath = str_replace('temp/', 'products/', $tempPath);

                        // Move file to the permanent location
                        Storage::disk('public')->move($tempPath, $newPath);

                        return [
                            'url' => asset('storage/' . $newPath),
                            'primary' => (isset($decodedImage['url']) && $decodedImage['url'] === $request->primary_image),
                        ];
                    })->toArray();
                } catch (\Exception $e) {
                    // Clean up any moved files on error
                    foreach ($processedImages as $img) {
                        if (isset($img['url'])) {
                            $p = str_replace(asset('storage/'), '', $img['url']);
                            Storage::disk('public')->delete($p);
                        }
                    }

                    return redirect()->back()->with('error', 'An error occurred while saving the product.');
                }
            }
        }

        // Save the product to the database
        Product::create([
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'ar_description' => $request->ar_description,
            'en_description' => $request->en_description,
            'ar_features' => json_encode($request->ar_features), // Save as JSON
            'en_features' => json_encode($request->en_features), // Save as JSON
            'images' => $processedImages, // Save processed array as JSON (may be empty)
            'order' => (Schema::hasColumn('products', 'order') ? (Product::max('order') + 1) : null),
            'ar_manufacturer' => $request->ar_manufacturer,
            'en_manufacturer' => $request->en_manufacturer,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function upload(Request $request)
    {
        \Log::error('method started');
        try {
            if ($request->hasFile('file')) {
                \Log::info('File received for upload: ' . $request->file('file')->getClientOriginalName());
                // Validate the uploaded file
                $request->validate([
                    'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                // Store the file in the 'temp' directory under 'public'
                $path = $request->file('file')->store('temp', 'public');

                // Return the temporary file URL
                return response()->json([
                    'url' => asset('storage/' . $path),
                ], 200);
            }

            return response()->json([
                'message' => 'Upload failed. No file received.',
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Upload Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('order','asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ar_name' => 'required|string',
            'en_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'ar_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ar_features' => 'nullable|array',
            'ar_features.*' => 'string|max:255',
            'en_features' => 'nullable|array',
            'en_features.*' => 'string|max:255',
            'ar_manufacturer' => 'nullable|string',
            'en_manufacturer' => 'nullable|string',
            'images' => 'nullable|string', // Images can be nullable
            'primary_image' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        // If images were provided, process and replace; otherwise keep existing images
        $processedImages = null;

        if ($request->has('images') && strlen(trim((string) $request->images)) > 0) {
            if (is_array($request->images)) {
                $imagesArray = $request->images;
            } else {
                $imagesArray = json_decode($request->images, true); // Decode JSON into an array
            }

            if (!is_array($imagesArray)) {
                $imagesArray = [];
            }

            if (count($imagesArray) > 0) {
                try {
                    // Delete old images
                    foreach ($product->images ?? [] as $oldImage) {
                        if (isset($oldImage['url'])) {
                            $oldPath = str_replace(asset('storage/'), '', $oldImage['url']);
                            Storage::disk('public')->delete($oldPath);
                        }
                    }

                    // Process images array
                    $processedImages = collect($imagesArray)->map(function ($image) use ($request) {
                        $decodedImage = is_string($image) ? json_decode($image, true) : $image;
                        $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                        $newPath = str_replace('temp/', 'products/', $tempPath);

                        // Move file to the permanent location
                        Storage::disk('public')->move($tempPath, $newPath);

                        return [
                            'url' => asset('storage/' . $newPath),
                            'primary' => (isset($decodedImage['url']) && $decodedImage['url'] === $request->primary_image),
                        ];
                    })->toArray();
                } catch (\Exception $e) {
                    // Clean up any moved files on error
                    foreach ($processedImages ?? [] as $img) {
                        if (isset($img['url'])) {
                            $p = str_replace(asset('storage/'), '', $img['url']);
                            Storage::disk('public')->delete($p);
                        }
                    }

                    return redirect()->back()->with('error', 'An error occurred while updating the product.');
                }
            }
        }

        // Prepare update data
        $updateData = [
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'ar_description' => $request->ar_description,
            'en_description' => $request->en_description,
            'ar_features' => json_encode($request->ar_features),
            'en_features' => json_encode($request->en_features),
            'ar_manufacturer' => $request->ar_manufacturer,
            'en_manufacturer' => $request->en_manufacturer,
        ];

        if (!is_null($processedImages)) {
            $updateData['images'] = $processedImages;
        }

        $product->update($updateData);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function deleteTempImage(Request $request)
    {
        $request->validate(['file' => 'required|string']);

        try {
            $filePath = str_replace(asset('storage/'), '', $request->file);
            Storage::disk('public')->delete($filePath);

            return response()->json(['message' => 'Temporary file deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete file.'], 500);
        }
    }

    /**
     * Reorder products via AJAX. Expects `ids` => [id1, id2, ...]
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1'
        ]);

        $ids = $request->ids;
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        // Compute global offset so items on page N get proper global positions
        $start = ($page - 1) * $perPage;

        foreach ($ids as $index => $id) {
            Product::where('id', $id)->update(['order' => $start + $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $images = $product->images ?? [];

        if (!empty($images)) {
            foreach ($images as $image) {
                if (isset($image['url'])) {
                    // Extract the relative path from the full URL
                    $filePath = str_replace(asset('storage/'), '', $image['url']);
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

}
