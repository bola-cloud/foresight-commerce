@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.edit_product') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="form-group">
            <label for="ar_name">{{ __('lang.ar_name') }}</label>
            <input type="text" name="ar_name" class="form-control" value="{{ old('ar_name', $product->ar_name) }}" required>
        </div>
        <div class="form-group">
            <label for="en_name">{{ __('lang.en_name') }}</label>
            <input type="text" name="en_name" class="form-control" value="{{ old('en_name', $product->en_name) }}" required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">{{ __('lang.category') }}</label>
            <select name="category_id" class="form-control select2" required>
                <option value="">{{ __('lang.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? $category->ar_name : $category->en_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">{{ __('lang.price') }}</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <!-- Quantity -->
        <div class="form-group">
            <label for="quantity">{{ __('lang.quantity') }}</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="ar_description">{{ __('lang.ar_description') }}</label>
            <textarea name="ar_description" class="form-control">{{ old('ar_description', $product->ar_description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="en_description">{{ __('lang.en_description') }}</label>
            <textarea name="en_description" class="form-control">{{ old('en_description', $product->en_description) }}</textarea>
        </div>

        <!-- Features -->
        <div class="form-group">
            <label for="ar_features">{{ __('lang.ar_features') }}</label>
            <div id="ar-features-wrapper">
                @foreach (json_decode($product->ar_features, true) ?? [''] as $feature)
                    <div class="input-group mb-2">
                        <input type="text" name="ar_features[]" class="form-control" value="{{ $feature }}" placeholder="{{ __('lang.enter_feature') }}">
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-ar-feature" class="btn btn-primary">{{ __('lang.add_feature') }}</button>
        </div>

        <div class="form-group">
            <label for="en_features">{{ __('lang.en_features') }}</label>
            <div id="en-features-wrapper">
                @foreach (json_decode($product->en_features, true) ?? [''] as $feature)
                    <div class="input-group mb-2">
                        <input type="text" name="en_features[]" class="form-control" value="{{ $feature }}" placeholder="{{ __('lang.enter_feature') }}">
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-en-feature" class="btn btn-primary">{{ __('lang.add_feature') }}</button>
        </div>

        <!-- Manufacturer -->
        <div class="form-group">
            <label for="ar_manufacturer">{{ __('lang.ar_manufacturer') }}</label>
            <input type="text" name="ar_manufacturer" class="form-control" value="{{ old('ar_manufacturer', $product->ar_manufacturer) }}">
        </div>
        <div class="form-group">
            <label for="en_manufacturer">{{ __('lang.en_manufacturer') }}</label>
            <input type="text" name="en_manufacturer" class="form-control" value="{{ old('en_manufacturer', $product->en_manufacturer) }}">
        </div>

        <!-- Existing Images -->
        <div class="form-group">
            <label>{{ __('lang.existing_images') }}</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($product->images as $image)
                    <div class="image-preview">
                        <img src="{{ $image['url'] }}" alt="Product Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                        <p class="text-center small">{{ $image['primary'] ? __('lang.primary_image') : '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- New Images -->
        <div class="form-group">
            <label for="images">{{ __('lang.new_images') }}</label>
            <input type="file" class="filepond" name="file" multiple>
        </div>

        <!-- Hidden Inputs for Images -->
        <input type="hidden" name="images" id="uploadedImages">
        <input type="hidden" name="current_images" value="{{ json_encode($product->images) }}">

        <!-- Primary Image Selection -->
        <div class="form-group mt-3">
            <label for="primary_image">{{ __('lang.primary_image') }}</label>
            <select name="primary_image" id="primary_image" class="form-control">
                <option value="">{{ __('lang.select_primary_image') }}</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">{{ __('lang.update') }}</button>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);

    let uploadedImages = [];

    const filePond = FilePond.create(document.querySelector('.filepond'), {
        allowMultiple: true,
        server: {
            process: {
                url: '{{ route("admin.products.upload") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                ondata: (formData) => { formData.append('_token', '{{ csrf_token() }}'); return formData; },
            },
            revert: { url: '{{ route("admin.products.delete_temp_image") }}', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, method: 'DELETE' },
        },
        onprocessfile: (error, file) => {
            if (!error) {
                uploadedImages.push(file.serverId);
                document.getElementById('uploadedImages').value = JSON.stringify(uploadedImages);

                // Clear old primary image options
                const primaryImageDropdown = document.getElementById('primary_image');
                primaryImageDropdown.innerHTML = '';

                // Add new images to the primary image dropdown
                uploadedImages.forEach((image) => {
                    const option = document.createElement('option');
                    option.value = image;
                    option.textContent = image;
                    primaryImageDropdown.appendChild(option);
                });
            }
        },
    });
</script>
@endpush

@push('css')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
