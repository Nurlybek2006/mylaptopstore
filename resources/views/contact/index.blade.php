<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Байланыс - MYLAPTOPSTORE</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin-top: 90px;
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
        .contact-hero {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 4rem 2rem;
            margin: 2rem 0;
            text-align: center;
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .contact-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .contact-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        /* Контактілер сеткасы */
        .contact-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 3rem;
        }
        
        .contact-info {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem;
            height: 100%;
        }
        
        .contact-form {
            padding: 3rem;
        }
        
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }
        
        .info-item:hover {
            transform: translateX(10px);
        }
        
        .info-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .info-content h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .info-content p {
            opacity: 0.9;
            margin-bottom: 0;
            line-height: 1.5;
        }
        
        /* Социаль желілер */
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }
        
        .social-link:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }
        
        /* Форма стильдері */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 1rem 2rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1.1rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }
        
        /* Табтар стильдері */
        .form-tabs {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .form-tab {
            padding: 1rem 2rem;
            background: none;
            border: none;
            font-weight: 600;
            color: var(--secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .form-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        
        .form-tab:hover {
            color: var(--primary);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Ноутбук сұрау формасы */
        .budget-slider {
            width: 100%;
            margin: 1rem 0;
        }
        
        .budget-value {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
            text-align: center;
            margin-top: 0.5rem;
        }
        
        .purpose-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .purpose-option {
            padding: 1.5rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            background: white;
        }
        
        .purpose-option:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
        }
        
        .purpose-option.selected {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }
        
        .purpose-option i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .specs-checklist {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .spec-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            transition: all 0.3s ease;
        }
        
        .spec-checkbox:hover {
            border-color: var(--primary);
        }
        
        .spec-checkbox input[type="checkbox"] {
            accent-color: var(--primary);
        }
        
        /* FAQ бөлімі */
        .faq-section {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }
        
        .faq-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 3rem;
        }
        
        .accordion-button {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px !important;
            padding: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            transition: all 0.3s ease;
        }
        
        .accordion-button:not(.collapsed) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary);
        }
        
        /* Карта бөлімі */
        .map-section {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }
        
        .map-container {
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        /* Анимациялар */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Чат бот стильдері */
        .help-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .help-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }

        .chat-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            display: none;
        }

        .chat-modal {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 400px;
            height: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            z-index: 2000;
            display: none;
            overflow: hidden;
        }

        .chat-container {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h3 {
            margin: 0;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-chat {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-tabs {
            display: flex;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .tab-button {
            flex: 1;
            padding: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background: white;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
        }

        .chat-messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #f8fafc;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .welcome-message {
            text-align: center;
            color: var(--secondary);
            font-style: italic;
            margin-bottom: 1rem;
        }

        .message {
            max-width: 80%;
            padding: 1rem;
            border-radius: 15px;
            position: relative;
        }

        .bot-message {
            background: white;
            border: 1px solid #e2e8f0;
            align-self: flex-start;
        }

        .message-text {
            margin-bottom: 0.5rem;
        }

        .message-time {
            font-size: 0.8rem;
            color: var(--secondary);
            text-align: right;
        }

        .typing-indicator {
            padding: 1rem;
            color: var(--secondary);
            font-style: italic;
            display: none;
        }

        .chat-input-container {
            display: flex;
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            background: white;
        }

        #chat-input {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            padding: 0.75rem 1rem;
            margin-right: 0.5rem;
        }

        #send-message {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
        }

        .email-form {
            padding: 1.5rem;
        }

        .email-form .form-group {
            margin-bottom: 1rem;
        }

        .email-form input,
        .email-form textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .email-form button {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
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

    <!-- Көмек сұрау кнопкасы -->
    <button class="help-button" onclick="openChat()">
        <span>🤖</span>
        Көмек сұрау
    </button>

    <!-- Чат модалды терезесі -->
    <div class="chat-overlay" id="chatOverlay" onclick="closeChat()"></div>
    
    <div class="chat-modal" id="chatModal">
        <div class="chat-container">
            <!-- Чат тақырыбы -->
            <div class="chat-header">
                <h3>
                    <span>🤖</span>
                    Бот-Консультант
                </h3>
                <button class="close-chat" onclick="closeChat()">×</button>
            </div>

            <!-- Табтар -->
            <div class="chat-tabs">
                <button class="tab-button active" onclick="switchTab('chat-tab')">Чат</button>
                <button class="tab-button" onclick="switchTab('email-tab')">Email</button>
            </div>

            <!-- Чат бөлімі -->
            <div id="chat-tab" class="tab-content active">
                <div class="chat-messages-container">
                    <div class="chat-messages" id="chat-messages">
                        <div class="welcome-message">
                            Біз сізге дұрыс ноутбук таңдауға көмектесеміз
                        </div>
                        <div class="message bot-message">
                            <div class="message-text">Сәлеметсіз бе! Мен бот-консультантпын. Сізге қандай салада көмек керек?</div>
                            <div class="message-time" id="current-time">23:42</div>
                        </div>
                    </div>
                    
                    <!-- Енгізу индикаторы -->
                    <div class="typing-indicator" id="typing-indicator">
                        Енгізу...
                    </div>
                </div>

                <!-- Хабарлама енгізу аймағы -->
                <div class="chat-input-container">
                    <input type="text" id="chat-input" placeholder="Мәселеңізді сипаттаңыз...">
                    <button id="send-message" onclick="sendMessage()">Жіберу</button>
                </div>
            </div>

            <!-- Email бөлімі -->
            <div id="email-tab" class="tab-content">
                <div class="email-form">
                    <form id="email-form" action="{{ route('contact.message') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Атыңыз" required value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <textarea name="message" placeholder="Хабарлама" required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit">📧 Хабарлама жіберу</button>

                        <div id="form-message"></div>
                    </form>
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