<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
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

        $blogs = $query->paginate(6);
        return view('front.blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('front.blogs.show', compact('blog'));
    }
}
