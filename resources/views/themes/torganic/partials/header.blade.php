{{-- Dynamic Header with Torganic Design --}}
@if($headerSettings && $headerSettings->header_enabled)
<header class="header header--style-2 {{ $headerSettings->header_sticky ? 'header--sticky' : '' }}"
        style="font-family: {{ $headerSettings->header_font ?? 'inherit' }}; min-height: {{ $headerSettings->header_height ?? 'auto' }}px;">
    
    {{-- Custom CSS if provided --}}
    @if($headerSettings->header_custom_css)
    <style>
        {!! $headerSettings->header_custom_css !!}
    </style>
    @endif
    
    {{-- Dynamic styles based on settings --}}
    <style>
        /* Cart count badge styling */
        .cart-count {
            min-width: 18px;
            min-height: 18px;
            padding: 2px 5px;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
    </style>
    
    @if($headerSettings->header_shadow)
    <style>
        .header--style-2 {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
    @endif
    
    @if($headerSettings->header_smooth_transitions)
    <style>
        .header * {
            transition: all 0.3s ease-in-out;
        }
    </style>
    @endif
    
    @if($headerSettings->header_scroll_effects && $headerSettings->header_sticky)
    <style>
        .header--sticky {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header--sticky.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.12);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.header--sticky');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                });
            }
        });
    </script>
    @endif
    
    <div class="container">
        <div class="header__wrapper">
            <!-- Logo -->
            @if($headerSettings->logo_enabled)
            <div class="header__brand">
                <a href="{{ route('home') }}">
                    @if($headerSettings->logo_image)
                        <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                             alt="{{ config('app.name') }}" 
                             style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                    @elseif($headerSettings->logo_svg)
                        <div style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px;">
                            {!! $headerSettings->logo_svg !!}
                        </div>
                    @elseif(isset($homePage) && $homePage->store_logo)
                        <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                             alt="{{ config('app.name') }}" 
                             style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                    @else
                        <img src="{{ asset('themes/torganic/assets/images/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                    @endif
                </a>
            </div>
            @endif

            <!-- Navigation Menu -->
            @if($headerSettings->navigation_enabled)
            <div class="header__navbar">
                <div class="header__overlay"></div>
                <nav class="menu">
                    @if($headerSettings->mobile_menu_enabled)
                    <div class="menu-mobile-header">
                        <button type="button" class="menu-mobile-arrow"><i class="fa-solid fa-arrow-left"></i></button>
                        <div class="menu-mobile-title"></div>
                        <button type="button" class="menu-mobile-close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    @endif
                    
                    <ul class="menu-section menu-section--style-2">
                        @if($headerSettings->show_home_link)
                        <li><a href="{{ route('home') }}">الرئيسية</a></li>
                        @endif
                        
                        {{-- Dynamic Menu Items from HeaderSettings --}}
                        @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array($headerSettings->menu_items))
                            @foreach ($headerSettings->menu_items as $menuItem)
                            @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                            <li>
                                <a href="{{ url($menuItem['url'] ?? '#') }}">
                                    {{ $menuItem['name'] ?? 'Menu Item' }}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        @elseif($headerSettings->main_menus_enabled && isset($menus) && $menus->isNotEmpty())
                            @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                            <li>
                                <a href="{{ url($menu->url) }}">{{ $menu->title }}</a>
                            </li>
                            @endforeach
                        @endif
                        
                        {{-- Show Categories if Enabled --}}
                        @if($headerSettings->show_categories_in_menu && isset($categories) && $categories->isNotEmpty())
                        <li class="menu-item-has-children">
                            <a href="{{ route('products.index') }}">الأقسام <i class="fa-solid fa-angle-down"></i></a>
                            <div class="submenu">
                                <ul>
                                    @foreach($categories->take($headerSettings->categories_count ?? 5) as $category)
                                    <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                        
                        {{-- Static Pages if Available --}}
                        @if(isset($pages) && $pages->isNotEmpty())
                        <li class="menu-item-has-children">
                            <a href="#">الصفحات <i class="fa-solid fa-angle-down"></i></a>
                            <div class="submenu">
                                <ul>
                                    @foreach($pages as $page)
                                    <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif

            <!-- Header Actions -->
            <div class="header__action">
                <!-- User Account -->
                @if($headerSettings->user_menu_enabled)
                    @auth
                    <a class="header__action-btn d-none d-xl-grid" href="{{ route('profile.show') }}" title="حسابي">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    @else
                    <a class="header__action-btn d-none d-xl-grid" href="{{ route('login') }}" title="تسجيل الدخول">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    @endauth
                @endif

                <!-- Wishlist -->
                @if($headerSettings->wishlist_enabled)
                <a class="header__action-btn d-none d-xl-grid" href="#" title="المفضلة">
                    <i class="fa-regular fa-heart"></i>
                </a>
                @endif

                <!-- Cart -->
                @if($headerSettings->shopping_cart_enabled)
                <a class="header__action-btn d-none d-xl-grid position-relative" href="{{ route('cart.index') }}" title="سلة التسوق">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="cart-icon">
                        <path d="M4.92383 18.2228C4.92383 18.6943 5.11832 19.1464 5.46451 19.4798C5.81071 19.8132 6.28025 20.0005 6.76985 20.0005C7.25944 20.0005 7.72899 19.8132 8.07518 19.4798C8.42138 19.1464 8.61587 18.6943 8.61587 18.2228C8.61587 17.7513 8.42138 17.2991 8.07518 16.9658C7.72899 16.6324 7.25944 16.4451 6.76985 16.4451C6.28025 16.4451 5.81071 16.6324 5.46451 16.9658C5.11832 17.2991 4.92383 17.7513 4.92383 18.2228Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15.0762 18.2228C15.0762 18.6943 15.2707 19.1464 15.6169 19.4798C15.9631 19.8132 16.4326 20.0005 16.9222 20.0005C17.4118 20.0005 17.8813 19.8132 18.2275 19.4798C18.5737 19.1464 18.7682 18.6943 18.7682 18.2228C18.7682 17.7513 18.5737 17.2991 18.2275 16.9658C17.8813 16.6324 17.4118 16.4451 16.9222 16.4451C16.4326 16.4451 15.9631 16.6324 15.6169 16.9658C15.2707 17.2991 15.0762 17.7513 15.0762 18.2228Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16.923 16.4446H6.76985V4.00049H4.92383" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6.76953 5.77881L19.6917 6.66767L18.7687 12.8897H6.76953" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    @php
                        $cartCount = 0;
                        $sessionCartCount = session()->get('cart_count');
                        
                        if ($sessionCartCount !== null) {
                            $cartCount = $sessionCartCount;
                        } else {
                            if (auth()->check()) {
                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                            } else {
                                $sessionId = session()->get('cart_session_id');
                                if ($sessionId) {
                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                }
                            }
                            session()->put('cart_count', $cartCount);
                        }
                    @endphp
                    @if($cartCount > 0)
                    <span class="badge bg-primary cart-count position-absolute top-0 start-100 translate-middle rounded-circle">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- Mobile Cart -->
                @if($headerSettings->mobile_cart_enabled)
                <a href="{{ route('cart.index') }}" class="header__action-btn menu-icon d-xl-none position-relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if($cartCount > 0)
                    <span class="badge bg-primary cart-count position-absolute top-0 start-100 translate-middle rounded-circle">{{ $cartCount }}</span>
                    @endif
                </a>
                @endif
                @endif

                <!-- Search -->
                @if($headerSettings->search_bar_enabled)
                <button id="trk-search-icon" class="menu-icon search-icon header__action-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <!-- Search Box -->
                <div class="trk-search">
                    <div class="trk-search__inner">
                        <form action="{{ route('products.search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="ابحث عن منتج..." aria-label="البحث">
                                <button type="submit" class="trk-search__btn" id="trk-search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="trk-search__overlay"></div>
                @endif

                <!-- Mobile Menu Toggle -->
                @if($headerSettings->mobile_menu_enabled)
                <button type="button" class="menu-mobile-trigger menu-mobile-trigger--style-2">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                @endif
            </div>
        </div>
    </div>
</header>

{{-- Contact Information Bar --}}
@if($headerSettings->header_contact_enabled && ($headerSettings->header_phone || $headerSettings->header_email))
<div class="bg-light py-2 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-{{ $headerSettings->contact_position === 'center' ? 'center' : ($headerSettings->contact_position === 'right' ? 'end' : 'start') }} gap-3">
            @if($headerSettings->header_phone)
            <a href="tel:{{ $headerSettings->header_phone }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-phone"></i> {{ $headerSettings->header_phone }}
            </a>
            @endif
            
            @if($headerSettings->header_email)
            <a href="mailto:{{ $headerSettings->header_email }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-envelope"></i> {{ $headerSettings->header_email }}
            </a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Cart Synchronization Script --}}
@if($headerSettings->shopping_cart_enabled)
<script>
    // Global cart management
    window.CartManager = window.CartManager || {
        updateCartCount: function(newCount) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = newCount;
                element.style.animation = 'pulse 0.5s';
                setTimeout(() => element.style.animation = '', 500);
            });
        },

        syncCartCount: function() {
            return fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.cart_count !== undefined) {
                    this.updateCartCount(data.cart_count);
                }
                return data;
            })
            .catch(error => console.error('Error syncing cart:', error));
        }
    };

    // Initialize cart on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => window.CartManager.syncCartCount(), 500);
        });
    } else {
        setTimeout(() => window.CartManager.syncCartCount(), 500);
    }

    // Legacy support
    window.updateCartCount = window.CartManager.updateCartCount.bind(window.CartManager);
    window.syncCartCount = window.CartManager.syncCartCount.bind(window.CartManager);
</script>
@endif
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

