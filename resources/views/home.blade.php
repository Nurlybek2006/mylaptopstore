<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ноутбук Дүкені - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>
    <!-- Навигация -->
    @include('layouts.navbar')
    @include('components.chatbot')

    <!-- Герой бөлімі -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <div class="hero-text">
                    <h1 class="hero-title">{{ __('main.hero_title') }}</h1>
                    <p class="hero-subtitle">{{ __('main.hero_subtitle') }}</p>

                    <div class="hero-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-hero">
                            <i class="fas fa-shopping-bag me-2"></i>{{ __('main.go_to_store') }}
                        </a>
                    </div>

                    <!-- Marketplace кнопкасы -->
                    <div class="marketplace-cta fade-in-up">
                        <p class="marketplace-text">
                            {{ __('main.market_qw') }}
                        </p>
                        <a href="{{ route('marketplace.index') }}" class="btn btn-marketplace">
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
                        <span class="stat-label">{{ __('main.products') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <span class="stat-number">{{ $totalCategories }}</span>
                        <span class="stat-label">{{ __('main.categories') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="stat-number">{{ $totalUsers }}</span>
                        <span class="stat-label">{{ __('main.customers') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="stat-number">100%</span>
                        <span class="stat-label">{{ __('main.quality_guarantee') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Таңдаулы өнімдер -->
    <section class="container my-5 py-5">
        <h2 class="section-title fade-in-up">{{ __('main.featured_products') }}</h2>
        <p class="section-subtitle fade-in-up">{{ __('main.featured_subtitle') }}</p>

        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card fade-in-up">
                <div class="product-image">
                    <img src="{{ $product->image ?? '/images/placeholder.jpg' }}"
                        alt="{{ $product->name }}">
                    @if($product->stock > 0)
                    <span class="product-badge">{{ __('main.in_stock') }}</span>
                    @else
                    <span class="product-badge out-of-stock">{{ __('main.out_of_stock') }}</span>
                    @endif
                    @if(rand(0, 1))
                    <span class="product-badge sale">{{ __('main.sale') }}</span>
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
                        <i class="fas fa-eye me-2"></i>{{ __('main.view_details') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-hero">
                <i class="fas fa-list me-2"></i>{{ __('main.view_all_products') }}
            </a>
        </div>
    </section>

    <!-- Категориялар -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title fade-in-up">{{ __('main.categories') }}</h2>
            <p class="section-subtitle fade-in-up">{{ __('main.categories_subtitle') }}</p>

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
                            {{ __('main.view_products') }}
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
            <h2 class="section-title fade-in-up">{{ __('main.why_choose_us') }}</h2>
            <p class="section-subtitle fade-in-up">{{ __('main.features_subtitle') }}</p>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">{{ __('main.warranty_24_months') }}</h3>
                        <p class="feature-description">{{ __('main.warranty_description') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">{{ __('main.free_delivery') }}</h3>
                        <p class="feature-description">{{ __('main.delivery_description') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h3 class="feature-title">{{ __('main.return_14_days') }}</h3>
                        <p class="feature-description">{{ __('main.return_description') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">{{ __('main.support_24_7') }}</h3>
                        <p class="feature-description">{{ __('main.support_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Көп сатылғандар -->
    <section class="popular-section">
        <div class="container">
            <h2 class="section-title popular-title fade-in-up">{{ __('main.bestsellers') }}</h2>
            <p class="section-subtitle fade-in-up">{{ __('main.bestsellers_subtitle') }}</p>

            <div class="products-grid">
                @foreach($popularProducts as $product)
                <div class="product-card fade-in-up">
                    <div class="product-image">
                        <img src="{{ $product->image ?? '/images/placeholder.jpg' }}"
                            alt="{{ $product->name }}">
                        <span class="product-badge">{{ __('main.popular') }}</span>
                    </div>
                    <div class="product-card-body">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₸</div>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-product">
                            <i class="fas fa-eye me-2"></i>{{ __('main.view_details') }}
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
                <h2 class="support-title">{{ __('main.need_help') }}</h2>
                <p class="support-text">{{ __('main.support_text') }}</p>
                <a href="{{ route('contact.index') }}" class="btn btn-support">
                    <i class="fas fa-phone me-2"></i>{{ __('main.get_advice') }}
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


    <script>
        // Бот тек қажетті беттерде болсын
        const allowedPages = [
            '/',
            '/products',
            '/about'
        ];

        // Өнім детальды беттерін тексеру (/products/1, /products/2, т.б.)
        const currentPath = window.location.pathname;
        const isProductDetailPage = /^\/products\/\d+$/.test(currentPath);

        // Ағымдағы бет ботқа рұқсат етілген бе?
        const isAllowedPage = allowedPages.includes(currentPath) || isProductDetailPage;

        // DOM жүктелгеннен кейін
        document.addEventListener('DOMContentLoaded', function() {
            if (!isAllowedPage) {
                // Егер бет рұқсат етілмеген болса, ботты толығымен жою
                const chatbot = document.querySelector('.chat-toggle-button, .chat-overlay, .chat-modal');
                if (chatbot) {
                    chatbot.remove();
                }
                return;
            }

            // Ботты бастау
            initChatbot();
        });

        function initChatbot() {
            console.log('Бот іске қосылды!');

            // Ағымдағы уақытты жаңарту
            updateTime();
            setInterval(updateTime, 1000);

            // Enter пернесін басу
            const chatInput = document.getElementById('chat-input');
            if (chatInput) {
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
            }

            // Email формасын өңдеу
            const emailForm = document.getElementById('email-form');
            if (emailForm) {
                emailForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const messageDiv = document.getElementById('form-message');

                    submitButton.classList.add('loading');
                    submitButton.textContent = 'Жіберілуде...';
                    messageDiv.innerHTML = '';

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                messageDiv.innerHTML = `<div class="success-message">${data.message}</div>`;
                                this.reset();
                            } else {
                                messageDiv.innerHTML = `<div class="error-message">${data.message}</div>`;
                            }
                        })
                        .catch(error => {
                            messageDiv.innerHTML = '<div class="error-message">Жіберу кезінде қате пайда болды</div>';
                        })
                        .finally(() => {
                            submitButton.classList.remove('loading');
                            submitButton.textContent = '📧 Хабарлама жіберу';
                        });
                });
            }
        }

        // Ағымдағы уақытты жаңарту
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('kk-KZ', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Чатты ашу
        function openChat() {
            document.getElementById('chatModal').style.display = 'flex';
            document.getElementById('chatOverlay').style.display = 'block';
            const chatInput = document.getElementById('chat-input');
            if (chatInput) {
                chatInput.focus();
            }
        }

        // Чатты жабу
        function closeChat() {
            document.getElementById('chatModal').style.display = 'none';
            document.getElementById('chatOverlay').style.display = 'none';
        }

        // Табтарды ауыстыру
        function switchTab(tabName) {
            // Барлық табтарды жасыру
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Барлық таб баттамаларын жасыру
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Белгіленген табты көрсету
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        // Хабарлама жіберу
        async function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();

            if (message === '') return;

            addMessage(message, 'user');
            input.value = '';

            // Бот жауабын көрсету
            showTypingIndicator();

            try {
                const botResponse = await getChatGPTResponse(message);
                hideTypingIndicator();
                addMessage(botResponse, 'bot');
            } catch (error) {
                hideTypingIndicator();
                addMessage('Кешіріңіз, қате пайда болды. Қайталап көріңіз.', 'bot');
                console.error('ChatGPT қатесі:', error);
            }
        }

        // ChatGPT API арқылы жауап алу
        async function getChatGPTResponse(userMessage) {
            const response = await fetch('/chatbot/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: userMessage
                })
            });

            if (!response.ok) {
                throw new Error('API қатесі');
            }

            const data = await response.json();

            if (data.error) {
                throw new Error(data.error);
            }

            return data.choices[0].message.content;
        }

        // Хабарламаны қосу
        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;

            const now = new Date();
            const timeString = now.toLocaleTimeString('kk-KZ', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            messageDiv.innerHTML = `
        <div class="message-text">${text}</div>
        <div class="message-time">${timeString}</div>
    `;

            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Енгізу индикаторын көрсету
        function showTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                indicator.classList.add('show');
            }
        }

        // Енгізу индикаторын жасыру
        function hideTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                indicator.classList.remove('show');
            }
        }
    </script>

</body>

</html>