@extends('themes.torganic.layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))
@section('description', $product->description ?? $product->name)

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Product Details Section -->
<section class="product-details padding-top padding-bottom">
    <div class="container">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-details__thumb">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @else
                        <img src="{{ asset('themes/torganic/assets/images/product/details/1.png') }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @endif
                </div>
                
                @if($product->images && count($product->images) > 1)
                <div class="product-details__gallery mt-4">
                    <div class="row g-3">
                        @foreach($product->images as $image)
                        <div class="col-3">
                            <img src="{{ Storage::url($image) }}" alt="{{ $product->name }}" class="img-fluid rounded cursor-pointer">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-details__content">
                    <h1 class="product-details__title mb-3">{{ $product->name }}</h1>
                    
                    <!-- Rating -->
                    <div class="product-details__rating mb-3">
                        <div class="product__item-rating">
                            <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} 
                            <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="product-details__price mb-4">
                        <h2 class="price">
                            {{ number_format($product->price, 2) }} ر.س
                            @if($product->original_price && $product->original_price > $product->price)
                            <span class="old-price"><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                            <span class="badge bg-danger ms-2">خصم {{ $product->discount_percentage }}%</span>
                            @endif
                        </h2>
                    </div>

                    <!-- Description -->
                    <div class="product-details__desc mb-4">
                        <h5>الوصف:</h5>
                        <p>{{ $product->description ?? 'منتج عضوي طبيعي وصحي' }}</p>
                    </div>

                    <!-- Stock Status -->
                    <div class="product-details__stock mb-4">
                        @if($product->stock > 0)
                        <span class="badge bg-success">متوفر في المخزون</span>
                        <span class="text-muted">({{ $product->stock }} قطعة متاحة)</span>
                        @else
                        <span class="badge bg-danger">غير متوفر حالياً</span>
                        @endif
                    </div>

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="product-details__form">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="quantity-input form-control">
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <button type="submit" class="trk-btn trk-btn--primary w-100">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> أضف إلى السلة
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                    <!-- Meta Info -->
                    <div class="product-details__meta">
                        <div class="product-details__meta-item">
                            <span class="label">رقم المنتج:</span>
                            <span class="value">#{{ $product->id }}</span>
                        </div>
                        @if($product->category)
                        <div class="product-details__meta-item">
                            <span class="label">القسم:</span>
                            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="value">{{ $product->category->name }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-details__tabs mt-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button">الوصف</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews" type="button">التقييمات ({{ $product->reviews_count ?? 0 }})</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0">
                <div class="tab-pane fade show active" id="description">
                    <h5>تفاصيل المنتج</h5>
                    <p>{{ $product->description ?? 'منتج عضوي طبيعي وصحي، خالٍ من المواد الكيميائية والمبيدات الحشرية.' }}</p>
                </div>
                <div class="tab-pane fade" id="reviews">
                    <h5>آراء العملاء</h5>
                    @if(isset($reviews) && $reviews->isNotEmpty())
                        @foreach($reviews as $review)
                        <div class="review-item mb-4 pb-3 border-bottom">
                            <div class="review-header d-flex justify-content-between">
                                <div>
                                    <strong>{{ $review->user->name }}</strong>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mt-2">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    @else
                    <p class="text-muted">لا توجد تقييمات بعد. كن أول من يقيم هذا المنتج!</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <div class="related-products mt-5">
            <h3 class="mb-4">منتجات ذات صلة</h3>
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 g-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col">
                    <div class="product__item product__item--style2">
                        <div class="product__item-inner">
                            <div class="product__item-thumb">
                                <a href="{{ route('products.show', $relatedProduct->id) }}">
                                    @if($relatedProduct->image)
                                        <img src="{{ Storage::url($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                                    @else
                                        <img src="{{ asset('themes/torganic/assets/images/product/popular/1.png') }}" alt="{{ $relatedProduct->name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="product__item-content">
                                <h5><a href="{{ route('products.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h5>
                                <div class="product__item-price">
                                    <h4>{{ number_format($relatedProduct->price, 2) }} ر.س</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.quantity-selector {
    display: flex;
    align-items: center;
}
.quantity-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    font-size: 18px;
}
.quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    margin: 0 5px;
}
.product-details__meta-item {
    margin-bottom: 10px;
}
.product-details__meta-item .label {
    font-weight: 600;
    margin-left: 10px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    const input = document.querySelector('.quantity-input');
    
    if (minusBtn && plusBtn && input) {
        minusBtn.addEventListener('click', function() {
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let value = parseInt(input.value);
            let max = parseInt(input.max);
            if (value < max) {
                input.value = value + 1;
            }
        });
    }
});
</script>
@endpush

