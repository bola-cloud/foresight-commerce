@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <h1>{{ __('lang.add_blog') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="ar_title">{{ __('lang.ar_title') }}</label>
            <input type="text" name="ar_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="en_title">{{ __('lang.en_title') }}</label>
            <input type="text" name="en_title" class="form-control" required>
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
        </div>

        <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
    </form>
</div>
@endsection
