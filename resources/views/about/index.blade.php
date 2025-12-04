<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Біз туралы - MYLAPTOPSTORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">




    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

</head>
<body>
    @include('layouts.navbar')
    @include('components.chatbot')


    <!-- Герой бөлімі -->
    <section class="about-hero">
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1>Біз туралы</h1>
                <p>Қазақстанның жетекші ноутбук дистрибьюторы - сіздің сенімді технологиялық серіктесіңіз</p>
                <div class="mt-4">
                    <a href="#mission" class="btn btn-light btn-lg me-3" style="border-radius: 25px; padding: 12px 30px;">
                        <i class="fas fa-bullseye me-2"></i>Біздің миссия
                    </a>
                    <a href="#team" class="btn btn-outline-light btn-lg" style="border-radius: 25px; padding: 12px 30px;">
                        <i class="fas fa-users me-2"></i>Біздің команда
                    </a>
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
                        <span class="stat-number" data-count="2">0</span>
                        <span class="stat-label">Жылдық тәжірибе</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <span class="stat-number" data-count="10">0</span>
                        <span class="stat-label">Қанағаттанған клиенттер</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <span class="stat-number" data-count="50">0</span>
                        <span class="stat-label">Өнім брендтері</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <span class="stat-number" data-count="100">0</span>
                        <span class="stat-label">Сапа кепілдігі</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Біз туралы -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title fade-in-left">Біздің тарихымыз</h2>
                    <p class="section-subtitle fade-in-left">
                        2022 жылдан бастап технологиялар әлемінде сенімді серіктес ретінде жолға шықтық
                    </p>
                    <div class="about-content fade-in-left">
                        <p>
                            MYLAPTOPSTORE - бұл Қазақстандағы жетекші ноутбук сату және дистрибуция компаниясы. 
                            Біз әртүрлі қажеттіліктерге арналған ең жақсы ноутбуктерді ұсынамыз.
                        </p>
                        <p>
                            Біздің мақсатымыз - әрбір клиентке оның қажеттіліктеріне сай ең үздік шешімді табу.
                        </p>
                        
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Ресми кепілдік</li>
                            <li><i class="fas fa-check"></i> Тегін жеткізу</li>
                            <li><i class="fas fa-check"></i> Қайтару мүмкіндігі</li>
                            <li><i class="fas fa-check"></i> Техникалық қолдау</li>
                            <li><i class="fas fa-check"></i> Бөліп төлеу</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="fade-in-right">
                        <img src="https://images.unsplash.com/photo-1565688534245-05d6b5be184a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Біздің офис" 
                             class="img-fluid rounded-3 shadow-lg" 
                             style="transform: perspective(1000px) rotateY(-5deg) rotateX(5deg); transition: transform 0.5s ease;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Миссия және құндылықтар -->
    <section class="mission-section" id="mission">
        <div class="container">
            <h2 class="section-title text-center fade-in-up">Біздің миссия мен құндылықтар</h2>
            <p class="section-subtitle text-center fade-in-up">
                Біздің жұмыс істеу принциптеріміз және болашаққа деген көзқарасымыз
            </p>
            
            <div class="row mt-5">
                <div class="col-lg-4 mb-4">
                    <div class="mission-card fade-in-left">
                        <div class="mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mission-title">Миссия</h3>
                        <p class="mission-description">
                            Әрбір қазақстандыққа оның бюджетіне және қажеттіліктеріне сай ең үздік ноутбукті ұсыну.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="mission-card fade-in-up">
                        <div class="mission-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="mission-title">Көзқарас</h3>
                        <p class="mission-description">
                            Технологиялар саласындағы жетекші компания болу және инновацияларды дамыту.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="mission-card fade-in-right">
                        <div class="mission-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h3 class="mission-title">Құндылықтар</h3>
                        <p class="mission-description">
                            Шынайылық, сапа, сенімділік және клиентке деген жауапкершілік - біздің негізгі құндылықтарымыз.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Деректер -->
    <section class="timeline-section">
        <div class="container">
            <h2 class="section-title text-center fade-in-up">Біздің саяхатымыз</h2>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2018</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Негізін қалау</h3>
                        <p>Компанияның ресми түрде тіркелуі және алғашқы қадамдары</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2019</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Нарықта орнығу</h3>
                        <p>Алғашқен ірі брендтермен ынтымақтастық басталды</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Өсу жылы</h3>
                        <p>Клиенттер саны екі есе өсті және жаңа филиалдар ашылды</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2022</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Инновациялар</h3>
                        <p>Онлайн сату жүйесі іске қосылып, қызмет көрсету сапасы жақсартылды</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2024</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Болашақ жоспарлар</h3>
                        <p>Жаңа технологияларды енгізу және халықаралық нарыққа шығу</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Команда -->
    <section class="team-section" id="team">
        <div class="container">
            <h2 class="section-title text-center fade-in-up">Негізін қалаушы</h2>
            <p class="section-subtitle text-center fade-in-up">
                Біздің табысымыздың кілті - білімді және тәжірибелі мамандар командасы
            </p>
            
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card fade-in-left">
                        <div class="team-image">
                            <img src="{{ asset('storage/images/Nurlybek.jpg') }}" alt="Nurlybek Sarsenbekuly" onerror="this.src='https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Сәрсенбекұлы Нұрлыбек</h3>
                            <p class="team-position">Негізін қалаушы & CEO</p>
                            <p class="team-description">Технологиялар саласында 5 жылдық тәжірибесі бар маман</p>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                                <a href="https://www.instagram.com/nur1ybek06?igsh=bndzcnNlYzIxZnI=" class="social-link"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </section>

    <!-- Сертификаттар -->
    <section class="certificates-section">
        <div class="container">
            <h2 class="section-title text-center fade-in-up">Біздің сертификаттарымыз</h2>
            
            <div class="row mt-5">
                <div class="col-lg-4 mb-4">
                    <div class="certificate-card fade-in-left">
                        <div class="certificate-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>ASUS Authorized Distributor</h3>
                        <p>ASUS компаниясының ресми сертификатталған дистрибьюторы</p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="certificate-card fade-in-up">
                        <div class="certificate-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>HP Gold Partner</h3>
                        <p>HP компаниясының алтын деңгейдегі серіктесі</p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="certificate-card fade-in-right">
                        <div class="certificate-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3>Жылдың үздік IT компаниясы</h3>
                        <p>2023 жылы Қазақстанның үздік IT компаниясы атандық</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Карта бөлімі -->
    <section class="map-section">
        <div class="container">
            <h2 class="section-title text-center fade-in-up">Біздің орналасқан жеріміз</h2>
            <p class="section-subtitle text-center fade-in-up">
                Бізбен жеке кездесу үшін келіңіз немесе қашықтан байланысыңыз
            </p>
            
            <div class="row mt-5">
                <div class="col-lg-8 mb-4">
                    <div class="map-container fade-in-left">
                        <div id="map" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-card fade-in-right">
                        <div class="info-header" style="text-align: center; margin-bottom: 2rem;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <h3 style="color: var(--dark); font-weight: 600; margin-bottom: 0.5rem;">Бізді табыңыз</h3>
                            <p style="color: var(--secondary);">Біз сізді күтеміз</p>
                        </div>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt" style="color: var(--primary); font-size: 1.2rem; margin-right: 1rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark); font-weight: 600; margin-bottom: 0.3rem; font-size: 1rem;">Мекенжай</h4>
                                    <p style="color: var(--secondary); margin: 0; line-height: 1.5;">
                                        Алматы қаласы,<br>
                                        Шұғыла мкр,<br>
                                        Береке 2/13 үйі
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-clock" style="color: var(--accent); font-size: 1.2rem; margin-right: 1rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark); font-weight: 600; margin-bottom: 0.3rem; font-size: 1rem;">Жұмыс уақыты</h4>
                                    <p style="color: var(--secondary); margin: 0; line-height: 1.5;">
                                        Дүйсенбі - Сенбі: 9:00 - 18:00<br>
                                        Жексенбі: 10:00 - 16:00
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-phone" style="color: var(--success); font-size: 1.2rem; margin-right: 1rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark); font-weight: 600; margin-bottom: 0.3rem; font-size: 1rem;">Телефон</h4>
                                    <p style="color: var(--secondary); margin: 0; line-height: 1.5;">
                                        +7 (777) 366-43-32<br>
                                        +7 (702) 626-93-69
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-envelope" style="color: var(--danger); font-size: 1.2rem; margin-right: 1rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark); font-weight: 600; margin-bottom: 0.3rem; font-size: 1rem;">Email</h4>
                                    <p style="color: var(--secondary); margin: 0; line-height: 1.5;">
                                        info@laptop.kz<br>
                                        support@laptop.kz
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cta-buttons" style="margin-top: 2rem; display: flex; gap: 10px;">
                            <a href="tel:+77773664332" 
                               style="flex: 1; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; padding: 12px; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 600;">
                                <i class="fas fa-phone me-2"></i>Бізге қоңырау шал
                            </a>
                            <a href="https://wa.me/77773664332" 
                               style="flex: 1; background: linear-gradient(135deg, var(--success) 0%, #059669 100%); color: white; padding: 12px; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 600;">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps API -->
    <script>
        function initMap() {
            // Нақты координаттар: 43.211360, 76.795725
            var location = {lat: 43.211360, lng: 76.795725};
            
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: location,
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "geometry",
                        "stylers": [{"color": "#f5f5f5"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.fill",
                        "stylers": [{"gamma": 0.01}, {"lightness": 20}, {"color": "#000000"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.stroke",
                        "stylers": [{"weight": "0.96"}, {"lightness": "16"}, {"visibility": "on"}, {"color": "#000000"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.icon",
                        "stylers": [{"visibility": "off"}]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 40}]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 30}]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 20}]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 20}]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 10}]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 40}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"lightness": 20}]
                    }
                ]
            });
            
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'MYLAPTOPSTORE - Алматы, Шұғыла мкр, Береке 2/13 үйі',
                icon: {
                    url: 'data:image/svg+xml;base64,' + btoa(`
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="25" cy="25" r="25" fill="#2563eb" opacity="0.9"/>
                            <circle cx="25" cy="25" r="15" fill="white"/>
                            <circle cx="25" cy="25" r="8" fill="#2563eb"/>
                            <path d="M25 12L25 38" stroke="white" stroke-width="2"/>
                            <path d="M12 25L38 25" stroke="white" stroke-width="2"/>
                            <path d="M20 15L25 10L30 15" stroke="white" stroke-width="1.5" fill="none"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(50, 50),
                    anchor: new google.maps.Point(25, 50)
                }
            });
            
            var infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="padding: 15px; max-width: 280px; font-family: Arial, sans-serif;">
                        <h3 style="margin: 0 0 12px 0; color: #2563eb; font-size: 18px; font-weight: bold;">
                            <i class="fas fa-laptop" style="margin-right: 8px;"></i>MYLAPTOPSTORE
                        </h3>
                        <div style="margin-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #2563eb; margin-right: 8px; width: 16px;"></i>
                            <span style="color: #333; font-size: 14px;">
                                Алматы, Шұғыла мкр, Береке 2/13 үйі
                            </span>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <i class="fas fa-clock" style="color: #f59e0b; margin-right: 8px; width: 16px;"></i>
                            <span style="color: #666; font-size: 13px;">
                                09:00 - 20:00 (Дүй-Сен)<br>
                                10:00 - 18:00 (Жексенбі)
                            </span>
                        </div>
                        <div style="margin-bottom: 8px;">
                            <i class="fas fa-phone" style="color: #10b981; margin-right: 8px; width: 16px;"></i>
                            <span style="color: #666; font-size: 13px;">
                                +7 (777) 366-43-32
                            </span>
                        </div>
                        <div style="background: #f8fafc; padding: 8px; border-radius: 6px; margin-top: 10px;">
                            <i class="fas fa-info-circle" style="color: #64748b; margin-right: 5px;"></i>
                            <span style="color: #64748b; font-size: 12px;">
                                Тегін паркинг және WiFi бар
                            </span>
                        </div>
                    </div>
                `
            });
            
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
            
            // Автоматты түрде инфо-терезені ашу
            setTimeout(() => {
                infoWindow.open(map, marker);
            }, 1500);
            
            // Картаны ортаға теңеу
            map.setCenter(location);
        }
    </script>
    
    <!-- Google Maps API скрипті -->
    <script async defer 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDQB9wVyyrggShRRdR5VKVvaSfUq4NpSs&callback=initMap&language=kk&region=KZ">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Жүктеу анимациясы
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loadingAnimation').style.opacity = '0';
                document.getElementById('loadingAnimation').style.visibility = 'hidden';
            }, 1000);
        });

        // Статистика санау анимациясы
        function animateCounter(element, target, duration) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target + (element.getAttribute('data-count') === '100' ? '%' : '+');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start) + (element.getAttribute('data-count') === '100' ? '%' : '+');
                }
            }, 16);
        }

        // Таймлайн анимациясы
        function animateTimeline() {
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('visible');
                }, index * 300);
            });
        }

        // Анимация эффектілері
        document.addEventListener('DOMContentLoaded', function() {
            // Бастапқы анимациялар
            const elements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right');
            
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.8s ease';
                    element.style.opacity = '1';
                }, index * 200);
            });

            // Статистиканы бақылау
            const statNumbers = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.getAttribute('data-count'));
                        animateCounter(entry.target, target, 2000);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            statNumbers.forEach(stat => {
                observer.observe(stat);
            });

            // Таймлайн бақылау
            const timelineObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateTimeline();
                        timelineObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            const timelineSection = document.querySelector('.timeline-section');
            if (timelineSection) {
                timelineObserver.observe(timelineSection);
            }

            // Параллакс эффекті
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.about-hero');
                
                parallaxElements.forEach(element => {
                    const speed = 0.5;
                    element.style.backgroundPositionY = -(scrolled * speed) + 'px';
                });
            });

            // Картаны көрсету
            const mapSection = document.querySelector('.map-section');
            const mapObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Картаны қайта жүктеу
                        if (typeof initMap === 'function') {
                            setTimeout(initMap, 500);
                        }
                        mapObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            if (mapSection) {
                mapObserver.observe(mapSection);
            }
        });

        function requestConsultation() {
            alert('Біз сізге жақын арада хабарласамыз! Телефон нөміріңіз: +7 (777) 123-45-67');
        }

        // Навигацияны скроллдау
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
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