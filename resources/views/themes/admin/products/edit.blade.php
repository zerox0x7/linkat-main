@extends('themes.admin.layouts.app')

@section('title', 'تعديل منتج')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تعديل منتج: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">العودة للمنتجات</a>
    </div>
    
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <form id="product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border-r-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-6 rounded">
                    <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
                    <ul class="list-disc mr-8 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- معلومات أساسية -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">اسم المنتج <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    </div>
                    
                    <!-- سويتش تفعيل الرابط المخصص -->
                    @php
                        $customSlugChecked = old('custom_slug_switch', !empty($product->slug) && $product->slug != Str::slug($product->name));
                    @endphp
                    <div class="flex items-center mt-2 mb-2">
                        <input type="checkbox" id="custom-slug-switch" name="custom_slug_switch" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ $customSlugChecked ? 'checked' : '' }}>
                        <label for="custom-slug-switch" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">تفعيل رابط مخصص للمنتج</label>
                    </div>
                    <!-- حقل الرابط المخصص (slug) -->
                    <div class="form-group mb-3" id="custom-slug-group" style="display: {{ $customSlugChecked ? 'block' : 'none' }};">
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الرابط المخصص (slug)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" placeholder="مثال: snapchat">
                        <small class="form-text text-gray-500 dark:text-gray-400">يمكنك كتابة كلمة واحدة فقط (بدون مسافات أو رموز)، وستظهر في رابط المنتج.</small>
                    </div>
                    
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">رمز المنتج (SKU) <span class="text-red-600">*</span></label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع المنتج <span class="text-red-600">*</span></label>
                        <select name="type" id="type" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                            <option value="account" {{ old('type', $product->type) == 'account' ? 'selected' : '' }}>حساب</option>
                            <option value="digital_card" {{ old('type', $product->type) == 'digital_card' ? 'selected' : '' }}>بطاقة رقمية</option>
                            <option value="custom" {{ old('type', $product->type) == 'custom' ? 'selected' : '' }}>منتج مخصص</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الفئة <span class="text-red-600">*</span></label>
                        <select name="category_id" id="category_id" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                            <option value="">اختر الفئة</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description">وصف المنتج</label>
                        <div id="quill-editor">{!! old('description', $product->description ?? '') !!}</div>
                        <input type="hidden" name="description" id="description-input">
                    </div>

                    <div>
                        <label for="product_note" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تعليمات أو شرح خاص لهذا المنتج (اختياري)</label>
                        <textarea name="product_note" id="product_note" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">{{ old('product_note', $product->product_note ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">يمكنك كتابة تعليمات أو شرح خاص يظهر للعميل عند شراء المنتج (مثلاً: طريقة التفعيل أو ملاحظات هامة).</p>
                    </div>
                </div>
                
                <!-- السعر والمخزون والحالة -->
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر <span class="text-red-600">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                       class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">ر.س</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر الأصلي</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->old_price) }}" step="0.01" min="0"
                                       class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">ر.س</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">المخزون <span class="text-red-600">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحالة <span class="text-red-600">*</span></label>
                        <select name="status" id="status" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $product->is_featured) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="featured" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">عرض في المنتجات المميزة</label>
                    </div>
                </div>
            </div>
            
            <!-- الأكواد الرقمية (للبطاقات الرقمية فقط) -->
            <div id="digital_codes_section" class="pt-4 border-t border-gray-200" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 mb-4">الأكواد الرقمية</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500">أضف الأكواد الرقمية هنا. كل سطر يمثل كود واحد.</p>
                    <textarea name="digital_codes" id="digital_codes" rows="5"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">{{ old('digital_codes', $product->digital_codes) }}</textarea>
                    <p class="text-xs text-gray-500">تنسيق الأكواد: كود واحد في كل سطر. مثال: ABC-123-XYZ</p>
                    <div>
                        <button type="button" id="add_code_btn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة كود جديد
                        </button>
                    </div>
                    
                    <div class="pt-3 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">تحرير الأكواد</h4>
                        <div class="text-xs text-gray-500 mb-2">يمكنك تعليم الأكواد كـ "مستخدمة" أو حذفها</div>
                        
                        <div id="digital_codes_list" class="space-y-2 mt-2">
                            <!-- سيتم إضافة الأكواد هنا ديناميكيًا من خلال JS -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- المنتج المخصص -->
            <div id="custom_fields_section" class="pt-4 border-t border-gray-200" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 mb-4">الحقول المخصصة</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500">أضف الحقول المخصصة التي تريد جمعها من العميل عند الطلب.</p>
                    
                    <div id="custom_fields_container" class="space-y-3">
                        <!-- هنا سيتم إضافة الحقول المخصصة ديناميكيًا -->
                    </div>
                    
                    <div class="flex space-x-2 space-x-reverse">
                        <button type="button" id="add_custom_field_btn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة حقل جديد
                        </button>
                    </div>
                    
                    <input type="hidden" name="custom_fields" id="custom_fields_json" value="{{ old('custom_fields', $product->custom_fields) }}">
                </div>
            </div>
            
            <!-- خيارات السعر المتعددة -->
            <div id="price_options_section" class="pt-4 border-t border-gray-200" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 mb-4">خيارات السعر المتعددة</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500">أضف خيارات السعر المختلفة حسب الكمية (عدد المتابعين، النقاط، إلخ).</p>
                    
                    <div id="price_options_container" class="space-y-3">
                        <!-- هنا سيتم إضافة خيارات السعر ديناميكيًا -->
                    </div>
                    
                    <div class="flex space-x-2 space-x-reverse">
                        <button type="button" id="add_price_option_btn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة خيار سعر
                        </button>
                    </div>
                    
                    <input type="hidden" name="price_options" id="price_options_json" value="{{ old('price_options', $product->price_options) }}">
                </div>
            </div>
            
            <!-- صور المنتج -->
            <div class="pt-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">صور المنتج</h3>
                
                <!-- الصورة الرئيسية -->
                <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">الصورة الرئيسية للمنتج</label>
                        <span class="text-xs text-gray-500">يفضل مقاس 800×800 بكسل</span>
                    </div>
                    
                    <div class="flex items-center space-x-4 space-x-reverse">
                        @if($product->main_image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-40 w-40 object-cover rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openImagePreview(this.src)"
                                     onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity rounded-lg"></div>
                            </div>
                        @else
                            <div class="h-40 w-40 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-sm">لا توجد صورة رئيسية</span>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>اختر صورة</span>
                                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp,image/gif" class="sr-only" onchange="previewMainImage(this)">
                                        </label>
                                        <p class="pr-1">أو اسحب وأفلت الصورة هنا</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, WebP حتى 2MB</p>
                                </div>
                            </div>
                            <div id="main-image-preview" class="mt-4 hidden">
                                <div class="relative group">
                                    <img id="preview-img" src="" class="h-40 w-40 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                    <button type="button" onclick="removeMainImagePreview()" class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- الصور الإضافية -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">الصور الإضافية للمنتج</h3>
                    <span class="text-sm text-gray-500">يمكنك إضافة حتى 10 صور إضافية</span>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label for="additional_images" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-3">صور اضافية للمنتج: تعرض في البوم للمنتج</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="additional_images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>اختر الصور</span>
                                    <input type="file" name="additional_images[]" id="additional_images" accept="image/jpeg,image/png,image/webp,image/gif" multiple class="sr-only" onchange="handleAdditionalImages(this)">
                                </label>
                                <p class="pr-1">أو اسحب وأفلت الصور هنا</p>
                            </div>
                            <p class="text-xs text-gray-500">JPG, PNG, WebP حتى 2MB</p>
                        </div>
                    </div>
                    <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
                    <div id="upload-status" class="mt-2 text-sm text-gray-500"></div>
                </div>

                <!-- الصور المضافة حالياً -->
                @if($product->gallery && is_array(json_decode($product->gallery)) && count(json_decode($product->gallery)) > 0)
                <div class="mt-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">الصور المضافة حالياً</label>
                        <span class="text-xs text-gray-500">{{ count(json_decode($product->gallery)) }} صور</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach(json_decode($product->gallery) as $index => $image)
                            <div class="relative group bg-white dark:bg-gray-700 p-2 rounded-lg shadow-sm">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $product->name }} - صورة {{ $index + 1 }}" 
                                     class="h-40 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openImagePreview(this.src)"
                                     onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                                <div class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" 
                                            onclick="confirmDeleteImage({{ $index }})"
                                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="checkbox" name="remove_images[]" id="remove_image_{{ $index }}" value="{{ $index }}" class="hidden">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- SEO والتاغات -->
            <div class="pt-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO والتاغات</h3>
                <p class="text-sm text-gray-500 mb-4">المعلومات أدناه تساعد في تحسين ظهور المنتج في محركات البحث مثل Google.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عنوان صفحة المنتج (Title)</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                   placeholder="عنوان المنتج المُحسّن لمحركات البحث">
                            <p class="mt-1 text-xs text-gray-500">
                                يفضل أن يكون بين 50-60 حرف. إذا تُرك فارغاً، سيتم استخدام اسم المنتج تلقائياً.
                                <span class="text-xs text-blue-500 character-count" data-for="meta_title">{{ mb_strlen($product->meta_title ?? '') }} / 60</span>
                            </p>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">وصف الصفحة (Meta Description)</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                      placeholder="اكتب وصفاً موجزاً للمنتج. هذا الوصف يظهر في نتائج البحث.">{{ old('meta_description', $product->meta_description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                يفضل أن يكون بين 150-160 حرف. إذا تُرك فارغاً، سيتم اقتطاع جزء من وصف المنتج تلقائياً.
                                <span class="text-xs text-blue-500 character-count" data-for="meta_description">{{ mb_strlen($product->meta_description ?? '') }} / 160</span>
                            </p>
                                        </div>
                                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الكلمات المفتاحية (Meta Keywords)</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                   placeholder="كلمات مفتاحية مفصولة بفواصل: كلمة1, كلمة2, كلمة3">
                            <p class="mt-1 text-xs text-gray-500">أدخل الكلمات المفتاحية مفصولة بفواصل. مثال: بطاقة ستور, العاب, هدايا</p>
                        </div>
                        
                        <div>
                            <label for="focus_keyword" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الكلمة المفتاحية الرئيسية</label>
                            <input type="text" name="focus_keyword" id="focus_keyword" value="{{ old('focus_keyword', $product->focus_keyword) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                   placeholder="كلمة أو عبارة رئيسية للمنتج">
                            <p class="mt-1 text-xs text-gray-500">أهم كلمة مفتاحية تريد أن يظهر المنتج عند البحث عنها</p>
                        </div>
                        
                        <div>
                            <label for="tags_list" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">التاغات (وسوم المنتج)</label>
                            <input type="text" name="tags_list" id="tags_list" value="{{ old('tags_list', $product->tags_list) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                   placeholder="أدخل وسوم المنتج مفصولة بفواصل">
                            <p class="mt-1 text-xs text-gray-500">التاغات تساعد العملاء في العثور على المنتج. مثال: سناب, حساب, مميز</p>
                        </div>
                        
                        <div>
                            <label for="seo_score" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تقييم SEO</label>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                @php
                                    $seoScore = $product->seo_score ?? 0;
                                    $scoreClass = $seoScore < 40 ? 'bg-red-500' : ($seoScore < 70 ? 'bg-yellow-500' : 'bg-green-500');
                                @endphp
                                <div class="{{ $scoreClass }} h-2.5 rounded-full seo-score-bar" style="width: {{ $seoScore }}%"></div>
                                </div>
                            <p class="mt-1 text-xs text-gray-500 seo-score-text">
                                سيتم حساب تقييم SEO تلقائياً بناءً على اكتمال جميع العناصر.
                                الحالي: {{ $seoScore }}/100
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- أزرار -->
            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-start">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded shadow ml-3">
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded shadow">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        direction: rtl;
        text-align: right;
        min-height: 200px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                
                [{ 'align': [] }],
                ['clean']
            ]
        },
        placeholder: 'اكتب وصف المنتج هنا...'
    });
    quill.format('direction', 'rtl');
    quill.format('align', 'right');
    document.getElementById('product-form').onsubmit = function() {
        document.getElementById('description-input').value = quill.root.innerHTML;
    };

    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', function() {
        // إزالة المسافات وتحويل إلى حروف صغيرة
        const slug = this.value
            .toLowerCase()
            .replace(/[^\w\s]/g, '') // إزالة الرموز الخاصة
            .replace(/\s+/g, '-') // استبدال المسافات بـ -
            .replace(/-+/g, '-'); // إزالة النقط المتكررة

        // تحديث حقل slug
        slugInput.value = slug;
    });

    const switchEl = document.getElementById('custom-slug-switch');
    const slugGroup = document.getElementById('custom-slug-group');
    switchEl.addEventListener('change', function() {
        if (this.checked) {
            slugGroup.style.display = 'block';
        } else {
            slugGroup.style.display = 'none';
            document.getElementById('slug').value = '';
        }
    });
});

// معالجة الصور الإضافية
function handleAdditionalImages(input) {
    const preview = document.getElementById('image-preview');
    const status = document.getElementById('upload-status');
    status.innerHTML = '';
    
    if (!input.files || input.files.length === 0) {
        return;
    }
    
    // حساب عدد الصور الحالية
    const currentImages = preview.querySelectorAll('.image-preview-item').length;
    const newImagesCount = input.files.length;
    
    if (currentImages + newImagesCount > 10) {
        status.innerHTML = '<p class="text-red-500">يمكنك رفع 10 صور كحد أقصى</p>';
        input.value = '';
        return;
    }
    
    let validFiles = 0;
    let invalidFiles = 0;
    
    Array.from(input.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            if (file.size > 2 * 1024 * 1024) {
                invalidFiles++;
                status.innerHTML += `<p class="text-red-500">الصورة ${file.name} تتجاوز الحد المسموح به (2MB)</p>`;
                return;
            }
            
            validFiles++;
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group bg-white dark:bg-gray-700 p-2 rounded-lg shadow-sm image-preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" class="h-40 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                    <button type="button" class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeImagePreview(this)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        } else {
            invalidFiles++;
            status.innerHTML += `<p class="text-red-500">الملف ${file.name} ليس صورة صالحة</p>`;
        }
    });
    
    if (validFiles > 0) {
        status.innerHTML += `<p class="text-green-500">تم اختيار ${validFiles} صور صالحة</p>`;
    }
    if (invalidFiles > 0) {
        status.innerHTML += `<p class="text-red-500">تم تجاهل ${invalidFiles} ملفات غير صالحة</p>`;
    }
    
    // تحديث عدد الصور الكلي
    const totalImages = preview.querySelectorAll('.image-preview-item').length;
    status.innerHTML += `<p class="text-gray-500">إجمالي الصور المختارة: ${totalImages} من 10</p>`;
}

// دالة حذف معاينة الصورة
function removeImagePreview(button) {
    const previewItem = button.closest('.image-preview-item');
    previewItem.remove();
    
    // تحديث عدد الصور المتبقية
    const status = document.getElementById('upload-status');
    const totalImages = document.querySelectorAll('.image-preview-item').length;
    status.innerHTML = `<p class="text-gray-500">إجمالي الصور المختارة: ${totalImages} من 10</p>`;
}

// تحسين السحب والإفلات للصور الإضافية
const dropZone = document.querySelector('input[name="additional_images[]"]').closest('.border-dashed');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('border-blue-500');
}

function unhighlight(e) {
    dropZone.classList.remove('border-blue-500');
}

dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        const input = document.getElementById('additional_images');
        input.files = files;
        handleAdditionalImages(input);
    }
}

// تأكيد حذف الصورة
function confirmDeleteImage(index) {
    if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
        document.getElementById(`remove_image_${index}`).checked = true;
        document.getElementById(`remove_image_${index}`).closest('.relative').style.display = 'none';
    }
}

// معاينة الصورة بالحجم الكامل
function openImagePreview(src) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-[90vh]">
            <img src="${src}" class="max-w-full max-h-[90vh] object-contain">
            <button onclick="this.closest('.fixed').remove()" class="absolute top-4 left-4 text-white hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.addEventListener('click', function(e) {
        if (e.target === this) this.remove();
    });
}

// معاينة الصورة الرئيسية
function previewMainImage(input) {
    const preview = document.getElementById('main-image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// إزالة معاينة الصورة الرئيسية
function removeMainImagePreview() {
    const preview = document.getElementById('main-image-preview');
    const input = document.getElementById('image');
    
    preview.classList.add('hidden');
    input.value = '';
}

function toggleSections() {
    var type = document.getElementById('type').value;
    document.getElementById('digital_codes_section').style.display = (type === 'digital_card') ? 'block' : 'none';
    document.getElementById('custom_fields_section').style.display = (type === 'custom') ? 'block' : 'none';
    document.getElementById('price_options_section').style.display = (type === 'custom') ? 'block' : 'none';
}
document.getElementById('type').addEventListener('change', toggleSections);
window.addEventListener('DOMContentLoaded', toggleSections);

// إضافة مستمعي الأحداث لأزرار إضافة الحقول المخصصة وخيارات السعر
document.addEventListener('DOMContentLoaded', function() {
    const customFieldsContainer = document.getElementById('custom_fields_container');
    const customFieldsInput = document.getElementById('custom_fields_json');
    const priceOptionsContainer = document.getElementById('price_options_container');
    const priceOptionsInput = document.getElementById('price_options_json');
    
    // إضافة حقل مخصص جديد
    document.getElementById('add_custom_field_btn').addEventListener('click', function() {
        const customFields = customFieldsInput.value ? JSON.parse(customFieldsInput.value) : [];
        customFields.push({
            label: 'حقل جديد',
            type: 'text',
            required: true
        });
        customFieldsInput.value = JSON.stringify(customFields);
        renderCustomFields();
    });
    
    // إضافة خيار سعر جديد
    document.getElementById('add_price_option_btn').addEventListener('click', function() {
        const priceOptions = priceOptionsInput.value ? JSON.parse(priceOptionsInput.value) : [];
        priceOptions.push({
            quantity: '',
            price: ''
        });
        priceOptionsInput.value = JSON.stringify(priceOptions);
        renderPriceOptions();
    });
    
    // تحديث الحقول المخصصة عند تغيير القيم
    customFieldsContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('custom-field-input') || e.target.classList.contains('custom-field-checkbox')) {
            const index = parseInt(e.target.dataset.index);
            const property = e.target.dataset.property;
            const customFields = JSON.parse(customFieldsInput.value);
            customFields[index][property] = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
            customFieldsInput.value = JSON.stringify(customFields);
        }
    });
    
    // تحديث خيارات السعر عند تغيير القيم
    priceOptionsContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('price-option-input')) {
            const index = parseInt(e.target.dataset.index);
            const property = e.target.dataset.property;
            const priceOptions = JSON.parse(priceOptionsInput.value);
            priceOptions[index][property] = e.target.value;
            priceOptionsInput.value = JSON.stringify(priceOptions);
        }
    });
    
    // حذف حقل مخصص
    customFieldsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-custom-field')) {
            const index = parseInt(e.target.dataset.index);
            const customFields = JSON.parse(customFieldsInput.value);
            customFields.splice(index, 1);
            customFieldsInput.value = JSON.stringify(customFields);
            renderCustomFields();
        }
    });
    
    // حذف خيار سعر
    priceOptionsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-price-option')) {
            const index = parseInt(e.target.dataset.index);
            const priceOptions = JSON.parse(priceOptionsInput.value);
            priceOptions.splice(index, 1);
            priceOptionsInput.value = JSON.stringify(priceOptions);
            renderPriceOptions();
        }
    });
    
    // دالة لعرض الحقول المخصصة
    function renderCustomFields() {
        const customFields = customFieldsInput.value ? JSON.parse(customFieldsInput.value) : [];
        customFieldsContainer.innerHTML = '';
        customFields.forEach((field, index) => {
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'bg-gray-50 dark:bg-gray-800 p-3 rounded-md';
            fieldDiv.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium">حقل مخصص #${index + 1}</h4>
                    <button type="button" data-index="${index}" class="remove-custom-field text-red-600 hover:text-red-800 text-sm">
                        حذف
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عنوان الحقل</label>
                        <input type="text" data-index="${index}" data-property="label" value="${field.label}" 
                               class="custom-field-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع الحقل</label>
                        <select data-index="${index}" data-property="type" 
                                class="custom-field-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                            <option value="text" ${field.type === 'text' ? 'selected' : ''}>نص</option>
                            <option value="email" ${field.type === 'email' ? 'selected' : ''}>بريد إلكتروني</option>
                            <option value="number" ${field.type === 'number' ? 'selected' : ''}>رقم</option>
                            <option value="url" ${field.type === 'url' ? 'selected' : ''}>رابط</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="required_${index}" data-index="${index}" data-property="required" 
                               class="custom-field-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-700 rounded"
                               ${field.required ? 'checked' : ''}>
                        <label for="required_${index}" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">
                            حقل مطلوب
                        </label>
                    </div>
                </div>
            `;
            customFieldsContainer.appendChild(fieldDiv);
        });
    }
    
    // دالة لعرض خيارات السعر
    function renderPriceOptions() {
        const priceOptions = priceOptionsInput.value ? JSON.parse(priceOptionsInput.value) : [];
        priceOptionsContainer.innerHTML = '';
        priceOptions.forEach((option, index) => {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'bg-gray-50 dark:bg-gray-800 p-3 rounded-md';
            optionDiv.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium">خيار السعر #${index + 1}</h4>
                    <button type="button" data-index="${index}" class="remove-price-option text-red-600 hover:text-red-800 text-sm">
                        حذف
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الكمية أو اسم الباقة</label>
                        <input type="text" data-index="${index}" data-property="quantity" value="${option.quantity || ''}" 
                               class="price-option-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                               placeholder="مثال: 1000 متابع أو باقة ذهبية">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر</label>
                        <input type="number" data-index="${index}" data-property="price" value="${option.price || ''}" 
                               class="price-option-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                               placeholder="السعر">
                    </div>
                </div>
            `;
            priceOptionsContainer.appendChild(optionDiv);
        });
    }
    
    // تحميل وعرض الحقول المخصصة وخيارات السعر عند تحميل الصفحة
    renderCustomFields();
    renderPriceOptions();
});
</script>
@endpush 