@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.add_product') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf

        <!-- Product Name -->
        <div class="form-group">
            <label for="ar_name">{{ __('lang.ar_name') }}</label>
            <input type="text" name="ar_name" class="form-control" value="{{ old('ar_name') }}" required>
        </div>
        <div class="form-group">
            <label for="en_name">{{ __('lang.en_name') }}</label>
            <input type="text" name="en_name" class="form-control" value="{{ old('en_name') }}" required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">{{ __('lang.category') }}</label>
            <select name="category_id" class="form-control select2" required>
                <option value="">{{ __('lang.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? $category->ar_name : $category->en_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">{{ __('lang.price') }}</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <!-- Quantity -->
        <div class="form-group">
            <label for="quantity">{{ __('lang.quantity') }}</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="ar_description">{{ __('lang.ar_description') }}</label>
            <textarea name="ar_description" class="form-control">{{ old('ar_description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="en_description">{{ __('lang.en_description') }}</label>
            <textarea name="en_description" class="form-control">{{ old('en_description') }}</textarea>
        </div>

        <!-- Features (Arabic) -->
        <div class="form-group">
            <label for="ar_features">{{ __('lang.ar_features') }}</label>
            <div id="ar-features-wrapper">
                @if (old('ar_features'))
                    @foreach (old('ar_features') as $feature)
                        <div class="input-group mb-2">
                            <input type="text" name="ar_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" value="{{ $feature }}" />
                            <button type="button" class="btn btn-danger remove-feature">-</button>
                        </div>
                    @endforeach
                @else
                    <div class="input-group mb-2">
                        <input type="text" name="ar_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" />
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-ar-feature" class="btn btn-primary">{{ __('lang.add_feature') }}</button>
        </div>

        <!-- Features (English) -->
        <div class="form-group">
            <label for="en_features">{{ __('lang.en_features') }}</label>
            <div id="en-features-wrapper">
                @if (old('en_features'))
                    @foreach (old('en_features') as $feature)
                        <div class="input-group mb-2">
                            <input type="text" name="en_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" value="{{ $feature }}" />
                            <button type="button" class="btn btn-danger remove-feature">-</button>
                        </div>
                    @endforeach
                @else
                    <div class="input-group mb-2">
                        <input type="text" name="en_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" />
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-en-feature" class="btn btn-primary">{{ __('lang.add_feature') }}</button>
        </div>


        <!-- Manufacturer -->
        <div class="form-group">
            <label for="ar_manufacturer">{{ __('lang.ar_manufacturer') }}</label>
            <input type="text" name="ar_manufacturer" class="form-control" value="{{ old('ar_manufacturer') }}">
        </div>
        <div class="form-group">
            <label for="en_manufacturer">{{ __('lang.en_manufacturer') }}</label>
            <input type="text" name="en_manufacturer" class="form-control" value="{{ old('en_manufacturer') }}">
        </div>

        <!-- Images -->
        <div class="form-group">
            <label for="images">{{ __('lang.images') }}</label>
            <input type="file" class="filepond" name="file" multiple>
        </div>

        <!-- Hidden Input for Uploaded Images -->
        <input type="hidden" name="images" id="uploadedImages">

        <!-- Primary Image Selection -->
        <div class="form-group mt-3">
            <label for="primary_image">{{ __('lang.primary_image') }}</label>
            <select name="primary_image" id="primary_image" class="form-control">
                <option value="">{{ __('lang.select_primary_image') }}</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
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
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);

    let uploadedImages = [];

    // Initialize FilePond
    const filePond = FilePond.create(document.querySelector('.filepond'), {
        allowMultiple: true,
        name: 'file', // Matches the input name in Laravel
        server: {
            process: {
                url: '{{ route("admin.products.upload") }}', // Backend route
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF Token for Laravel
                },
                method: 'POST',
                ondata: (formData) => {
                    formData.append('_token', '{{ csrf_token() }}');
                    return formData;
                },
            },
            revert: {
                url: '{{ route("admin.products.delete_temp_image") }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                method: 'DELETE',
            },
        },
        onprocessfile: (error, file) => {
            if (!error) {
                uploadedImages.push(file.serverId); // Add uploaded file path
                document.getElementById('uploadedImages').value = JSON.stringify(uploadedImages);
                const option = document.createElement('option');
                option.value = file.serverId;
                option.textContent = file.filename;
                document.getElementById('primary_image').appendChild(option);
            }
        },
        onremovefile: (file) => {
            const fileIndex = uploadedImages.indexOf(file.serverId);
            if (fileIndex !== -1) {
                uploadedImages.splice(fileIndex, 1); // Remove file path
                document.getElementById('uploadedImages').value = JSON.stringify(uploadedImages);
                const primaryImageDropdown = document.getElementById('primary_image');
                for (const option of primaryImageDropdown.options) {
                    if (option.value === file.serverId) {
                        option.remove();
                        break;
                    }
                }
            }
        },
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add Arabic Feature
        document.getElementById('add-ar-feature').addEventListener('click', function () {
            const wrapper = document.getElementById('ar-features-wrapper');
            const newInput = `
                <div class="input-group mb-2">
                    <input type="text" name="ar_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" />
                    <button type="button" class="btn btn-danger remove-feature">-</button>
                </div>`;
            wrapper.insertAdjacentHTML('beforeend', newInput);
        });

        // Add English Feature
        document.getElementById('add-en-feature').addEventListener('click', function () {
            const wrapper = document.getElementById('en-features-wrapper');
            const newInput = `
                <div class="input-group mb-2">
                    <input type="text" name="en_features[]" class="form-control" placeholder="{{ __('lang.enter_feature') }}" />
                    <button type="button" class="btn btn-danger remove-feature">-</button>
                </div>`;
            wrapper.insertAdjacentHTML('beforeend', newInput);
        });

        // Remove Feature
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-feature')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>


@endpush

@push('css')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
