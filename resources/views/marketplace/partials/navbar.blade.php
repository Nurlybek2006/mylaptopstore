{{-- resources/views/marketplace/partials/navbar.blade.php --}}
<nav class="marketplace-nav fixed w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Логотип -->
            <a href="{{ route('marketplace.index') }}" class="flex items-center space-x-2 text-white">
                <i class="fas fa-store text-xl"></i>
                <span class="text-xl font-bold">Marketplace</span>
            </a>

            <!-- Навигация элементтері -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('marketplace.index') }}" 
                   class="px-4 py-2 rounded-lg text-white hover:bg-white/10 transition {{ request()->routeIs('marketplace.index') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-home mr-2"></i>Басты бет
                </a>
                
                @auth
                <a href="{{ route('marketplace.create') }}" 
                   class="px-4 py-2 rounded-lg text-white hover:bg-white/10 transition {{ request()->routeIs('marketplace.create') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-plus mr-2"></i>Тауар қосу
                </a>
                
                <a href="{{ route('marketplace.myProducts') }}" 
                   class="px-4 py-2 rounded-lg text-white hover:bg-white/10 transition {{ request()->routeIs('marketplace.myProducts') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-box mr-2"></i>Менің тауарларым
                </a>
                
                <a href="{{ route('marketplace.chats') }}" 
                   class="px-4 py-2 rounded-lg text-white hover:bg-white/10 transition {{ request()->routeIs('marketplace.chats') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-comments mr-2"></i>
                    Чат
                    @php
                        $unreadCount = auth()->user()->marketplace_unread_messages_count;
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
                @endauth
            </div>

            <!-- Оң жақ әрекеттер -->
            <div class="flex items-center space-x-2">
                @auth
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-white hover:bg-white/10 px-3 py-2 rounded-lg transition">
                        <img src="{{ auth()->user()->avatar_url }}" 
                             alt="{{ auth()->user()->name }}"
                             class="w-8 h-8 rounded-full border-2 border-white/20">
                        <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i>Профиль
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Шығу
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-white/10 text-white hover:bg-white/20 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Кіру
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    <i class="fas fa-user-plus mr-2"></i>Тіркелу
                </a>
                @endauth
                
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition ml-2">
                    <i class="fas fa-laptop mr-2"></i>Негізгі сайт
                </a>
                
                <!-- Мобильдік тогглер -->
                <button id="mobileMenuToggle" class="md:hidden text-white p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Мобильдік мәзір -->
        <div id="mobileMenu" class="md:hidden hidden bg-white rounded-lg mt-2 p-4 shadow-lg">
            <div class="space-y-2">
                <a href="{{ route('marketplace.index') }}" 
                   class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('marketplace.index') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-home mr-2 text-blue-600"></i>Басты бет
                </a>
                
                @auth
                <a href="{{ route('marketplace.create') }}" 
                   class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('marketplace.create') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-plus mr-2 text-blue-600"></i>Тауар қосу
                </a>
                
                <a href="{{ route('marketplace.myProducts') }}" 
                   class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('marketplace.myProducts') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-box mr-2 text-blue-600"></i>Менің тауарларым
                </a>
                
                <a href="{{ route('marketplace.chats') }}" 
                   class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('marketplace.chats') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-comments mr-2 text-blue-600"></i>
                    Чат
                    @php
                        $unreadCount = auth()->user()->marketplace_unread_messages_count;
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 inline-flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
                
                <div class="border-t pt-2 mt-2">
                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>Профиль
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 rounded-lg hover:bg-gray-100 text-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i>Шығу
                        </button>
                    </form>
                </div>
                @else
                <div class="border-t pt-2 mt-2">
                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-sign-in-alt mr-2 text-blue-600"></i>Кіру
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-green-600">
                        <i class="fas fa-user-plus mr-2"></i>Тіркелу
                    </a>
                </div>
                @endauth
                
                <div class="border-t pt-2">
                    <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-green-600">
                        <i class="fas fa-laptop mr-2"></i>Негізгі сайт
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Мобильдік мәзір
    document.getElementById('mobileMenuToggle').addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        const icon = this.querySelector('i');
        
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            menu.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
    
    // Сыртқы жерге басқанда мәзірді жабу
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const toggle = document.getElementById('mobileMenuToggle');
        
        if (!menu.contains(event.target) && !toggle.contains(event.target)) {
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                toggle.querySelector('i').classList.remove('fa-times');
                toggle.querySelector('i').classList.add('fa-bars');
            }
        }
    });
</script>