@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.edit_blog') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ar_title">{{ __('lang.ar_title') }}</label>
            <input type="text" name="ar_title" class="form-control" value="{{ old('ar_title', $blog->ar_title) }}" required>
        </div>

        <div class="form-group">
            <label for="en_title">{{ __('lang.en_title') }}</label>
            <input type="text" name="en_title" class="form-control" value="{{ old('en_title', $blog->en_title) }}" required>
        </div>

        <div class="form-group">
            <label for="ar_content">{{ __('lang.ar_content') }}</label>
            <textarea name="ar_content" class="form-control tinymce-editor" required>{{ old('ar_content', $blog->ar_content ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="en_content">{{ __('lang.en_content') }}</label>
            <textarea name="en_content" class="form-control tinymce-editor" required>{{ old('en_content', $blog->en_content ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">{{ __('lang.image') }}</label>
            <input type="file" name="image" class="form-control">
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ __('lang.update') }}</button>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">{{ __('lang.cancel') }}</a>
    </form>
</div>
@endsection
