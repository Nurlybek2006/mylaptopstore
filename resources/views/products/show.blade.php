@extends('layouts.app')

@section('title', $product->name . ' - Laptop.KZ')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --secondary: #64748b;
        --accent: #f59e0b;
        --light: #f8fafc;
        --dark: #1e293b;
    }

    .product-main {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 3rem;
    }

    .product-gallery {
        padding: 2rem;
        background: var(--light);
    }

    .main-image {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .main-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .main-image:hover img {
        transform: scale(1.02);
    }

    .product-info {
        padding: 2rem;
    }

    .product-category {
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .product-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .product-rating {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .stars {
        color: var(--accent);
        margin-right: 0.5rem;
    }

    .rating-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .price-section {
        background: linear-gradient(135deg, var(--light) 0%, #fff 100%);
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 1.5rem;
        border: 2px solid #e2e8f0;
    }

    .current-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .price-label {
        color: var(--secondary);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stock-info {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 10px;
        background: var(--light);
    }

    .stock-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .in-stock {
        background: #dcfce7;
        color: #166534;
    }

    .out-of-stock {
        background: #fee2e2;
        color: #dc2626;
    }

    .stock-count {
        margin-left: auto;
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .description-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
    }

    .product-description {
        line-height: 1.7;
        color: var(--secondary);
        font-size: 1rem;
    }

    .purchase-section {
        background: var(--light);
        padding: 1.5rem;
        border-radius: 15px;
        border: 2px solid #e2e8f0;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .quantity-label {
        font-weight: 600;
        color: var(--dark);
        min-width: 80px;
    }

    .quantity-input {
        width: 100px;
        text-align: center;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.5rem;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-direction: column;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        flex: 1;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        flex: 1;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        flex: 1;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        color: white;
    }

    .stripe-info {
        text-align: center;
        margin-top: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .payment-methods {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 0.5rem;
    }

    .payment-method {
        font-size: 1.5rem;
        color: #64748b;
    }

    .related-products {
        margin-top: 4rem;
    }

    .related-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }

    .related-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--accent);
        border-radius: 2px;
    }

    .related-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .related-image {
        height: 180px;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .related-card:hover .related-image img {
        transform: scale(1.1);
    }

    .related-body {
        padding: 1.5rem;
    }

    .related-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .related-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .btn-related {
        background: var(--primary);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .btn-related:hover {
        background: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
    }

    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
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