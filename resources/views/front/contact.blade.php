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
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title mb-4">{{ __('lang.get_in_touch') }}</h3>
                            <p class="text-muted">{{ __('lang.description') }}</p>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-3">
                                    <i class="lni lni-phone me-2"></i>
                                    <a href="tel:+123456789" class="text-dark"  dir="ltr">{{ __('lang.phone') }}</a>
                                </li>
                                <li class="mb-3">
                                    <i class="lni lni-envelope me-2"></i>
                                    <a href="mailto:info@example.com" class="text-dark">{{ __('lang.email') }}</a>
                                </li>
                                <li class="mb-3">
                                    <i class="lni lni-map-marker me-2"></i>
                                    <span class="text-dark">{{ __('lang.address') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8 col-md-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title mb-4">{{ __('lang.form_title') }}</h3>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('lang.form_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control" placeholder="{{ __('lang.form_email') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" rows="5" class="form-control" placeholder="{{ __('lang.form_message') }}" required></textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('lang.form_submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->
@endsection
