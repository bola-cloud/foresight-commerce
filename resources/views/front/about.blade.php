@extends('layouts.app')

@section('title', __('lang.title'))

@section('content')
    <style>
        .about-us .content-left img {
            width: 300px;
            border-radius: 4px;
            height: 315px;
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
    <section class="about-us section py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo Image -->
                <div class="col-lg-5 col-md-12 col-12 mb-4 mb-lg-0 text-center">
                    <div class="content-left">
                        <img src="{{ asset('theme/assets/images/logo/logo.jpg') }}"
                            class="img-fluid rounded shadow-lg p-3 bg-white border"
                            alt="{{ __('lang.company_name') }}"
                            style="max-width: 300px; transition: transform 0.3s ease-in-out;"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                </div>

                <!-- Text Content -->
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="content-right">

                        <!-- About Heading -->
                        <div class="card shadow-sm border-0 mb-3 p-4">
                            <h2 class="fw-bold text-primary">{{ __('lang.about_heading') }}</h2>
                            <p class="text-secondary lead">{{ __('lang.about_description_1') }}</p>
                            <p class="text-muted">{{ __('lang.about_description_2') }}</p>
                        </div>

                        <!-- Additional Services -->
                        <div class="card shadow-sm border-0 mb-3 p-4">
                            <p class="text-muted">{{ __('lang.additional_services') }}</p>
                        </div>

                        <!-- Company Highlights -->
                        <div class="card shadow-sm border-0 mb-3 p-4" style="border-left: 4px solid #007bff;">
                            <h4 class="fw-bold text-primary">{{ __('lang.company_name') }}</h4>
                            <p class="text-muted">{{ __('lang.about_highlight_1') }}</p>
                            <p class="text-muted">{{ __('lang.about_highlight_2') }}</p>
                        </div>

                        <!-- Team -->
                        <div class="card shadow-sm border-0 mb-3 p-4" style="border-left: 4px solid #dc3545;">
                            <p class="text-muted">{{ __('lang.team') }}</p>
                        </div>

                        <!-- Partners -->
                        <div class="card shadow-sm border-0 mb-3 p-4" style="border-left: 4px solid #007bff;">
                            <p class="text-muted">{{ __('lang.partners') }}</p>
                        </div>

                        <!-- Previous Work -->
                        <div class="card shadow-sm border-0 p-4" style="border-left: 4px solid #dc3545;">
                            <p class="text-muted">{{ __('lang.previous_work') }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

@endsection
