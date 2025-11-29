<!-- Навигация -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-laptop me-2"></i>Laptop<span class="brand-highlight">.KZ</span>
        </a>
        
        <!-- Mobile toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Негізгі навигация -->
            <div class="navbar-nav me-auto">
                <a class="nav-link nav-item {{ request()->routeIs('home') ? 'active' : '' }}" 
                   href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i>Басты бет
                </a>
                <a class="nav-link nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                   href="{{ route('products.index') }}">
                    <i class="fas fa-laptop me-1"></i>Ноутбуктер
                </a>
                <a class="nav-link nav-item {{ request()->routeIs('about') ? 'active' : '' }}" 
                   href="{{ route('about') }}">
                    <i class="fas fa-info-circle me-1"></i>Біз туралы
                </a>
                <a class="nav-link nav-item {{ request()->routeIs('contact') ? 'active' : '' }}" 
                   href="{{ route('contact') }}">
                    <i class="fas fa-envelope me-1"></i>Байланыс
                </a>
            </div>

            <!-- Пайдаланушы аймағы -->
            <div class="navbar-nav mx-4">
                @auth
                    <!-- Пайдаланушы функциялары -->
                    <a class="nav-link nav-item {{ request()->routeIs('cart') ? 'active' : '' }}" 
                       href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>Себет
                    </a>
                    
                    <a class="nav-link nav-item {{ request()->routeIs('profile') ? 'active' : '' }}" 
                       href="{{ route('profile.index') }}">
                        <i class="fas fa-user me-1"></i>Профиль
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a class="nav-link nav-item logout-link" 
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i>Шығу
                        </a>
                    </form>

                @else
                    <!-- Кіру/Тіркелу -->
                    <a class="nav-link nav-item {{ request()->routeIs('login') ? 'active' : '' }}" 
                       href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Кіру
                    </a>
                    <a class="nav-link nav-item register-link {{ request()->routeIs('register') ? 'active' : '' }}" 
                       href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Тіркелу
                    </a>
                @endauth
            </div>

            <!-- Оң жақ бөлік - Админ және тіл батырмалары -->
            <div class="navbar-nav ms-auto align-items-center">
                <!-- Админ кнопкасы -->
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a class="nav-link nav-item admin-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-crown me-1"></i>Админ
                        </a>
                        <div class="nav-divider"></div>
                    @endif
                @endauth

                <!-- Тіл батырмалары (уақытша сөндірілген) -->
                <div class="language-selector">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'kaz']) }}" 
                       class="lang-btn {{ app()->getLocale() == 'kaz' ? 'active' : '' }}">ҚАЗ</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'rus']) }}" 
                       class="lang-btn {{ app()->getLocale() == 'rus' ? 'active' : '' }}">РУС</a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" 
                       class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">ENG</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.custom-navbar {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    padding: 0.8rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.navbar-brand {
    font-weight: 800;
    font-size: 1.7rem;
    color: white !important;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: translateY(-2px);
}

.brand-highlight {
    color: #4ade80;
    font-weight: 900;
}

.nav-item {
    color: rgba(255, 255, 255, 0.85) !important;
    font-weight: 500;
    margin: 0 0.3rem;
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 0.6rem 1rem !important;
    position: relative;
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.nav-item:hover, .nav-item.active {
    color: white !important;
    background: rgba(255, 255, 255, 0.12);
    transform: translateY(-2px);
}

.nav-item.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 20%;
    width: 60%;
    height: 2px;
    background: #4ade80;
    border-radius: 2px;
}

.nav-divider {
    width: 1px;
    height: 24px;
    background: rgba(255, 255, 255, 0.2);
    margin: 0 15px;
    align-self: center;
}

/* Админ кнопкасына арнайы стиль */
.admin-link {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 193, 7, 0.3) 100%) !important;
    border: 1px solid rgba(255, 193, 7, 0.4);
    margin-right: 15px;
    font-weight: 600;
    padding: 0.6rem 1.2rem !important;
}

.admin-link:hover {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.3) 0%, rgba(255, 193, 7, 0.4) 100%) !important;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
}

.admin-link.active {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.4) 0%, rgba(255, 193, 7, 0.5) 100%) !important;
}

/* Тіркелу сілтемесіне арнайы стиль */
.register-link {
    background: rgba(74, 222, 128, 0.15) !important;
    border: 1px solid rgba(74, 222, 128, 0.3);
}

.register-link:hover {
    background: rgba(74, 222, 128, 0.25) !important;
}

/* Шығу сілтемесіне арнайы стиль */
.logout-link {
    background: rgba(239, 68, 68, 0.15) !important;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.logout-link:hover {
    background: rgba(239, 68, 68, 0.25) !important;
}

/* Тіл батырмалары */
.language-selector {
    display: flex;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    padding: 4px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.lang-btn {
    color: rgba(255, 255, 255, 0.8);
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.8rem;
    min-width: 45px;
    text-align: center;
}

.lang-btn:hover {
    color: white;
    background: rgba(255, 255, 255, 0.15);
}

.lang-btn.active {
    background: white;
    color: #1e3c72 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Мобильдік экран үшін стильдер */
@media (max-width: 991px) {
    .nav-divider {
        display: none;
    }
    
    .language-selector {
        margin-top: 15px;
        justify-content: center;
    }
    
    .nav-item {
        margin: 2px 0;
        justify-content: center;
    }
    
    .admin-link {
        margin-right: 0;
        margin-top: 10px;
        margin-bottom: 5px;
    }
    
    .navbar-nav.mx-4 {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}

/* Егер экран ықшам болса */
@media (max-width: 1200px) {
    .nav-item {
        padding: 0.5rem 0.8rem !important;
        font-size: 0.9rem;
    }
    
    .admin-link {
        margin-right: 10px;
        padding: 0.5rem 1rem !important;
    }
    
    .lang-btn {
        padding: 6px 10px;
        font-size: 0.75rem;
        min-width: 40px;
    }
}
</style>