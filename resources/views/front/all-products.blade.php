@extends('layouts.app')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title d-flex">{{ __('lang.products') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 {{ app()->getLocale() === 'ar' ? 'd-flex justify-content-end' : 'justify-content-start' }}">
                    <ul class="breadcrumb-nav" dir="ltr">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('lang.home') }}</a></li>
                        <li>{{ __('lang.products') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Product Grids -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Sidebar -->
                    <div class="product-sidebar">
                        <!-- Search -->
                        <div class="single-widget search">
                            <h3>{{ __('lang.search_product') }}</h3>
                            <form action="{{ route('products.index') }}" method="GET">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('lang.search_placeholder') }}">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>

                        <!-- Categories -->
                        <div class="single-widget">
                            <h3>{{ __('lang.categories') }}</h3>
                            <ul class="list">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('products.filterByCategory', $cat->id) }}">
                                            {{ app()->getLocale() === 'ar' ? $cat->ar_name : $cat->en_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <div class="product-sorting">
                                        <form action="{{ route('products.index') }}" method="GET">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                            <label for="sorting">Sort by:</label>
                                            <select class="form-control" name="sort" onchange="this.form.submit()">
                                                <option value="">Default</option>
                                                <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                                                <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="row">
                            @forelse($products as $product)
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-image">
                                            @php
                                                $primaryImage = collect($product->images)->firstWhere('primary', true)['url'] ?? $product->images[0]['url'] ?? 'path/to/default.jpg';
                                            @endphp
                                            <img src="{{ $primaryImage }}" alt="{{ $product->en_name }}" height="250">
                                        </div>
                                        <div class="product-info">
                                            <h4 class="title">
                                                <a href="{{route('product.details',$product->id)}}">{{ app()->getLocale() === 'ar' ? $product->ar_name : $product->en_name }}</a>
                                            </h4>
                                            <div class="price">
                                                ${{ number_format($product->price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No products found.</p>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="pagination left">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Grids -->
@endsection
