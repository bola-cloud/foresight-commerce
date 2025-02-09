@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('lang.ad_list') }}</h1>
        <a href="{{ route('admin.adsliders.create') }}" class="btn btn-primary mb-3">{{ __('lang.add_ad') }}</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('lang.image') }}</th>
                <th>{{ __('lang.brand') }}</th>
                <th>{{ __('lang.ar_title') }}</th>
                <th>{{ __('lang.en_title') }}</th>
                <th>{{ __('lang.price') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adSliders as $adSlider)
                <tr>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $adSlider->id }}">
                            <img src="{{ asset('storage/' . $adSlider->image) }}" alt="Ad Image" class="img-thumbnail fixed-height">
                        </a>
                    </td>
                    <td>{{ $adSlider->brand }}</td>
                    <td>{{ $adSlider->ar_title }}</td>
                    <td>{{ $adSlider->en_title }}</td>
                    <td>{{ $adSlider->price ? '$' . $adSlider->price : __('lang.not_available') }}</td>
                    <td>
                        <a href="{{ route('admin.adsliders.edit', $adSlider) }}" class="btn btn-warning btn-sm">{{ __('lang.edit') }}</a>
                        <form action="{{ route('admin.adsliders.destroy', $adSlider) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('lang.confirm_delete') }}')">
                                {{ __('lang.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Image Modal -->
                <div class="modal fade" id="imageModal{{ $adSlider->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $adSlider->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $adSlider->id }}">{{ __('lang.image') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $adSlider->image) }}" alt="Ad Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('css')
<style>
    /* Fixed height for images in the table */
    .fixed-height {
        height: 70px; /* Set the fixed height */
        object-fit: cover; /* Ensures the image maintains aspect ratio and fills the area */
    }
</style>
@endpush
