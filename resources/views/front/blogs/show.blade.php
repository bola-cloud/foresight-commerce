@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-end">{{ __('lang.blogs_details') }}</h2>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                @if ($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top img-fluid" alt="{{ $blog->title }}" style="height: 300px; object-fit: cover;">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa;">
                        <p class="text-muted">{{ __('lang.no_image_available') }}</p>
                    </div>
                @endif

                <div class="card-body d-flex flex-column" style="min-height: 400px;">
                    <h2 class="text-center">{{ $blog->title }}</h2>
                    <div class="blog-content flex-grow-1 overflow-auto" style="max-height: 300px;">
                        {!! $blog->content !!}
                    </div>
                </div>

                <div class="card-footer text-muted text-center">
                    {{ __('lang.posted_on') }} {{ $blog->created_at->format('d M, Y') }}
                </div>
            </div>

            <a href="{{ route('blogs.index') }}" class="btn btn-secondary mt-3">{{ __('lang.back_to_blogs') }}</a>
        </div>
    </div>
</div>
@endsection
