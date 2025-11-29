<!-- Футер -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5><i class="fas fa-laptop me-2"></i>Laptop.KZ</h5>
                <p>Қазақстандағы ең ірі ноутбуктер интернет-дүкені. Біз сізге ең жақсы сапа мен қызмет көрсетуді ұсынамыз.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/nur1ybek06?igsh=bndzcnNlYzIxZnI=" class="social-link" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCADDBgnz8ExaIYQcycxA-7w" class="social-link" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-telegram"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <h5>Беттер</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Басты бет</a></li>
                    <li><a href="{{ route('products.index') }}">Ноутбуктер</a></li>
                    <li><a href="{{ route('about.index') }}">Біз туралы</a></li>
                    <li><a href="{{ route('contact.index') }}">Байланыс</a></li>
                    <li><a href="{{ route('marketplace') }}">MarketPlace</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5>Категориялар</h5>
                <ul class="list-unstyled">
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('categories.show', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5>Байланыс</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i>Алматы қаласы, Абай көшесі 123</p>
                <p><i class="fas fa-phone me-2"></i>+7 777 366 4332</p>
                <p><i class="fas fa-envelope me-2"></i>info@laptop.kz</p>
                <p><i class="fas fa-clock me-2"></i>9:00 - 18:00</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p>&copy; 2025 Laptop.Almaty Барлық құқықтар қорғалған</p>
        </div>
    </div>
</footer>

<style>
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

.footer p {
    color: #cbd5e1;
    line-height: 1.6;
    margin-bottom: 1rem;
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
    color: white;
}

.list-unstyled li {
    margin-bottom: 0.5rem;
}

.list-unstyled a {
    display: block;
    padding: 0.25rem 0;
}

hr {
    border-color: rgba(255,255,255,0.1);
}

/* Адаптивтік дизайн */
@media (max-width: 768px) {
    .footer {
        padding: 60px 0 20px;
    }
    
    .footer .row > div {
        margin-bottom: 2rem;
    }
    
    .social-links {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .footer {
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>