@extends('layouts.app')

@section('title', $product->name . ' - Laptop.KZ')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">



@endsection

@section('content')
<div class="container py-4">
    <!-- Бreadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Басты бет</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Өнімдер</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Негізгі контент -->
    <div class="product-main">
        <div class="row g-0">
            <!-- Сурет бөлімі -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="{{ $product->image_url }}"
                            alt="{{ $product->name }}"
                            id="mainImage">
                    </div>
                </div>
            </div>

            <!-- Ақпарат бөлімі -->
            <div class="col-lg-6">
                <div class="product-info">
                    <div class="product-category">
                        <i class="fas fa-tag me-1"></i>{{ $product->category->name ?? 'Категория жоқ' }}
                    </div>

                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-text">{{ $product->average_rating }} ({{ $product->reviews_count }} пікір)</span>
                    </div>

                    <div class="price-section">
                        <div class="price-label">Бағасы</div>
                        <div class="current-price">{{ $product->formatted_price }}</div>
                    </div>

                    <div class="stock-info">
                        @if($product->in_stock)
                        <span class="stock-badge in-stock">
                            <i class="fas fa-check me-1"></i>{{ $product->stock_status }}
                        </span>
                        <span class="stock-count">{{ $product->stock }} дана қалды</span>
                        @else
                        <span class="stock-badge out-of-stock">
                            <i class="fas fa-times me-1"></i>{{ $product->stock_status }}
                        </span>
                        @endif
                    </div>

                    <div class="description-section">
                        <h3 class="section-title">Сипаттама</h3>
                        <div class="product-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    @if($product->in_stock)
                    <div class="purchase-section">
                        <!-- Себетке қосу формасы -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mb-3">
                            @csrf
                            <div class="quantity-selector">
                                <span class="quantity-label">Саны:</span>
                                <select name="quantity" id="quantity" class="form-select quantity-input">
                                    @for($i = 1; $i <= min(10, $product->stock); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>

                            <div class="action-buttons">
                                @auth
                                @if(Auth::user()->role !== 'admin')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Себетке қосу
                                </button>

                                <!-- Stripe арқылы бірден сатып алу батырмасы -->
                                <button type="button" class="btn btn-success stripe-checkout-btn" data-product-id="{{ $product->id }}" id="stripeBtn">
                                    <i class="fas fa-bolt me-2"></i>Stripe арқылы сатып алу
                                </button>

                                <a href="{{ route('cart.index') }}" class="btn btn-outline">
                                    <i class="fas fa-credit-card me-2"></i>Себетте төлеу
                                </a>
                                @else
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Админ себетке өнім қоса алмайды
                                </div>
                                @endif
                                @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Кіру (сатып алу үшін)
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline">
                                    <i class="fas fa-user-plus me-2"></i>Тіркелу
                                </a>
                                @endauth
                            </div>
                        </form>

                        <!-- Stripe төлем ақпараты -->
                        <div class="stripe-info">
                            <p class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Қауіпсіз төлем - Stripe
                                </small>
                            </p>
                            <div class="payment-methods">
                                <span class="payment-method">💳</span>
                                <span class="payment-method">🔒</span>
                                <span class="payment-method">⚡</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Бұл өнім уақытша сатылымда жоқ
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ұқсас өнімдер -->
    @if($relatedProducts->count() > 0)
    <div class="related-products">
        <h2 class="related-title">Ұқсас өнімдер</h2>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="related-card">
                    <div class="related-image">
                        <img src="{{ $related->image_url }}"
                            alt="{{ $related->name }}">
                    </div>
                    <div class="related-body">
                        <h4 class="related-name">{{ $related->name }}</h4>
                        <div class="related-price">{{ $related->formatted_price }}</div>
                        <a href="{{ route('products.show', $related->id) }}" class="btn btn-related">
                            <i class="fas fa-eye me-2"></i>Толығырақ
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Анимация эффектілері
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.product-main, .related-card');

        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';

            setTimeout(() => {
                element.style.transition = 'all 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 200);
        });

        // Enter пернесімен санын өзгертуді болдырмау
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        }
    });

    // Хабарламаларды автоматты түрде жабу
    document.addEventListener('DOMContentLoaded', function() {
        // 5 секундтан кейін барлық хабарламаларды жабу
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });

    // Stripe баптау
    const stripe = Stripe('{{ config("services.stripe.key") }}');

    // Stripe төлем функциясы
    async function stripeCheckout(productId) {
        const quantity = document.getElementById('quantity').value;
        const button = document.getElementById('stripeBtn');
        const originalText = button.innerHTML;

        // Жүктелу күйін көрсету
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Жүктелуде...';
        button.classList.add('btn-loading');
        button.disabled = true;

        try {
            const response = await fetch('{{ route("stripe.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            });

            const data = await response.json();

            if (data.id) {
                // Stripe Checkout-қа бағыттау
                const result = await stripe.redirectToCheckout({
                    sessionId: data.id
                });

                if (result.error) {
                    alert('Төлем қатесі: ' + result.error.message);
                }
            } else {
                alert('Қате: ' + data.error);
            }
        } catch (error) {
            alert('Желі қатесі: ' + error.message);
            console.error('Stripe қатесі:', error);
        } finally {
            // Батырманы қалпына келтіру
            button.innerHTML = originalText;
            button.classList.remove('btn-loading');
            button.disabled = false;
        }
    }
    // Батырмаларға event listener қосу
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.stripe-checkout-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                stripeCheckout(productId);
            });
        });
    });
</script>
@endsection