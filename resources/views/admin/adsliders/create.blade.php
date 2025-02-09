@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.add_ad') }}</h1>

    <form action="{{ route('admin.adsliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">{{ __('lang.image') }}</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="brand">{{ __('lang.brand') }}</label>
            <input type="text" name="brand" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ar_title">{{ __('lang.ar_title') }}</label>
            <input type="text" name="ar_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="en_title">{{ __('lang.en_title') }}</label>
            <input type="text" name="en_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ar_description">{{ __('lang.ar_description') }}</label>
            <textarea name="ar_description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="en_description">{{ __('lang.en_description') }}</label>
            <textarea name="en_description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="price">{{ __('lang.price') }}</label>
            <input type="number" step="0.01" name="price" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
    </form>
</div>
@endsection
