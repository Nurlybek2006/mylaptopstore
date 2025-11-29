<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ноутбук Дүкені - Laptop.KZ</title>
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
            --success: #10b981;
            --marketplace-blue: #1e3c72;
            --marketplace-accent: #3498db;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f8fafc;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Навигация */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            background: rgba(37, 99, 235, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white !important;
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        /* Герой бөлімі */
        .hero-section {
            background: linear-gradient(235deg, rgba(68, 84, 120, 0.9) 0%, rgba(75, 93, 143, 0.9) 100%), 
                        url('https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2068&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 180px 0 120px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .hero-text {
            text-align: left;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .hero-actions {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            background: linear-gradient(45deg, var(--accent), #e58e0b);
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            color: white;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }
        
        .btn-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-hero:hover::before {
            left: 100%;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.6);
        }
        
        /* Marketplace кнопкасы */
        .marketplace-cta {
            margin-top: 30px;
            padding: 25px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 400px;
        }
        
        .marketplace-text {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
        }
        
        .btn-marketplace {
            background: linear-gradient(135deg, var(--marketplace-blue), #2a5298);
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.4);
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .btn-marketplace::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-marketplace:hover::before {
            left: 100%;
        }
        
        .btn-marketplace:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(30, 60, 114, 0.6);
            color: white;
        }
        
        .hero-visual {
            text-align: center;
            position: relative;
        }
        
        .hero-image {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Статистика */
        .stats-section {
            background: white;
            padding: 80px 0;
            margin-top: -50px;
            position: relative;
            z-index: 3;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        
        .stat-item {
            text-align: center;
            padding: 30px 20px;
            transition: transform 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-10px);
        }
        
        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--secondary);
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        /* Өнім карточкалары */
        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 3rem;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: linear-gradient(45deg, var(--accent), var(--primary));
            border-radius: 3px;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--secondary);
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: 100%;
            position: relative;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .product-card:hover::before {
            transform: scaleX(1);
        }
        
        .product-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .product-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        
        .product-badge.out-of-stock {
            background: #ef4444;
        }
        
        .product-badge.sale {
            background: var(--success);
        }
        
        .product-card-body {
            padding: 2rem;
        }
        
        .product-category {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .product-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .product-description {
            color: var(--secondary);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1.5rem;
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
        
        .rating-count {
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        .btn-product {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .btn-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }
        
        /* Категория карточкалары */
        .categories-section {
            background: linear-gradient(135deg, var(--light) 0%, #fff 100%);
            padding: 100px 0;
            position: relative;
        }
        
        .category-card {
            border: none;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .category-card:hover::before {
            transform: translateX(100%);
        }
        
        .category-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
        }
        
        .category-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        
        .category-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .category-description {
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .btn-category {
            background: rgba(255,255,255,0.2);
            border: 2px solid white;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-category:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Ерекшеліктер */
        .features-section {
            padding: 100px 0;
            background: white;
        }
        
        .feature-card {
            text-align: center;
            padding: 3rem 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: var(--light);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            background: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2.5rem;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: var(--secondary);
            line-height: 1.6;
        }
        
        /* Көп сатылғандар */
        .popular-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--dark) 0%, #1a202c 100%);
            color: white;
        }
        
        .popular-title {
            color: white;
        }
        
        .popular-title::after {
            background: var(--accent);
        }
        
        /* Қолдау бөлімі */
        .support-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
        }
        
        .support-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .support-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .support-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-support {
            background: white;
            color: var(--primary);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-support:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.3);
        }
        
        /* Футер */
        .footer {
            background: var(--dark);
            color: white;
            padding: 80px 0 30px;
        }
        
        .footer h5 {
            color: var(--accent);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--accent);
            transform: translateY(-5px);
        }
        
        /* Анимациялар */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Адаптивтік */
        @media (max-width: 992px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }
            
            .hero-text {
                text-align: center;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-actions {
                justify-content: center;
            }
            
            .marketplace-cta {
                margin: 30px auto 0;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .btn-hero, .btn-marketplace {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Навигация -->
    @include('layouts.navbar')

    <!-- Герой бөлімі -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <div class="hero-text">
                    <h1 class="hero-title">Үздік ноутбуктер сіз үшін</h1>
                    <p class="hero-subtitle">Бізде әр түрлі категориядағы ноутбуктер бар</p>
                    
                    <div class="hero-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-hero">
                            <i class="fas fa-shopping-bag me-2"></i>Дүкенге бару
                        </a>
                    </div>
                    
                    <!-- Marketplace кнопкасы -->
                    <div class="marketplace-cta fade-in-up">
                        <p class="marketplace-text">
                            Ноутбук сатқыңыз келе ме? Біздің маркетплейс арқылы оңай сатыңыз!
                        </p>
                        <a href="{{ route('marketplace') }}" class="btn btn-marketplace">
                            <i class="fas fa-store me-2"></i>
                            MarketPlace
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" 
                         alt="Ноутбук" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Статистика -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <span class="stat-number">{{ $totalProducts }}</span>
                        <span class="stat-label">Өнімдер</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <span class="stat-number">{{ $totalCategories }}</span>
                        <span class="stat-label">Категориялар</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="stat-number">{{ $totalUsers }}</span>
                        <span class="stat-label">Тұтынушылар</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Сапа кепілі</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Таңдаулы өнімдер -->
    <section class="container my-5 py-5">
        <h2 class="section-title fade-in-up">Таңдаулы өнімдер</h2>
        <p class="section-subtitle fade-in-up">Біздің ең жақсы ноутбуктердің тізімі</p>
        
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card fade-in-up">
                <div class="product-image">
                    <img src="{{ $product->image ?? '/images/placeholder.jpg' }}" 
                         alt="{{ $product->name }}">
                    @if($product->stock > 0)
                        <span class="product-badge">Қоймада бар</span>
                    @else
                        <span class="product-badge out-of-stock">Сатылымда жоқ</span>
                    @endif
                    @if(rand(0, 1))
                        <span class="product-badge sale">Жеңілдік</span>
                    @endif
                </div>
                <div class="product-card-body">
                    <div class="product-category">{{ $product->category->name ?? 'Категориясыз' }}</div>
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-description">
                        {{ Str::limit($product->description, 100) }}
                    </p>
                    
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-count">({{ rand(10, 200) }})</span>
                    </div>
                    
                    <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₸</div>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-product">
                        <i class="fas fa-eye me-2"></i>Толығырақ
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-hero">
                <i class="fas fa-list me-2"></i>Барлық өнімдерді көру
            </a>
        </div>
    </section>

    <!-- Категориялар -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Категориялар</h2>
            <p class="section-subtitle fade-in-up">Әр түрлі мақсаттарға арналған ноутбуктер</p>
            
            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card fade-in-up">
                        <div class="category-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="category-title">{{ $category->name }}</h3>
                        <p class="category-description">{{ $category->description }}</p>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-category">
                            Өнімдерді көру
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Ерекшеліктер -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Неге бізді таңдайсыз?</h2>
            <p class="section-subtitle fade-in-up">Біздің артықшылықтарымыз</p>
            
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">24 ай кепілдік</h3>
                        <p class="feature-description">Барлық өнімдерге 24 айға кепілдік береді</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Тегін жеткізу</h3>
                        <p class="feature-description">300.000 ₸ және одан жоғары тапсырыстарға тегін жеткізу</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h3 class="feature-title">14 күн ішінде қайтару</h3>
                        <p class="feature-description">14 күн ішінде өнімді қайтаруға болады</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Қолдау 24/7</h3>
                        <p class="feature-description">Тәулігіне 24 сағат техникалық қолдау көрсетеміз</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Көп сатылғандар -->
    <section class="popular-section">
        <div class="container">
            <h2 class="section-title popular-title fade-in-up">Көп сатылғандар</h2>
            <p class="section-subtitle fade-in-up">Ең танымал ноутбуктер</p>
            
            <div class="products-grid">
                @foreach($popularProducts as $product)
                <div class="product-card fade-in-up">
                    <div class="product-image">
                        <img src="{{ $product->image ?? '/images/placeholder.jpg' }}" 
                             alt="{{ $product->name }}">
                        <span class="product-badge">Танымал</span>
                    </div>
                    <div class="product-card-body">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₸</div>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-product">
                            <i class="fas fa-eye me-2"></i>Толығырақ
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Қолдау бөлімі -->
    <section class="support-section">
        <div class="container">
            <div class="support-content fade-in-up">
                <h2 class="support-title">Көмек керек пе?</h2>
                <p class="support-text">Біз сізге ноутбук таңдауда кеңес береміз</p>
                <a href="{{ route('contact.index') }}" class="btn btn-support">
                    <i class="fas fa-phone me-2"></i>Кеңес алу
                </a>
            </div>
        </div>
    </section>

    <!-- Футер -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Навигацияны скроллдау
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Анимация эффектілері
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in-up');
            
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(50px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.8s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Параллакс эффекті
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            if (parallax) {
                parallax.style.transform = 'translateY(' + (scrolled * 0.5) + 'px)';
            }
        });
    </script>
</body>
</html>