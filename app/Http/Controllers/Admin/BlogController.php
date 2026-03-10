<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index()
    {
        $query = Blog::query();
        if (Schema::hasColumn('blogs', 'order')) {
            $query = $query->orderBy('order', 'asc');
        } else {
            $query = $query->latest();
        }

        $blogs = $query->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_content' => 'required',
            'en_content' => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blog = new Blog();
        $blog->ar_title = $request->ar_title;
        $blog->en_title = $request->en_title;
        $blog->slug = Str::slug($request->en_title); // Slug based on English title
        $blog->ar_content = $request->ar_content;
        $blog->en_content = $request->en_content;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $blog->image = $imagePath;
        }

        if (Schema::hasColumn('blogs', 'order')) {
            $blog->order = Blog::max('order') + 1;
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog added successfully!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Reorder blogs via AJAX. Expects `ids` => [id1, id2, ...]
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:blogs,id'
        ]);

        $ids = $request->ids;

        foreach ($ids as $index => $id) {
            Blog::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_content' => 'required',
            'en_content' => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blog->ar_title = $request->ar_title;
        $blog->en_title = $request->en_title;
        $blog->slug = Str::slug($request->en_title);
        $blog->ar_content = $request->ar_content;
        $blog->en_content = $request->en_content;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }
            $blog->image = $request->file('image')->store('blogs', 'public');
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::delete('public/' . $blog->image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }
}
