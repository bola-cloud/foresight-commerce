@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">{{ __('lang.blogs') }}</h2>
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    @if ($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{!! Str::limit(strip_tags($blog->content), 150) !!}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-primary">{{ __('lang.read_more') }}</a>
                    </div>
                    <div class="card-footer text-muted">
                        {{ __('lang.posted_on') }} {{ $blog->created_at->format('d M, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $blogs->links() }} <!-- Pagination -->
    </div>
</div>
@endsection
