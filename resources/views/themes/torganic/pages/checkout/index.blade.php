@extends('themes.torganic.layouts.app')

@section('title', 'إتمام الطلب - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">إتمام الطلب</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">السلة</a></li>
                        <li class="breadcrumb-item active" aria-current="page">إتمام الطلب</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Section -->
<section class="checkout padding-top padding-bottom">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row g-4">
                <!-- Billing Details -->
                <div class="col-lg-7">
                    <div class="checkout__form">
                        <h4 class="mb-4">تفاصيل الفواتير والشحن</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">الاسم الأول <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">الاسم الأخير <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="country" class="form-label">الدولة <span class="text-danger">*</span></label>
                                <select name="country" id="country" class="form-select" required>
                                    <option value="">اختر الدولة</option>
                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                                    <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>الكويت</option>
                                    <option value="BH" {{ old('country') == 'BH' ? 'selected' : '' }}>البحرين</option>
                                    <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>قطر</option>
                                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>عمان</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">الرمز البريدي</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}">
                            </div>
                            
                            <div class="col-12">
                                <label for="address" class="form-label">العنوان <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="notes" class="form-label">ملاحظات الطلب (اختياري)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="ملاحظات حول طلبك، مثل تعليمات التوصيل...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="checkout__summary">
                        <h4 class="mb-4">طلبك</h4>
                        
                        <!-- Order Items -->
                        <div class="checkout__items">
                            <div class="checkout__items-header">
                                <span>المنتج</span>
                                <span>المجموع</span>
                            </div>
                            
                            @if(isset($cartItems))
                            @foreach($cartItems as $item)
                            <div class="checkout__item">
                                <div class="checkout__item-info">
                                    <span class="checkout__item-name">{{ $item->product->name }}</span>
                                    <span class="checkout__item-qty">× {{ $item->quantity }}</span>
                                </div>
                                <span class="checkout__item-price">{{ number_format($item->product->price * $item->quantity, 2) }} ر.س</span>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        
                        <!-- Order Totals -->
                        <div class="checkout__totals">
                            <div class="checkout__total-item">
                                <span>المجموع الفرعي:</span>
                                <span>{{ number_format($subtotal ?? 0, 2) }} ر.س</span>
                            </div>
                            
                            <div class="checkout__total-item">
                                <span>الشحن:</span>
                                <span>{{ number_format($shipping ?? 0, 2) }} ر.س</span>
                            </div>
                            
                            @if(isset($discount) && $discount > 0)
                            <div class="checkout__total-item text-success">
                                <span>الخصم:</span>
                                <span>-{{ number_format($discount, 2) }} ر.س</span>
                            </div>
                            @endif
                            
                            <div class="checkout__total-item checkout__total-final">
                                <span>المجموع الكلي:</span>
                                <span>{{ number_format($total ?? 0, 2) }} ر.س</span>
                            </div>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="checkout__payment mt-4">
                            <h5 class="mb-3">طريقة الدفع</h5>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    الدفع عند الاستلام
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                <label class="form-check-label" for="card">
                                    بطاقة ائتمان / مدى
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                <label class="form-check-label" for="bank_transfer">
                                    تحويل بنكي
                                </label>
                            </div>
                        </div>
                        
                        <!-- Terms -->
                        <div class="checkout__terms mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    لقد قرأت ووافقت على <a href="#">الشروط والأحكام</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="trk-btn trk-btn--primary w-100 mt-4">
                            إتمام الطلب <i class="fa-solid fa-lock ms-2"></i>
                        </button>
                        
                        <!-- Security Info -->
                        <div class="checkout__security text-center mt-3">
                            <small class="text-muted">
                                <i class="fa-solid fa-shield-halved me-1"></i>
                                معاملتك آمنة ومحمية
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
.checkout__form,
.checkout__summary {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.checkout__items-header {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    margin-bottom: 15px;
}

.checkout__item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.checkout__item-info {
    flex: 1;
}

.checkout__item-name {
    display: block;
    font-weight: 500;
}

.checkout__item-qty {
    display: block;
    color: #666;
    font-size: 14px;
}

.checkout__totals {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #dee2e6;
}

.checkout__total-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 15px;
}

.checkout__total-final {
    font-size: 20px;
    font-weight: 700;
    padding-top: 15px;
    margin-top: 15px;
    border-top: 2px solid #333;
}

.form-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border-radius: 6px;
    padding: 12px 15px;
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const termsCheckbox = document.getElementById('terms');
    if (!termsCheckbox.checked) {
        e.preventDefault();
        alert('يرجى الموافقة على الشروط والأحكام');
        return false;
    }
});
</script>
@endpush

