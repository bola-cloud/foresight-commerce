<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    public function details($id)
    {
        // Fetch the product by ID
        $product = Product::with('category')->findOrFail($id);

        return view('front.product-details', compact('product'));
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::query();

        // Search by product name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('ar_name', 'like', '%' . $request->search . '%')
                  ->orWhere('en_name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            if ($request->sort == 'price_low_high') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_high_low') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort == 'name_asc') {
                $query->orderBy('en_name', 'asc');
            } elseif ($request->sort == 'name_desc') {
                $query->orderBy('en_name', 'desc');
            }
        }

        $products = $query->paginate(12); // Adjust pagination count as needed

        return view('front.all-products', compact('products', 'categories'));
    }

    public function filterByCategory(Category $category)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category->id)->paginate(12);

        return view('front.all-products', compact('products', 'categories', 'category'));
    }
}
