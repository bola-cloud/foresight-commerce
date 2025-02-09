@extends('layouts.app')

@section('title', __('lang.title'))

@section('content')
    <style>
        .about-us .content-left img {
            width: 500px;
            border-radius: 4px;
            height: 190px;
        }
    </style>
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title d-flex">{{ __('lang.page_title') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 {{ app()->getLocale() === 'ar' ? 'd-flex justify-content-end' : 'justify-content-start' }}">
                    <ul class="breadcrumb-nav" dir="ltr">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('lang.home') }}</a></li>
                        <li>{{ __('lang.page_title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start About Area -->
    <section class="about-us section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo Image -->
                <div class="col-lg-6 col-md-12 col-12 mb-4 mb-lg-0">
                    <div class="content-left text-center">
                        <img src="{{ asset('theme/assets/images/logo/white tiger.jpeg') }}" class="img-fluid rounded shadow" alt="{{ __('lang.company_name') }}">
                    </div>
                    <div class="content-left text-center mt-3">
                        <img src="{{ asset('theme/assets/images/logo/logo labpyam celeste bordes.png') }}" class="img-fluid rounded shadow" alt="{{ __('lang.company_name') }}">
                    </div>
                </div>
                <!-- Text Content -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="content-right">
                        <h2 class="mb-4 fw-bold">{{ __('lang.about_heading') }}</h2>
                        <p class="mb-3 text-muted">{{ __('lang.about_description_1') }}</p>
                        <p class="mb-4 text-muted">{{ __('lang.about_description_2') }}</p>
                        <p class="mb-4 text-muted">
                            {{ __('lang.additional_services') }}
                        </p>
                        <div class="company-highlight p-4 bg-light rounded shadow-sm">
                            <h4 class="mb-3 fw-bold">{{ __('lang.company_name') }}</h4>
                            <p class="text-muted mb-3">
                                {{ __('lang.about_highlight_1') }}
                            </p>
                            <p class="text-muted">
                                {{ __('lang.about_highlight_2') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

@endsection
