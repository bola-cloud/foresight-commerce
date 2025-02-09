@extends('layouts.app')

@section('content')

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title d-flex">{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 {{ app()->getLocale() === 'ar' ? 'd-flex justify-content-end' : 'justify-content-start' }}">
                    <ul class="breadcrumb-nav" dir="ltr">
                        <li><a href=""><i class="lni lni-home"></i> {{ __('lang.home') }}</a></li>
                        <li><a href="">{{ __('lang.shop') }}</a></li>
                        <li>{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <!-- Product Images -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                @if (!empty($product->images))
                                    <div class="main-img">
                                        <img src="{{ collect($product->images)->firstWhere('primary', true)['url'] ?? $product->images[0]['url'] }}" height="400" id="current" alt="{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}">
                                    </div>
                                    <div class="images">
                                        @foreach ($product->images as $image)
                                            <img src="{{ $image['url'] }}" class="img" alt="{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}">
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Fallback if no images are available -->
                                    <img src="{{ asset('theme/assets/images/products/default.jpg') }}" class="img-thumbnail" alt="No image available">
                                @endif
                            </main>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}</h2>
                            <p class="category"><i class="lni lni-tag"></i> {{ __('lang.category') }}:
                                <a href="#">{{ app()->getLocale() === 'ar' ? $product->category->ar_name ?? 'غير مصنف' : $product->category->en_name ?? 'Uncategorized' }}</a>
                            </p>
                            <h3 class="price">${{ number_format($product->price, 2) }}</h3>
                            <p class="info-text">{{ app()->getLocale() === 'ar' ? $product->ar_description : $product->en_description }}</p>
                            <div class="bottom-content">
                                <div class="row align-items-end">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="button cart-button">
                                            <button class="btn" style="width: 100%;">{{ __('lang.add_to_cart') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="wish-button">
                                            <button class="btn"><i class="lni lni-heart"></i> {{ __('lang.to_wishlist') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Info -->
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>{{ __('lang.details') }}</h4>
                                <p>{{ app()->getLocale() === 'ar' ? $product->ar_description : $product->en_description }}</p>
                                <h4>{{ __('lang.features') }}</h4>
                                <ul class="features">
                                    @php
                                        $features = app()->getLocale() === 'ar'
                                            ? (is_string($product->ar_features) ? json_decode($product->ar_features, true) : $product->ar_features)
                                            : (is_string($product->en_features) ? json_decode($product->en_features, true) : $product->en_features);
                                    @endphp

                                    @if (!empty($features))
                                        @foreach ($features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ __('lang.no_features') }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info-body">
                                <h4>{{ __('lang.specifications') }}</h4>
                                <ul class="normal-list">
                                    <li><span>{{ __('lang.manufacturer') }}:</span> {{ app()->getLocale() === 'ar' ? $product->ar_manufacturer : $product->en_manufacturer }}</li>
                                    <li><span>{{ __('lang.price') }}:</span> ${{ number_format($product->price, 2) }}</li>
                                    <li><span>{{ __('lang.quantity') }}:</span> {{ $product->quantity }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Item Details -->

@endsection
@push('js')
<script type="text/javascript">
    const current = document.getElementById("current");
    const opacity = 0.6;
    const imgs = document.querySelectorAll(".img");
    imgs.forEach(img => {
        img.addEventListener("click", (e) => {
            //reset opacity
            imgs.forEach(img => {
                img.style.opacity = 1;
            });
            current.src = e.target.src;
            //adding class
            //current.classList.add("fade-in");
            //opacity
            e.target.style.opacity = opacity;
        });
    });
</script>
@endpush
