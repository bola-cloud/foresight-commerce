@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.edit_ad') }}</h1>

    <form action="{{ route('admin.adsliders.update', $adSlider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Current Image -->
        <div class="form-group">
            <label for="current_image">{{ __('lang.current_image') }}</label>
            <div>
                <img src="{{ asset('storage/' . $adSlider->image) }}" alt="Current Image" width="150">
            </div>
        </div>

        <!-- Upload New Image -->
        <div class="form-group">
            <label for="image">{{ __('lang.new_image') }}</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <!-- Brand -->
        <div class="form-group">
            <label for="brand">{{ __('lang.brand') }}</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand', $adSlider->brand) }}" required>
        </div>

        <!-- Arabic Title -->
        <div class="form-group">
            <label for="ar_title">{{ __('lang.ar_title') }}</label>
            <input type="text" name="ar_title" class="form-control" value="{{ old('ar_title', $adSlider->ar_title) }}" required>
        </div>

        <!-- English Title -->
        <div class="form-group">
            <label for="en_title">{{ __('lang.en_title') }}</label>
            <input type="text" name="en_title" class="form-control" value="{{ old('en_title', $adSlider->en_title) }}" required>
        </div>

        <!-- Arabic Description -->
        <div class="form-group">
            <label for="ar_description">{{ __('lang.ar_description') }}</label>
            <textarea name="ar_description" class="form-control">{{ old('ar_description', $adSlider->ar_description) }}</textarea>
        </div>

        <!-- English Description -->
        <div class="form-group">
            <label for="en_description">{{ __('lang.en_description') }}</label>
            <textarea name="en_description" class="form-control">{{ old('en_description', $adSlider->en_description) }}</textarea>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">{{ __('lang.price') }}</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $adSlider->price) }}">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">{{ __('lang.update') }}</button>
    </form>
</div>
@endsection
