<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Байланыс - MYLAPTOPSTORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">


</head>
<body>
    @include('layouts.navbar')

    <div class="container py-4">
        <!-- Герой бөлімі -->
        <div class="contact-hero fade-in-up">
            <h1>Бізбен Байланысыңыз</h1>
            <p>Кез келген сұрақтарыңыз бойынша бізбен хабарласыңыз. Біз сізге көмектесуге дайынбыз!</p>
        </div>

        <!-- Негізгі контент -->
        <div class="contact-container fade-in-up">
            <div class="row g-0">
                <!-- Контакті ақпараты -->
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h2 class="mb-4">Бізбен хабарласыңыз</h2>
                        <p class="mb-5">Кез келген сұрақтарыңыз бойынша бізбен байланысыңыз. Біз сізге көмектесуге дайынбыз!</p>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Біздің мекенжайымыз</h4>
                                <p>Қазақстан, Алматы қаласы</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <h4>Телефон</h4>
                                <p>+7 (777) 366-43-32<br>+7 (702) 626-93-69</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <h4>Email</h4>
                                <p>info@laptop.kz<br>support@laptop.kz</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <h4>Жұмыс уақыты</h4>
                                <p>Дүйсенбі - Сенбі: 9:00 - 18:00<br>Жексенбі: 10:00 - 16:00</p>
                            </div>
                        </div>
                        
                        <div class="social-links">
                            <a href="https://chat.whatsapp.com/HOeHGym05ow22DWGrWWja6?mode=hqrc" class="social-link">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-telegram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Формалар бөлімі -->
                <div class="col-lg-7">
                    <div class="contact-form">
                        <!-- Табтар -->
                        <div class="form-tabs">
                            <button class="form-tab {{ session('active_tab', 'contact') == 'contact' ? 'active' : '' }}" data-tab="contact-tab">
                                <i class="fas fa-envelope me-2"></i>Хабарлама
                            </button>
                            <button class="form-tab {{ session('active_tab') == 'laptop' ? 'active' : '' }}" data-tab="laptop-tab">
                                <i class="fas fa-laptop me-2"></i>Ноутбук сұрау
                            </button>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif
                        
                        <!-- Хабарлама формасы -->
                        <div id="contact-tab" class="tab-content {{ session('active_tab', 'contact') == 'contact' ? 'active' : '' }}">
                            <h3 class="mb-4">Хабарлама жіберу</h3>
                            <form method="POST" action="{{ route('contact.message') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Атыңыз *</label>
                                            <input type="text" name="name" class="form-control" 
                                                   value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email *</label>
                                            <input type="email" name="email" class="form-control" 
                                                   value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Телефон</label>
                                            <input type="tel" name="phone" class="form-control" 
                                                   value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Тақырып *</label>
                                            <input type="text" name="subject" class="form-control" 
                                                   value="{{ old('subject') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Хабарлама *</label>
                                    <textarea name="message" class="form-control" placeholder="Хабарламаңызды осы жерге жазыңыз..." required>{{ old('message') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Хабарлама жіберу
                                </button>
                            </form>
                        </div>
                        
                        <!-- Ноутбук сұрау формасы -->
                        <div id="laptop-tab" class="tab-content {{ session('active_tab') == 'laptop' ? 'active' : '' }}">
                            <h3 class="mb-4">Ноутбук сұрау</h3>
                            <p class="text-muted mb-4">Сізге қандай ноутбук керектігін сипаттаңыз, біз сізге ең жақсы нұсқаны ұсынамыз</p>
                            
                            <form method="POST" action="{{ route('contact.laptop-request') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Атыңыз *</label>
                                            <input type="text" name="request_name" class="form-control" 
                                                   value="{{ old('request_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email *</label>
                                            <input type="email" name="request_email" class="form-control" 
                                                   value="{{ old('request_email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Телефон</label>
                                            <input type="tel" name="request_phone" class="form-control" 
                                                   value="{{ old('request_phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Бюджет (₸)</label>
                                            <input type="range" name="budget" class="form-range budget-slider" 
                                                   min="100000" max="1000000" step="50000" 
                                                   value="{{ old('budget', 300000) }}">
                                            <div class="budget-value">
                                                <span id="budget-display">{{ number_format(old('budget', 300000), 0, ',', ' ') }}</span> ₸
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Мақсаты *</label>
                                    <div class="purpose-options">
                                        <div class="purpose-option" data-purpose="Оқу">
                                            <i class="fas fa-graduation-cap"></i>
                                            <div>Оқу</div>
                                        </div>
                                        <div class="purpose-option" data-purpose="Жұмыс">
                                            <i class="fas fa-briefcase"></i>
                                            <div>Жұмыс</div>
                                        </div>
                                        <div class="purpose-option" data-purpose="Ойын">
                                            <i class="fas fa-gamepad"></i>
                                            <div>Ойын</div>
                                        </div>
                                        <div class="purpose-option" data-purpose="Дизайн">
                                            <i class="fas fa-palette"></i>
                                            <div>Дизайн</div>
                                        </div>
                                    </div>
                                    <textarea name="purpose" class="form-control" placeholder="Ноутбукті не үшін пайдаланасыз? Сипаттаңыз..." required>{{ old('purpose') }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Қосымша талаптар</label>
                                    <textarea name="specifications" class="form-control" placeholder="Қосымша талаптарыңыз...">{{ old('specifications') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-laptop me-2"></i>Ноутбук сұрау
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ бөлімі -->
        <div class="faq-section fade-in-up">
            <h2 class="faq-title">Жиі Қойылатын Сұрақтар</h2>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Жеткізу уақыты қанша?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Алматы қаласындағы жеткізу 1-2 жұмыс күні ішінде, облыстарға 3-5 жұмыс күні ішінде жүзеге асырылады.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Кепілдік бар ма?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ия, барлық ноутбуктерге 12 ай кепілдік беріледі. Кепілдік қызметі біздің сервис орталықтарымызда жүзеге асырылады.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Төлем әдістері қандай?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Біз нақты ақша, банк карталары, онлайн төлем және бөліп төлеу қабілеттерін қабылдаймыз.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Тауарды қайтаруға бола ма?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ия, сатып алу күнінен бастап 14 күн ішінде тауарды түпнұсқа қалпында қайтаруға болады.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Карта бөлімі -->
        <div class="map-section fade-in-up">
            <div class="map-container">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                    <h4>Біздің орналасқан жеріміз</h4>
                    <p>Қазақстан, Алматы қаласы</p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Табтарды басқару
        document.querySelectorAll('.form-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.form-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Бюджет слайдері
        const budgetSlider = document.querySelector('.budget-slider');
        const budgetDisplay = document.getElementById('budget-display');
        
        if (budgetSlider) {
            budgetSlider.addEventListener('input', function() {
                const value = parseInt(this.value).toLocaleString('ru-RU');
                budgetDisplay.textContent = value;
            });
        }

        // Мақсат опциялары
        document.querySelectorAll('.purpose-option').forEach(option => {
            option.addEventListener('click', function() {
                const purpose = this.getAttribute('data-purpose');
                const textarea = document.querySelector('textarea[name="purpose"]');
                textarea.value = purpose;
                
                document.querySelectorAll('.purpose-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // Чат функциялары
        function openChat() {
            document.getElementById('chatOverlay').style.display = 'block';
            document.getElementById('chatModal').style.display = 'block';
        }

        function closeChat() {
            document.getElementById('chatOverlay').style.display = 'none';
            document.getElementById('chatModal').style.display = 'none';
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            event.target.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (message) {
                // Мұнда чат функциясын қосуға болады
                alert('Чат функциясы әзірленуде...');
                input.value = '';
            }
        }

        // Анимация эффектілері
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in-up');
            
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
        
        // Навигацияны скроллдау
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Уақытты жаңарту
        function updateTime() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                             now.getMinutes().toString().padStart(2, '0');
            document.getElementById('current-time').textContent = timeString;
        }

        setInterval(updateTime, 60000);
        updateTime();
    </script>
</body>
</html>