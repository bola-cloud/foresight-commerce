<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\AdSlider;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $sliders = AdSlider::all(); // Fetch all sliders
        return view('front.home', compact('products', 'categories', 'sliders'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Process the data (e.g., send an email, store in the database, etc.)
        return redirect()->back()->with('success', __('contact.thank_you'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $products = Product::where('ar_name', 'LIKE', "%{$query}%")
            ->orWhere('en_name', 'LIKE', "%{$query}%")
            ->take(10) // Limit the results
            ->get(['id', 'ar_name', 'en_name', 'images']); // Fetch specific fields

        return response()->json($products);
    }
}
