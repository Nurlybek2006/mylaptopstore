<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Өнімдер - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --accent: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--dark);
        }

        /* Бreadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 1rem 0;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Фильтрлер панелі */
        .filter-panel {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border: none;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 3rem;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
        }

        .sort-select {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .sort-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
        }

        /* Өнімдер торы */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--accent);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-badge.out-of-stock {
            background: #ef4444;
        }

        .product-card-body {
            padding: 1.5rem;
        }

        .product-category {
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .product-description {
            color: var(--secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-details {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
            text-decoration: none;
            text-align: center;
        }

        .btn-details:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            color: white;
        }

        .btn-cart {
            background: var(--accent);
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-cart:hover {
            background: #e58e0b;
            transform: translateY(-2px);
        }

        .btn-cart:disabled {
            background: var(--secondary);
            cursor: not-allowed;
            transform: none;
        }

        /* Нәтижелер информациясы */
        .results-info {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .no-products {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .no-products i {
            font-size: 4rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .stock-info {
            font-size: 0.8rem;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .stock-warning {
            color: #ef4444;
            font-weight: 600;
        }

        /* Пагинация */
        .pagination {
            justify-content: center;
            margin-top: 3rem;
        }

        .page-link {
            border: none;
            color: var(--primary);
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: var(--primary);
            color: white;
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
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
                <li class="breadcrumb-item active">Өнімдер</li>
            </ol>
        </nav>

        <!-- Бет атауы -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-5 fw-bold">Барлық өнімдер</h1>
                <p class="text-muted">Біздің ноутбуктердің толық тізімі</p>
            </div>
        </div>

        <div class="row">
            <!-- Өнімдер бөлімі -->
            <div class="col-12">
                <!-- Фильтрлер панелі -->
                <div class="filter-panel">
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="search-box">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Өнімдерді іздеу..."
                                        value="{{ $search ?? '' }}"
                                        id="searchInput">
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <span class="me-2 text-muted">Сұрыптау:</span>
                                    <select class="sort-select" name="sort" onchange="this.form.submit()">
                                        <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Аты бойынша</option>
                                        <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Бағасы бойынша (төменнен)</option>
                                        <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Бағасы бойынша (жоғарыдан)</option>
                                        <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Жаңалары</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Нәтижелер информациясы -->
                <div class="results-info">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted">
                                <strong>{{ $totalProducts }}</strong> өнім табылды
                                @if($search)
                                "<strong>{{ $search }}</strong>" үшін
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Өнімдер торы -->
                @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image ?? '/images/placeholder.jpg' }}" alt="{{ $product->name }}">
                            @if($product->stock > 0)
                            <span class="product-badge">Қоймада бар</span>
                            @else
                            <span class="product-badge out-of-stock">Сатылымда жоқ</span>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <div class="stock-info">
                                @if($product->stock > 10)
                                <span class="text-success">Қолжетімді</span>
                                @elseif($product->stock > 0)
                                <span class="stock-warning">Аз қалды ({{ $product->stock }} дана)</span>
                                @else
                                <span class="text-danger">Сатылымда жоқ</span>
                                @endif
                            </div>
                            <div class="product-category">{{ $product->category->name ?? 'Категориясыз' }}</div>
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-description">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                            <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₸</div>
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-details">
                                    <i class="fas fa-eye me-2"></i>Толығырақ
                                </a>
                                @if($product->stock > 0)
                                @auth
                                @if(Auth::user()->role !== 'admin')
                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-cart" title="Себетке қосу">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn-cart" disabled title="Админ себетке қоса алмайды">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                @endif
                                @else
                                <a href="{{ route('login') }}" class="btn-cart" title="Кіру керек">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                @endauth
                                @else
                                <button class="btn-cart" disabled title="Өнім қолжетімсіз">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
                @else
                <div class="no-products">
                    <i class="fas fa-search"></i>
                    <h3>Өнімдер табылмады</h3>
                    <p class="text-muted mb-4">Сіздің іздеу шарттарыңыз бойынша ешқандай өнім табылмады.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-undo me-2"></i>Барлық өнімдерді көру
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Футер -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            // Ентер басканда форма жіберіледі
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });

            // Өнім карточкаларына анимация
            const cards = document.querySelectorAll('.product-card');

            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>