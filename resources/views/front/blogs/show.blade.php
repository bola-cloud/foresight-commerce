@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="text-center">{{ $blog->title }}</h2>

    @if ($blog->image)
        <div class="text-center my-3">
            <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded" alt="{{ $blog->title }}">
        </div>
    @endif

    <div class="blog-content">
        {!! $blog->content !!}
    </div>

    <hr>
    <p class="text-muted">
        {{ __('lang.posted_on') }} {{ $blog->created_at->format('d M, Y') }}
    </p>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary mt-3">{{ __('lang.back_to_blogs') }}</a>
</div>
@endsection
