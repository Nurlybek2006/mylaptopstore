<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laptop.KZ')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chatbot CSS (барлық беттерде) -->
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

    <!-- Custom Styles -->
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
            padding-top: 0;
        }

        /* Навигация стильдері */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Футер стильдері */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: auto;
        }

        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        /* Негізгі контент */
        .main-content {
            min-height: calc(100vh - 200px);
        }

        /* Хабарламалар */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .alert-error,
        .alert-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .alert-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
    </style>

    @yield('styles')
</head>

<body>
    
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-laptop me-2"></i>Laptop.KZ
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Басты бет
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-laptop me-1"></i>Өнімдер
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ route('about.index') }}">
                            <i class="fas fa-info-circle me-1"></i>Біз туралы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                            <i class="fas fa-envelope me-1"></i>Байланыс
                        </a>
                    </li>

                    @auth
                    @if(Auth::user()->role !== 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Себет
                            @php
                            $cartCount = count(session('cart', []));
                            @endphp
                            @if($cartCount > 0)
                            <span class="badge bg-warning">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user-circle me-2"></i>Профиль
                                </a></li>

                            @if(Auth::user()->role === 'admin')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i>Админ панелі
                                </a></li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Шығу
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Кіру
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Тіркелу
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Хабарламалар -->
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>

    <!-- Негізгі контент -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-laptop me-2"></i>Laptop.KZ</h5>
                    <p>Қазақстанның сенімді ноутбук дүкені. Біз сізге ең жақсы техникалық шешімдерді ұсынамыз.</p>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Беттер</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Басты бет</a></li>
                        <li><a href="{{ route('products.index') }}">Өнімдер</a></li>
                        <li><a href="{{ route('about.index') }}">Біз туралы</a></li>
                        <li><a href="{{ route('contact.index') }}">Байланыс</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Қызметтер</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Жеткізу</a></li>
                        <li><a href="#">Кепілдік</a></li>
                        <li><a href="#">Техникалық қолдау</a></li>
                        <li><a href="#">Жиі қойылатын сұрақтар</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Байланыс</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i>+7 (777) 123-45-67</li>
                        <li><i class="fas fa-envelope me-2"></i>info@laptop.kz</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Алматы, Қазақстан</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 Laptop.KZ. Барлық құқықтар қорғалған.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Бот-консультант компоненті (әуелі барлық беттерде көрсетіп, қай бетте екенін тексеріңіз) -->
    
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chatbot JavaScript -->
    <script src="{{ asset('js/chatbot.js') }}"></script>

    <!-- Custom Scripts -->
    <script>
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

    <script>
        // Debug үшін: қай бетте екенімізді көрсету
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Ағымдағы бет:', window.location.pathname);
            console.log('Бот компоненті бар ма?', !!document.querySelector('.chat-toggle-button'));
        });
    </script>

    @yield('scripts')
</body>

</html>