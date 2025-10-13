@extends('themes.torganic.layouts.app')

@section('title', isset($homePage) ? $homePage->store_name : config('app.name'))
@section('description', isset($homePage) ? $homePage->description : '')

@section('content')
<!-- Banner Section -->
@if(isset($homePage) && $homePage->hero_enabled)
<section class="banner banner--style2">
    <div class="container">
        <div class="banner__inner">
            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="banner__wrapper" style="background-image: url({{ $homePage->hero_image ? asset('storage/' . $homePage->hero_image) : ($homePage->hero_background_image ? asset('storage/' . $homePage->hero_background_image) : asset('themes/torganic/assets/images/banner/home2/1.png')) }}); background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: 400px; border-radius: 1.5rem; position: relative;">
                        <!-- Overlay for better text readability -->
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.3); border-radius: 1.5rem;"></div>
                        <div class="row align-items-center g-5" style="position: relative; z-index: 2; padding: 2rem;">
                            <div class="col-lg-3 col-md-5">
                                <div class="banner__thumb" data-aos="fade-up" data-aos-duration="1000" style="width: 100%; height: 100%; min-height: 300px;">
                                    @if($homePage->hero_image)
                                        <!-- <img src="{{ asset('storage/' . $homePage->hero_image) }}" alt="banner" class="dark" style="width: 100%; height: 100%; object-fit: cover; border-radius: 1rem;"> -->
                                    @elseif($homePage->hero_background_image)
                                        <!-- <img src="{{ asset('storage/' . $homePage->hero_background_image) }}" alt="banner" class="dark" style="width: 100%; height: 100%; object-fit: cover; border-radius: 1rem;"> -->
                                    @elseif(\App\Models\Setting::get('store_logo'))
                                        <img src="{{ asset('storage/' . \App\Models\Setting::get('store_logo')) }}" alt="{{ \App\Models\Setting::get('store_name', 'Store Logo') }}" class="dark" style="width: 100%; height: 100%; object-fit: contain; padding: 20px; background: rgba(255, 255, 255, 0.9); border-radius: 1rem;">
                                    @else
                                        <div style="width: 100%; height: 100%; min-height: 300px; background: rgba(255, 255, 255, 0.9); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-store" style="font-size: 4rem; color: var(--brand-color);"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-7">
                                <div class="banner__content" data-aos="fade-right" data-aos-duration="800" style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                                    <h1 class="banner__content-heading" style="color: white;">
                                        {{ $homePage->hero_title ?? 'منتجات طازجة لحياة صحية' }}
                                    </h1>
                                    <p class="banner__content-moto" style="color: rgba(255,255,255,0.9);">
                                        {{ $homePage->hero_subtitle ?? $homePage->hero_description ?? 'نوفر لك أفضل المنتجات العضوية الطازجة' }}
                                    </p>
                                    @if($homePage->hero_button1_text && $homePage->hero_button1_link)
                                        <a href="{{ $homePage->hero_button1_link }}" class="trk-btn trk-btn--secondary" style="background: white; color: var(--brand-color); border: 2px solid white;">
                                            {{ $homePage->hero_button1_text }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                        </a>
                                    @else
                                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--secondary" style="background: white; color: var(--brand-color); border: 2px solid white;">
                                            تسوق الآن <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-12">
                            <div class="sale-banner__item sale-banner__item--home2">
                                <div class="sale-banner__item-inner" style="background-image: url({{ asset('themes/torganic/assets/images/banner/home2/2.png') }});">
                                    <div class="sale-banner__item-content">
                                        <span class="sale-banner__offer">30% خصم</span>
                                        <h3 class="sale-banner__title">منتجات عضوية صحية ومتميزة</h3>
                                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--outline">تسوق الآن</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            <div class="sale-banner__item sale-banner__item--home2">
                                <div class="sale-banner__item-inner" style="background-image: url({{ asset('themes/torganic/assets/images/banner/home2/3.png') }});">
                                    <div class="sale-banner__item-content">
                                        <span class="sale-banner__offer">50% خصم</span>
                                        <h3 class="sale-banner__title">حلويات طبيعية ولذيذة</h3>
                                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--outline">تسوق الآن</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner__shape banner__shape--home2">
        <span class="banner__shape-item banner__shape-item--1"><img src="{{ asset('themes/torganic/assets/images/banner/home2/chilli.png') }}" alt="shape icon"></span>
        <span class="banner__shape-item banner__shape-item--2"><img src="{{ asset('themes/torganic/assets/images/banner/home2/tomato.png') }}" alt="shape icon"></span>
        <span class="banner__shape-item banner__shape-item--5"><img src="{{ asset('themes/torganic/assets/images/banner/home2/radish.png') }}" alt="shape icon"></span>
    </div>
</section>
@endif

<!-- Featured Categories -->
@if(isset($categories) && $categories->isNotEmpty())
<section class="featured-categories padding-top padding-bottom" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10">الأقسام المميزة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn featured-categories__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn featured-categories__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>

        <div class="featured-categories__slider swiper">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                <div class="swiper-slide">
                    <div class="featured-categories__item">
                        <div class="featured-categories__item-inner {{ $loop->first ? 'active' : '' }}">
                            <div class="featured-categories__thumb">
                                @if($category->icon)
                                    <div class="w-16 h-16 rounded-full {{ $category->bg_color ? 'bg-[' . $category->bg_color . ']/20' : 'bg-primary/20' }} flex items-center justify-center">
                                        <i class="{{ $category->icon }} {{ $category->bg_color ? 'text-[' . $category->bg_color . ']' : 'text-primary' }} text-3xl"></i>
                                    </div>
                                @elseif($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="width: 64px; height: 64px; object-fit: contain;">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center">
                                        <i class="fa-solid fa-folder text-primary text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="featured-categories__content">
                                <h4><a href="{{ route('products.index', ['category' => $category->id]) }}" class="stretched-link">{{ $category->name }}</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Flash Sales -->
@if(isset($flashSaleProducts) && $flashSaleProducts->isNotEmpty())
<section class="product padding-top padding-bottom section-bg">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10 me-30">عروض محدودة</h2>
            </div>
            <div class="product-btn order-sm-2 order-lg-3">
                <a class="trk-btn trk-btn--sm" href="{{ route('products.index') }}">عرض الكل</a>
            </div>
        </div>
        <div class="product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-4">
                @foreach($flashSaleProducts->take(2) as $product)
                <div class="col-lg">
                    <div class="product__item product__item--style11">
                        <div class="product__item-inner">
                            @if($product->discount_percentage > 0)
                            <div class="product__item-badge">
                                -{{ $product->discount_percentage }}%
                            </div>
                            @endif
                            <div class="product__item-thumb">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('themes/torganic/assets/images/product/flash/1.png') }}" alt="{{ $product->name }}">
                                @endif
                            </div>
                            <div class="product__item-content">
                                <h4><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h4>
                                <div class="product__item-rating">
                                    <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                                </div>
                                <div class="product__item-footer">
                                    <div class="product__item-price">
                                        <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                        @if($product->original_price > $product->price)
                                        <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                        @endif
                                    </div>
                                    <div class="product__item-action">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Sale Banners -->
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-3">
                <div class="col-xl-3 col-md-6 order-1">
                    <div class="sale-banner__item sale-banner__item--style5">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-content">
                                <h4 class="sale-banner__title">عسل نقي طبيعي</h4>
                                <a href="{{ route('products.index') }}" class="text-btn">تسوق الآن</a>
                            </div>
                            <div class="sale-banner__item-thumb">
                                <img src="{{ asset('themes/torganic/assets/images/product/sale-banner/5.png') }}" alt="عسل طبيعي">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 order-sm-3 order-xl-2">
                    <div class="sale-banner__item sale-banner__item--style4">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                <img src="{{ asset('themes/torganic/assets/images/product/sale-banner/4.png') }}" alt="banner">
                                <div class="sale-banner__item-discount-badge sale-banner__item-discount-badge--style3">
                                    <span class="sale-banner__discount-text">خصم يصل إلى</span>
                                    <h4 class="sale-banner__discount-amount">20%</h4>
                                </div>
                            </div>
                            <div class="sale-banner__item-content">
                                <h6>عرض لفترة محدودة</h6>
                                <h3>مجموعة البقالة الفاخرة</h3>
                                <a href="{{ route('products.index') }}" class="trk-btn trk-btn--sm mt-3">تسوق الآن <span><i class="fa-solid fa-arrow-right-long"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 order-sm-2 order-xl-3">
                    <div class="sale-banner__item sale-banner__item--style52">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-content">
                                <h4 class="sale-banner__title">زبدة لوز عضوية</h4>
                                <a href="{{ route('products.index') }}" class="text-btn text-btn--sm">تسوق الآن</a>
                            </div>
                            <div class="sale-banner__item-thumb">
                                <img src="{{ asset('themes/torganic/assets/images/product/sale-banner/6.png') }}" alt="زبدة لوز">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Products with Tabs -->
<section class="popular-product padding-top padding-bottom">
    <div class="container">
        <div class="popular-product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="popular-product__header section-header">
                <h2 class="popular-product__title order-sm-1">المنتجات الشائعة</h2>
                <div class="popular-product__filters order-sm-3 order-lg-2">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">الكل</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-new-arrivals-tab" data-bs-toggle="pill" data-bs-target="#pills-new-arrivals" type="button" role="tab" aria-controls="pills-new-arrivals" aria-selected="false">وصل حديثاً</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-features-tab" data-bs-toggle="pill" data-bs-target="#pills-features" type="button" role="tab" aria-controls="pills-features" aria-selected="false">مميز</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-best-sellers-tab" data-bs-toggle="pill" data-bs-target="#pills-best-sellers" type="button" role="tab" aria-controls="pills-best-sellers" aria-selected="false">الأكثر مبيعاً</button>
                        </li>
                    </ul>
                </div>
                <div class="product-btn order-sm-2 order-lg-3">
                    <a class="trk-btn trk-btn--sm" href="{{ route('products.index') }}">عرض الكل</a>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <!-- All Products Tab -->
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($popularProducts) && $popularProducts->isNotEmpty())
                            @foreach($popularProducts as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner {{ $loop->index == 1 ? 'active' : '' }}">
                                        @if($product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if(isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- New Arrivals Tab -->
                <div class="tab-pane fade" id="pills-new-arrivals" role="tabpanel" aria-labelledby="pills-new-arrivals-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($newArrivals) && $newArrivals->isNotEmpty())
                            @foreach($newArrivals as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        @if($product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- Featured Tab -->
                <div class="tab-pane fade" id="pills-features" role="tabpanel" aria-labelledby="pills-features-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
                            @foreach($featuredProducts as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- Best Sellers Tab -->
                <div class="tab-pane fade" id="pills-best-sellers" role="tabpanel" aria-labelledby="pills-best-sellers-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($bestSellers) && $bestSellers->isNotEmpty())
                            @foreach($bestSellers as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sale Banners (Second Section) -->
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="sale-banner__item sale-banner__item--style2">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                <img src="{{ asset('themes/torganic/assets/images/product/sale-banner/2.png') }}" alt="منتجات بحرية">
                            </div>
                            <div class="sale-banner__item-content">
                                <span class="sale-banner__offer">خصم 10%</span>
                                <h3 class="sale-banner__title">منتجات بحرية مميزة</h3>
                                <p class="sale-banner__description">اكتشف عالماً من النكهات الرائعة مع منتجاتنا البحرية</p>
                                <a href="{{ route('products.index') }}" class="trk-btn trk-btn--md">تسوق الآن <span><i class="fa-solid fa-arrow-right-long"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sale-banner__item sale-banner__item--style22">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                <img src="{{ asset('themes/torganic/assets/images/product/sale-banner/3.png') }}" alt="فواكه طازجة">
                                <div class="sale-banner__item-discount-badge sale-banner__item-discount-badge--style2">
                                    <span class="sale-banner__discount-text">خصم حتى</span>
                                    <h4 class="sale-banner__discount-amount">20%</h4>
                                    <span class="sale-banner__discount-text">خصم</span>
                                </div>
                            </div>
                            <div class="sale-banner__item-content">
                                <span class="sale-banner__offer">أفضل عرض اليوم</span>
                                <h3 class="sale-banner__title">فواكه صحية</h3>
                                <p class="sale-banner__description">استمتع بخيرات الطبيعة مع فواكهنا الطازجة</p>
                                <a href="{{ route('products.index') }}" class="trk-btn trk-btn--md">تسوق الآن <span><i class="fa-solid fa-arrow-right-long"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Listing Section (Top Selling, Trending, New) -->
<section class="product-listing padding-bottom padding-top section-bg">
    <div class="container">
        <div class="product-listing__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row align-items-center justify-content-center g-5 g-lg-4">
                <!-- Top Selling -->
                <div class="col-lg-4 col-md-6">
                    <div class="row g-3">
                        <h2>الأكثر مبيعاً</h2>
                        @if(isset($topSellingProducts) && $topSellingProducts->isNotEmpty())
                            @foreach($topSellingProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->index == 1 && isset($product->discount_percentage) && $product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if($loop->index == 1 && isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/1.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Trending Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="row g-3">
                        <h2>المنتجات الرائجة</h2>
                        @if(isset($trendingProducts) && $trendingProducts->isNotEmpty())
                            @foreach($trendingProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->index == 1)
                                        <div class="product__item-badge product__item-badge--new">جديد</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 4) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/4.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- New Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="row g-3">
                        <h2>منتجات جديدة</h2>
                        @if(isset($newProducts) && $newProducts->isNotEmpty())
                            @foreach($newProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->first && isset($product->discount_percentage) && $product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 7) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if($loop->first && isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/7.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sale Banner Long Section -->
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="sale-banner__item sale-banner__item--style1">
                <div class="sale-banner__item-inner">
                    <div class="sale-banner__item-thumb">
                        <img class="sale-banner__image" src="{{ asset('themes/torganic/assets/images/product/sale-banner/1.png') }}" alt="خضروات طازجة">
                        <div class="sale-banner__item-discount-badge">
                            <span>خصم حتى</span>
                            <h3 class="sale-banner__discount-amount">20%</h3>
                            <span>خصم</span>
                        </div>
                    </div>
                    <div class="sale-banner__item-content">
                        <h2>تخفيضات كبرى على الخضروات</h2>
                        <p>اكتشف عالماً من المنتجات الطازجة، والأساسيات، والمزيد في متناول يدك.</p>
                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--md mt-3">تسوق الآن <span><i class="fa-solid fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- bg-shape -->
    <div class="sale-banner__shape">
        <span class="sale-banner__shape-item sale-banner__shape-item--1"><img src="{{ asset('themes/torganic/assets/images/product/sale-banner/leaf-1.png') }}" alt="shape icon"></span>
        <span class="sale-banner__shape-item sale-banner__shape-item--2"><img src="{{ asset('themes/torganic/assets/images/product/sale-banner/leaf-2.png') }}" alt="shape icon"></span>
    </div>
</section>

<!-- Featured Products Slider -->
<section class="product-feature padding-bottom">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10">المنتجات المميزة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn product__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn product__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="product-feature__slider swiper">
                <div class="swiper-wrapper">
                    @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
                        @foreach($featuredProducts as $product)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                    <div class="product__item-content">
                                        <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                        <div class="product__item-rating">
                                            <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.9 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                        </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @elseif(isset($popularProducts))
                        @foreach($popularProducts->take(6) as $product)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                    <div class="product__item-content">
                                        <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
                                        <div class="product__item-rating">
                                            <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }}
                                        </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @for($i = 6; $i <= 10; $i++)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        <img src="{{ asset('themes/torganic/assets/images/product/popular/' . $i . '.png') }}" alt="منتج مميز">
                                    </div>
                                    <div class="product__item-content">
                                        <h5><a href="{{ route('products.index') }}">منتج مميز {{ $i - 5 }}</a></h5>
                                        <div class="product__item-rating">
                                            <i class="fa-solid fa-star"></i> 4.5 <span>({{ rand(10, 100) }})</span>
                                        </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format(rand(20, 40), 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <a class="trk-btn trk-btn--outline" href="{{ route('products.index') }}">تصفح</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog padding-top padding-bottom section-bg">
    <div class="container">
        <div class="section-header d-md-flex align-items-center justify-content-between">
            <div class="section-header__content">
                <h2 class="mb-10">مقالات منتظمة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn blog__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn blog__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="blog__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="blog__slider swiper">
                <div class="swiper-wrapper">
                    @if(isset($blogs) && $blogs->isNotEmpty())
                        @foreach($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="blog__item blog__item--style2">
                                <div class="blog__item-inner">
                                    <div class="blog__thumb">
                                        @if($blog->image)
                                            <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/blog/' . (($loop->index % 3) + 1) . '.png') }}" alt="{{ $blog->title }}">
                                        @endif
                                    </div>
                                    <div class="blog__content">
                                        <div class="blog__meta">
                                            <a href="#"><span class="blog__meta-tag blog__meta-tag--style{{ ($loop->index % 3) + 1 }}">{{ $blog->category ?? 'مقالات' }}</span></a>
                                        </div>
                                        <h4><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></h4>
                                        <div class="blog__admin">
                                            <div class="blog__admin-name">
                                                <span><i class="fa-regular fa-user"></i></span> {{ $blog->author ?? 'المدير' }}
                                            </div>
                                            <div class="blog__admin-date">
                                                <span><i class="fa-regular fa-calendar-check"></i></span> {{ $blog->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @for($i = 1; $i <= 3; $i++)
                        <div class="swiper-slide">
                            <div class="blog__item blog__item--style2">
                                <div class="blog__item-inner">
                                    <div class="blog__thumb">
                                        <img src="{{ asset('themes/torganic/assets/images/blog/' . $i . '.png') }}" alt="مقالة">
                                    </div>
                                    <div class="blog__content">
                                        <div class="blog__meta">
                                            <a href="#"><span class="blog__meta-tag blog__meta-tag--style{{ $i }}">{{ $i == 1 ? 'نصائح صحية' : ($i == 2 ? 'صحة' : 'خضروات') }}</span></a>
                                        </div>
                                        <h4><a href="#">{{ $i == 1 ? 'دليل شامل للتسوق الفعال' : ($i == 2 ? 'نصائح للتسوق الصحي' : 'اختيار المنتجات الطازجة') }}</a></h4>
                                        <div class="blog__admin">
                                            <div class="blog__admin-name">
                                                <span><i class="fa-regular fa-user"></i></span> المدير
                                            </div>
                                            <div class="blog__admin-date">
                                                <span><i class="fa-regular fa-calendar-check"></i></span> {{ date('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
        <div class="section-btn mt-4 text-center">
            <a class="trk-btn trk-btn--primary" href="#">عرض المزيد</a>
        </div>
    </div>
</section>

<!-- Feature Bar -->
<div class="feature-bar border-top">
    <div class="container">
        <div class="row py-3 g-5 g-lg-4 justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/1.png') }}" alt="توصيل سريع">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">توصيل سريع</h3>
                        <p class="feature-bar__description fs-7 mb-0">لطلبات أكثر من 40 ريال</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/2.png') }}" alt="دعم 24/7">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دعم 24/7</h3>
                        <p class="feature-bar__description fs-7 mb-0">تواصل معنا في أي وقت</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/3.png') }}" alt="دفع آمن">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دفع آمن</h3>
                        <p class="feature-bar__description fs-7 mb-0">100% دفع آمن ومضمون</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/4.png') }}" alt="استرجاع سهل">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">استرجاع سهل</h3>
                        <p class="feature-bar__description fs-7 mb-0">خلال 30 يوم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Featured Categories Slider
    const featuredCategoriesSlider = new Swiper('.featured-categories__slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.featured-categories__slider-next',
            prevEl: '.featured-categories__slider-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 6,
            },
        },
    });

    // Initialize Featured Products Slider
    const featuredProductsSlider = new Swiper('.product-feature__slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.product__slider-next',
            prevEl: '.product__slider-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1280: {
                slidesPerView: 5,
            },
        },
    });

    // Initialize Blog Slider
    const blogSlider = new Swiper('.blog__slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: '.blog__slider-next',
            prevEl: '.blog__slider-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endpush