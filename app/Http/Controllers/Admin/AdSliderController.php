<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdSliderController extends Controller
{
    public function index()
    {
        $adSliders = AdSlider::all();
        return view('admin.adsliders.index', compact('adSliders'));
    }

    public function create()
    {
        return view('admin.adsliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'brand' => 'required|string|max:255',
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('ads', 'public');

        AdSlider::create([
            'image' => $imagePath,
            'brand' => $request->brand,
            'ar_title' => $request->ar_title,
            'en_title' => $request->en_title,
            'ar_description' => $request->ar_description,
            'en_description' => $request->en_description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.adsliders.index')->with('success', __('lang.ad_created'));
    }

    public function edit(AdSlider $adSlider)
    {
        // dd($adSlider);
        return view('admin.adsliders.edit', compact('adSlider'));
    }

    public function update(Request $request, AdSlider $adSlider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'brand' => 'required|string|max:255',
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($adSlider->image);

            // Upload new image
            $adSlider->image = $request->file('image')->store('ads', 'public');
        }

        $adSlider->update([
            'brand' => $request->brand,
            'ar_title' => $request->ar_title,
            'en_title' => $request->en_title,
            'ar_description' => $request->ar_description,
            'en_description' => $request->en_description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.adsliders.index')->with('success', __('lang.ad_updated'));
    }

    public function destroy($id)
    {
        $adSlider = AdSlider::find($id); // Manually find the record by ID

        if (!$adSlider) {
            return redirect()->route('admin.adsliders.index')->with('error', __('lang.ad_not_found'));
        }

        // Log the image path for debugging
        \Log::info('Image path: ' . $adSlider->image);

        // Check if the image exists and delete it using Laravel's Storage system
        if (!empty($adSlider->image) && Storage::disk('public')->exists($adSlider->image)) {
            // Delete the image from storage
            if (Storage::disk('public')->delete($adSlider->image)) {
                \Log::info('Image deleted successfully.');
            } else {
                \Log::error('Failed to delete image.');
            }
        } else {
            \Log::error('Image not found or path is incorrect.');
        }

        // Delete the adSlider record from the database
        $adSlider->delete();

        return redirect()->route('admin.adsliders.index')->with('success', __('lang.ad_deleted'));
    }
}
