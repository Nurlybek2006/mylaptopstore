<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Өнімдер - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">



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