<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
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
            'images' => 'required|string', // Validate as a JSON string
            'ar_manufacturer' => 'nullable|string',
            'en_manufacturer' => 'nullable|string',
            'primary_image' => 'nullable|string',
        ]);

        $imagesArray = json_decode($request->images, true); // Decode JSON into an array

        if (!is_array($imagesArray)) {
            return redirect()->back()->withErrors(['images' => 'Invalid images format.']);
        }

        try {
            // Process images array
            $processedImages = collect($imagesArray)->map(function ($image) use ($request) {
                $decodedImage = json_decode($image, true);
                $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                $newPath = str_replace('temp/', 'products/', $tempPath);

                // Move file to the permanent location
                Storage::disk('public')->move($tempPath, $newPath);

                return [
                    'url' => asset('storage/' . $newPath),
                    'primary' => $decodedImage['url'] === $request->primary_image,
                ];
            })->toArray();

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
                'images' => $processedImages, // Save processed array as JSON
                'ar_manufacturer' => $request->ar_manufacturer,
                'en_manufacturer' => $request->en_manufacturer,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            foreach ($imagesArray as $image) {
                $decodedImage = json_decode($image, true);
                $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                Storage::disk('public')->delete($tempPath); // Delete temp file
            }

            return redirect()->back()->with('error', 'An error occurred while saving the product.');
        }
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
        $categories = Category::all();
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

        $imagesArray = json_decode($request->images, true); // Decode JSON into an array

        if (!is_array($imagesArray)) {
            return redirect()->back()->withErrors(['images' => 'Invalid images format.']);
        }

        try {
            // Delete old images
            foreach ($product->images as $oldImage) {
                $oldPath = str_replace(asset('storage/'), '', $oldImage['url']);
                Storage::disk('public')->delete($oldPath);
            }

            // Process images array
            $processedImages = collect($imagesArray)->map(function ($image) use ($request) {
                $decodedImage = json_decode($image, true);
                $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                $newPath = str_replace('temp/', 'products/', $tempPath);

                // Move file to the permanent location
                Storage::disk('public')->move($tempPath, $newPath);

                return [
                    'url' => asset('storage/' . $newPath),
                    'primary' => $decodedImage['url'] === $request->primary_image,
                ];
            })->toArray();

            // Update the product in the database
            $product->update([
                'ar_name' => $request->ar_name,
                'en_name' => $request->en_name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'ar_description' => $request->ar_description,
                'en_description' => $request->en_description,
                'ar_features' => json_encode($request->ar_features),
                'en_features' => json_encode($request->en_features),
                'images' => $processedImages, // Save processed array as JSON
                'ar_manufacturer' => $request->ar_manufacturer,
                'en_manufacturer' => $request->en_manufacturer,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            foreach ($imagesArray as $image) {
                $decodedImage = json_decode($image, true);
                $tempPath = str_replace(asset('storage/'), '', $decodedImage['url']);
                Storage::disk('public')->delete($tempPath); // Delete temp file
            }

            return redirect()->back()->with('error', 'An error occurred while updating the product.');
        }
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
