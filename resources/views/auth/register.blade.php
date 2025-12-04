<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тіркелу - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Register.css') }}">


</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="fas fa-laptop me-2"></i>Laptop.KZ</h2>
                <p class="mb-0">Жаңа аккаунт жасау</p>
            </div>
            
            <div class="auth-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Пайдаланушы аты *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-text">Пайдаланушы аты 3-20 таңбадан тұруы керек</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Құпия сөз *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength mt-2">
                            <div id="passwordStrength" class="strength-weak"></div>
                        </div>
                        <div class="form-text">Құпия сөз кемінде 6 таңбадан тұруы керек</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Құпия сөзді қайталаңыз *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="confirm_password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="form-text"></div>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Тіркелу
                        </button>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label small" for="terms">
                            Мен <a href="#" class="text-decoration-none">қолдану шарттарымен</a> келісемін
                        </label>
                    </div>
                </form>
                
                <div class="text-center">
                    <p class="mb-3">Немесе әлеуметтік желілер арқылы</p>
                    <div class="social-login">
                        <a href="#" class="social-btn">
                            <i class="fab fa-google"></i> Google
                        </a>
                        <a href="#" class="social-btn">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="social-btn">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p>Аккаунтыңыз бар ма? <a href="{{ route('login') }}" class="text-decoration-none">Жүйеге кіру</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) strength++;
            
            const strengthBar = document.getElementById('passwordStrength');
            strengthBar.className = 'password-strength';
            
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchText = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchText.textContent = '';
                matchText.className = 'form-text';
            } else if (password === confirmPassword) {
                matchText.textContent = 'Құпия сөздер сәйкес келеді';
                matchText.className = 'form-text text-success';
            } else {
                matchText.textContent = 'Құпия сөздер сәйкес емес';
                matchText.className = 'form-text text-danger';
            }
        }
        
        // Пайдаланушы атын тексеру
        function validateUsername(username) {
            const regex = /^[a-zA-Z0-9_]{3,20}$/;
            return regex.test(username);
        }
        
        document.getElementById('password').addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
        });
        
        document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);
        
        // Форманы жіберуді тексеру
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="username"]').value;
            const terms = document.getElementById('terms');
            
            if (!validateUsername(username)) {
                e.preventDefault();
                alert('Пайдаланушы аты 3-20 таңбадан тұруы керек және тек әріптер, сандар және _ белгісін қамтуы мүмкін');
                return false;
            }
            
            if (!terms.checked) {
                e.preventDefault();
                alert('Қолдану шарттарымен келісуіңіз керек');
                return false;
            }
        });
    </script>
</body>
</html>