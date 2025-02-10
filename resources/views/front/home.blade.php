@extends('layouts.app')

@section('content')

<style>
    .single-slider {
        position: relative;
        background-size: cover;
        background-position: center;
        height: 400px; /* Adjust height as per your requirement */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .single-slider .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0 0 0 / 0%); /* Adjust the opacity */
        z-index: 1;
    }

    .single-slider .content {
        position: relative;
        z-index: 2;
        color: #fff; /* Ensure the text is readable on the dark overlay */
        text-align: center;
    }
    .hero-area .hero-slider .single-slider .content h2 span{
        color: #0167f3a3;
    }

    .hero-area .hero-slider .single-slider .content h3 span{
        color: #dc3545;
    }
</style>
    <!-- Start Hero Area -->
    <section class="hero-area" dir="ltr">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            @foreach($sliders as $slider)
                                <!-- Start Single Slider -->
                                <div class="single-slider position-relative" style="background-image: url({{ asset('storage/' . $slider->image) }});">
                                    <!-- Dark Layer -->
                                    <div class="overlay"></div>
                                    <div class="content">
                                        <h2 style="color: #fff !important;">
                                            <span>{{ app()->getLocale() === 'ar' ? $slider->ar_title : $slider->en_title }}</span>
                                            {{ $slider->brand }}
                                        </h2>
                                        <p>{{ app()->getLocale() === 'ar' ? $slider->ar_description : $slider->en_description }}</p>
                                        <h3>
                                            <span>{{ __('lang.now_only') }}</span> ${{ number_format($slider->price, 2) }}
                                        </h3>
                                        <div class="button">
                                            <a href="{{ route('products.index') }}" class="btn">{{ __('lang.shop_now') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slider -->
                            @endforeach
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('lang.trending_product_title') }}</h2>
                        {{-- <p>{{ __('lang.trending_product_desc') }}</p> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <!-- Display product's primary image -->
                                @if (!empty($product->images))
                                    @php
                                        $primaryImage = collect($product->images)->firstWhere('primary', true)['url'] ?? $product->images[0]['url'];
                                    @endphp
                                    <img src="{{ $primaryImage }}" alt="{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}" height="260">
                                @else
                                    <!-- Fallback image if no images are available -->
                                    <img src="{{ asset('theme/assets/images/products/default.jpg') }}" alt="No image available">
                                @endif

                                <div class="button">
                                    <a href="{{ route('product.details', $product->id) }}" class="btn">
                                        <i class="lni lni-cart"></i> {{ __('lang.add_to_cart') }}
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
                                <!-- Display product's category -->
                                <span class="category">
                                    {{ app()->getLocale() === 'ar' ? $product->category->ar_name ?? 'غير مصنف' : $product->category->en_name ?? 'Uncategorized' }}
                                </span>
                                <h4 class="title">
                                    <!-- Display product's name -->
                                    <a href="{{ route('product.details', $product->id) }}">
                                        {{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}
                                    </a>
                                </h4>
                                <ul class="review">
                                    <!-- Static reviews for now -->
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star"></i></li>
                                    <li><span>4.0 Review(s)</span></li>
                                </ul>
                                <div class="price">
                                    <!-- Display product's price -->
                                    <span>${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{ __('lang.shipping_title') }}</h5>
                        <span>{{ __('lang.shipping_desc') }}</span>
                    </div>
                </li>
                <!-- 24/7 Support -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{ __('lang.support_title') }}</h5>
                        <span>{{ __('lang.support_desc') }}</span>
                    </div>
                </li>
                <!-- Online Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{ __('lang.online_payment_title') }}</h5>
                        <span>{{ __('lang.online_payment_desc') }}</span>
                    </div>
                </li>
                <!-- Easy Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{ __('lang.easy_return_title') }}</h5>
                        <span>{{ __('lang.easy_return_desc') }}</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->


@endsection

