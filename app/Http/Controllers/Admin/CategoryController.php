<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order','asc')->get();
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

        // determine next order value
        $maxOrder = Category::max('order');
        $nextOrder = is_null($maxOrder) ? 1 : $maxOrder + 1;

        Category::create([
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
            'order' => $nextOrder,
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

    /**
     * Reorder categories via AJAX.
     */
    public function reorder(Request $request)
    {
        $order = $request->input('order'); // expected array of ids in new order
        if (!is_array($order)) {
            return response()->json(['message' => 'Invalid order data'], 422);
        }

        foreach ($order as $index => $id) {
            Category::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'Order updated']);
    }

    /**
     * Move a single category to a given global position (reindex all categories afterwards).
     */
    public function move(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:categories,id',
            'position' => 'nullable|integer|min:1'
        ]);

        $id = $request->id;
        $position = max(1, (int) $request->get('position', 1));

        DB::transaction(function () use ($id, $position) {
            $items = Category::orderByRaw('COALESCE(`order`, 999999) ASC, id ASC')->get()->keyBy('id');
            if (!isset($items[$id])) {
                throw new \Exception('Category not found in ordering set.');
            }

            $moving = $items->pull($id);
            $arr = $items->values()->all();
            $total = count($arr) + 1;
            $position = min($position, $total);
            array_splice($arr, $position - 1, 0, [$moving]);

            foreach ($arr as $index => $category) {
                $category->order = $index + 1;
                $category->save();
            }
        });

        return response()->json(['success' => true]);
    }
}
