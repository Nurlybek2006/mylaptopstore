<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Себет - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .cart-item {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 0;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .quantity-input {
            width: 70px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 0.5rem;
        }
        
        .summary-card {
            background: #f8fafc;
            border-radius: 15px;
            padding: 1.5rem;
            border: 2px solid #e2e8f0;
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem;
        }
        
        .empty-cart i {
            font-size: 4rem;
            color: #64748b;
            margin-bottom: 1rem;
        }
        
        .btn-update {
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-update:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-remove:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        .stock-warning {
            color: #ef4444;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .out-of-stock {
            background: #fef2f2;
            border: 1px solid #fecaca;
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
        
        .stripe-info {
            text-align: center;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border: none;
            padding: 1rem;
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Навигация -->
    @include('layouts.navbar')
    
    <div class="container py-5">
        <!-- Бreadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Басты бет</a></li>
                <li class="breadcrumb-item active">Себет</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Менің себетім</h2>
                        @if (!empty($cart_items))
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Барлық өнімдерді себеттен өшірейін бе?')">
                                    <i class="fas fa-trash me-2"></i>Себетті тазалау
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <!-- Хабарламалар -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    @if(session('warning'))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                        </div>
                    @endif
                    
                    @if (empty($cart_items))
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Себетіңіз бос</h3>
                            <p class="text-muted mb-4">Әлі себетке ешқандай өнім қоспағансыз</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-laptop me-2"></i>Ноутбуктарды көру
                            </a>
                        </div>
                    @else
                        @foreach($cart_items as $item)
                        <div class="cart-item {{ $item['out_of_stock'] ? 'out-of-stock' : '' }}">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="product-image">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1">{{ $item['name'] }}</h5>
                                    <p class="text-muted mb-0">{{ number_format($item['price'], 0, ',', ' ') }} ₸</p>
                                    @if ($item['out_of_stock'])
                                        <div class="stock-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Қорда тек {{ $item['stock'] }} дана бар
                                        </div>
                                    @elseif ($item['quantity'] > 5)
                                        <div class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Қолжетімді
                                        </div>
                                    @else
                                        <div class="stock-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            Азық қоры ({{ $item['stock'] }} дана)
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <form method="POST" action="{{ route('cart.update') }}" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                               min="1" max="{{ $item['stock'] }}" class="quantity-input me-2"
                                               {{ $item['out_of_stock'] ? 'disabled' : '' }}>
                                        <button type="submit" class="btn-update"
                                                {{ $item['out_of_stock'] ? 'disabled' : '' }}>
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-2 text-center">
                                    <strong>{{ number_format($item['subtotal'], 0, ',', ' ') }} ₸</strong>
                                </div>
                                <div class="col-md-1 text-end">
                                    <a href="{{ route('cart.remove', $item['id']) }}" 
                                       class="btn-remove"
                                       onclick="return confirm('Бұл өнімді себеттен өшірейін бе?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            @if (!empty($cart_items))
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="mb-4">Тапсырыс қорытындысы</h4>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Тауарлар:</span>
                        <span>{{ count($cart_items) }} дана</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Жалпы сома:</span>
                        <strong class="fs-5">{{ number_format($total, 0, ',', ' ') }} ₸</strong>
                    </div>
                    
                    @if($has_out_of_stock)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Кейбір өнімдердің қоры жеткіліксіз
                        </div>
                    @endif
                    
                    <!-- Кәдімгі тапсырыс беру формасы -->
                    <form method="POST" action="{{ route('cart.checkout') }}" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-3"
                                {{ $has_out_of_stock ? 'disabled' : '' }}>
                            <i class="fas fa-credit-card me-2"></i>
                            Кәдімгі тапсырыс беру
                        </button>
                    </form>
                    
                    <!-- Stripe арқылы төлеу -->
                    <button type="button" class="btn btn-success w-100 py-3 mb-3" 
                            id="stripeCartBtn"
                            onclick="stripeCartCheckout()"
                            {{ $has_out_of_stock ? 'disabled' : '' }}>
                        <i class="fas fa-bolt me-2"></i>
                        Stripe арқылы төлеу
                    </button>
                    
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
                    
                    <div class="mt-3 text-center">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Сатып алуды жалғастыру
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Stripe баптау
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        
        // Себетті Stripe арқылы төлеу функциясы
        async function stripeCartCheckout() {
            const button = document.getElementById('stripeCartBtn');
            const originalText = button.innerHTML;
            
            // Жүктелу күйін көрсету
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Жүктелуде...';
            button.classList.add('btn-loading');
            button.disabled = true;
            
            try {
                const response = await fetch('{{ route("cart.stripe-checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
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
    </script>
</body>
</html>