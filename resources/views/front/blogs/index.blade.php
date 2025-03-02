@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-end">{{ __('lang.blogs') }}</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4"> <!-- 3 Columns Layout -->
        @foreach ($blogs as $blog)
            <div class="col d-flex align-items-stretch"> <!-- Ensures all cards are the same height -->
                <div class="card shadow-sm h-100" style="max-width: 350px; width: 100%;"> <!-- Fixed width cards -->
                    @if ($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top img-fluid" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background-color: #f8f9fa;">
                            <p class="text-muted">{{ __('lang.no_image_available') }}</p>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $blog->title }}</h5>
                        <p class="card-text flex-grow-1 text-center">{!! Str::limit(strip_tags($blog->content), 100) !!}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-primary mt-auto">{{ __('lang.read_more') }}</a>
                    </div>

                    <div class="card-footer text-muted text-center">
                        {{ __('lang.posted_on') }} {{ $blog->created_at->format('d M, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links() }} <!-- Pagination -->
    </div>
</div>
@endsection
