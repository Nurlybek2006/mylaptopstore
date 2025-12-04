<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кіру - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">



</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="fas fa-laptop me-2"></i>Laptop.KZ</h2>
                <p class="mb-0">Аккаунтыңызға кіру</p>
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

                <!-- Сынақ аккаунттары үшін ақпарат -->
                <div class="test-accounts mb-3" style="background: #fff3cd; border-radius: 10px; padding: 15px; border-left: 4px solid #ffc107; font-size: 0.8rem;">
                    <h6><i class="fas fa-vial me-2"></i>Сынақ аккаунттары</h6>
                    <p class="mb-1"><strong>Админ:</strong> admin / password</p>
                    <p class="mb-0"><strong>Пайдаланушы:</strong> bolat / password</p>
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Пайдаланушы аты немесе Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Пайдаланушы атыңызды енгізіңіз" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Құпия сөз</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Құпия сөзіңізді енгізіңіз" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Есте сақтау
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none">Құпия сөзді ұмыттыңыз ба?</a>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Кіру
                        </button>
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
                    <p>Аккаунтыңыз жоқ па? <a href="{{ route('register') }}" class="text-decoration-none">Тіркелу</a></p>
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

        // Enter батырмасымен кіру
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('form').submit();
            }
        });
    </script>
</body>
</html>