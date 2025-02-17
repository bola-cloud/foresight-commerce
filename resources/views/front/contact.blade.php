@extends('layouts.app')

@section('title', __('lang.title'))

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <h3 class="page-title d-flex">{{ __('lang.page_title') }}</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-12 {{ app()->getLocale() === 'ar' ? 'd-flex justify-content-end' : 'justify-content-start' }}">
                    <ul class="breadcrumb-nav list-inline mb-0" dir="ltr">
                        <li class="list-inline-item"><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('lang.home') }}</a></li>
                        <li class="list-inline-item">{{ __('lang.page_title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Contact Section -->
    <section class="contact-us section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-5">
                    <div class="card bg-white shadow p-4 rounded" style="border-radius: 15px;">
                        <div class="card-body">
                            <h3 class="card-title mb-4">{{ __('lang.get_in_touch') }}</h3>
                            <p class="text-muted">{{ __('lang.description') }}</p>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-3">
                                    <i class="lni lni-phone me-2"></i>
                                    <a href="tel:01000808147" class="text-dark" dir="ltr">01000808147</a>
                                </li>
                                <li class="mb-3">
                                    <i class="lni lni-envelope me-2"></i>
                                    <a href="mailto:sales@foresightegypt.com" class="text-dark">sales@foresightegypt.com</a>
                                </li>
                                <li class="mb-3">
                                    <i class="lni lni-map-marker me-2"></i>
                                    <span class="text-dark">46 Farouk El-Naggar</span>
                                </li>
                                <li class="mb-3">
                                    <i class="lni lni-link me-2"></i>
                                    <a href="https://maps.app.goo.gl/gcXQA8kgc98qZFy6A" class="text-dark" target="_blank">
                                        View on Google Maps
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8 col-md-7">
                    <div class="contact-form bg-white shadow p-4 rounded" style="border-radius: 15px;">
                        <h3 style="font-size: 1.8rem; font-weight: bold; color: #333; margin-bottom: 20px;">
                            {{ __('lang.contact_form_title') }}
                        </h3>

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Contact Form -->
                        <form action="{{ route('messages.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label" style="font-weight: bold; color: #666;">
                                    {{ __('lang.contact_form_name_label') }}
                                </label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('lang.contact_form_name_placeholder') }}" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-weight: bold; color: #666;">
                                    {{ __('lang.contact_form_email_label') }}
                                </label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('lang.contact_form_email_placeholder') }}" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label" style="font-weight: bold; color: #666;">
                                    {{ __('lang.contact_form_message_label') }}
                                </label>
                                <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="{{ __('lang.contact_form_message_placeholder') }}" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #007bff, #6a11cb); border: none; padding: 10px 20px; font-weight: bold;">
                                {{ __('lang.contact_form_button') }}
                            </button>
                        </form>
                    </div>
                </div>
                <!-- End Contact Form -->

            </div>

            <!-- Google Maps Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title mb-4 text-center text-primary">Our Location</h3>
                            <div class="map-container" style="border-radius: 8px; overflow: hidden;">
                                <iframe
                                    src="https://maps.google.com/maps?q=46%20Farouk%20El-Naggar&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                    width="100%"
                                    height="400"
                                    style="border:0; border-radius: 8px;"
                                    allowfullscreen=""
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Contact Section -->
@endsection
