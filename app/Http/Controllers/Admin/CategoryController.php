<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
        ]);

        Category::create([
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
        ]);

        return redirect()->back()->with('success', __('lang.category_created'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'ar_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
        ]);

        $category->update([
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
        ]);

        return redirect()->back()->with('success', __('lang.category_updated'));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('success', __('lang.category_deleted'));
    }
}
