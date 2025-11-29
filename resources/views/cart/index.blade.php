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
                    
                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-3"
                                {{ $has_out_of_stock ? 'disabled' : '' }}>
                            <i class="fas fa-credit-card me-2"></i>
                            Тапсырыс беру
                        </button>
                    </form>
                    
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>