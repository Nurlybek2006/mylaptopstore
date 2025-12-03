<!DOCTYPE html>
<html lang="kk" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketplace') - {{ config('app.name', 'Laptop Store') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Стильдер -->
    <style>
        /* Сіздің стильдеріңіз */
        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --accent-blue: #3498db;
            --light-blue: #e3f2fd;
            --success-green: #27ae60;
            --warning-orange: #f39c12;
            --danger-red: #e74c3c;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        }
        
        .marketplace-nav {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 20px rgba(30, 64, 175, 0.3);
        }
        
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
        
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
        
        /* Менің қосқан стильдерім */
        .marketplace-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(102, 126, 234, 0.1);
            z-index: -1;
        }
        
        .chat-bubble {
            border-radius: 20px;
            padding: 12px 16px;
            max-width: 70%;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        
        .chat-bubble.sent {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }
        
        .chat-bubble.received {
            background: white;
            color: #2d3748;
            margin-right: auto;
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .typing-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 8px 16px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .typing-dot {
            width: 6px;
            height: 6px;
            background: #a0aec0;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .price-tag {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .category-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 transparent;
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 20px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: #a0aec0;
        }
        
        /* Chat дизайны */
        .chat-container {
            height: calc(100vh - 64px - 2rem);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .chat-sidebar {
            width: 350px;
            background: white;
            border-right: 1px solid #e2e8f0;
            height: 100%;
        }
        
        .chat-main {
            flex: 1;
            background: #f8fafc;
        }
        
        .chat-messages {
            height: calc(100% - 73px - 81px);
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        /* Адаптивный дизайн */
        @media (max-width: 768px) {
            .chat-container {
                height: calc(100vh - 64px);
                border-radius: 0;
            }
            
            .chat-sidebar {
                width: 100%;
                height: 40%;
            }
            
            .chat-main {
                height: 60%;
            }
        }
    </style>
    
    @yield('styles')
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Marketplace навигация -->
    @include('marketplace.partials.navbar')

    <!-- Контент -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laptop Store') }} Marketplace. Барлық құқықтар қорғалған.</p>
                <p class="mt-2">
                    <a href="{{ route('home') }}" class="text-blue-300 hover:text-white transition">
                        <i class="fas fa-laptop mr-1"></i> Негізгі сайтқа өту
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Уведомления -->
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg notification">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg notification">
        <div class="flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Скрипты -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Автоматическое скрытие уведомлений
        $(document).ready(function() {
            setTimeout(() => {
                $('.notification').fadeOut(300);
            }, 5000);
        });
        
        // Мобильное меню
        $(document).ready(function() {
            $('#mobileMenuToggle').click(function() {
                const $menu = $('#mobileMenu');
                const $icon = $(this).find('i');
                
                $menu.toggleClass('hidden');
                if ($menu.hasClass('hidden')) {
                    $icon.removeClass('fa-times').addClass('fa-bars');
                } else {
                    $icon.removeClass('fa-bars').addClass('fa-times');
                }
            });
            
            // Закрытие меню при клике вне его
            $(document).click(function(event) {
                const $menu = $('#mobileMenu');
                const $toggle = $('#mobileMenuToggle');
                
                if (!$menu.is(event.target) && !$toggle.is(event.target) && 
                    !$menu.has(event.target).length && !$toggle.has(event.target).length) {
                    $menu.addClass('hidden');
                    $toggle.find('i').removeClass('fa-times').addClass('fa-bars');
                }
            });
        });
        
        // CSRF токен для AJAX запросов
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // SweetAlert функциясы
        function showAlert(type, title, text) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            Toast.fire({
                icon: type,
                title: title,
                text: text
            });
        }
        
        // Сообщения об успехе
        @if(session('success'))
            showAlert('success', 'Сәтті!', '{{ session('success') }}');
        @endif
        
        @if(session('error'))
            showAlert('error', 'Қате!', '{{ session('error') }}');
        @endif
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>