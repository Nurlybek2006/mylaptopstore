<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - MYLAPTOPSTORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    @include('layouts.navbar')
    
    <div class="container py-5 mt-4">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="profile-sidebar rounded-3">
                    <div class="text-center">
                        <div class="profile-avatar">
                            <img src="{{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.jpg')) }}" alt="Профиль суреті" id="current-avatar">
                        </div>
                        <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                        <p class="text-light">{{ $user->email }}</p>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'warning' : 'light' }} text-{{ $user->role == 'admin' ? 'dark' : 'muted' }}">
                            {{ $user->role == 'admin' ? 'Админ' : 'Пайдаланушы' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="profile-container p-4">
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
                    
                    <ul class="nav nav-pills mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile" type="button">
                                <i class="fas fa-user me-2"></i>Профиль
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#avatar" type="button">
                                <i class="fas fa-image me-2"></i>Суретті өзгерту
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password" type="button">
                                <i class="fas fa-lock me-2"></i>Құпия сөзді өзгерту
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabContent">
                        <!-- Профиль бөлімі -->
                        <div class="tab-pane fade show active" id="profile">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Аты</label>
                                            <input type="text" name="first_name" class="form-control" 
                                                   value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Тегі</label>
                                            <input type="text" name="last_name" class="form-control" 
                                                   value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Телефон</label>
                                    <input type="tel" name="phone" class="form-control" 
                                           value="{{ old('phone', $user->phone) }}">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Сақтау
                                </button>
                            </form>
                        </div>
                        
                        <!-- Суретті өзгерту бөлімі -->
                        <div class="tab-pane fade" id="avatar">
                            <form method="POST" action="{{ route('profile.avatar') }}" id="avatar-form">
                                @csrf
                                <input type="hidden" name="avatar" id="selected-avatar" value="{{ $user->avatar ?? 'default-avatar.jpg' }}">
                                
                                <div class="mb-4">
                                    <h5>Ағымдағы сурет</h5>
                                    <div class="text-center">
                                        <img src="{{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.jpg')) }}" alt="Ағымдағы сурет" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h5>Жаңа суретті таңдаңыз</h5>
                                    <div class="avatar-options">
                                        @for($i = 1; $i <= 20; $i++)
                                            <img src="{{ asset('storage/avatars/' . $i . '.jpg') }}" 
                                                 class="avatar-option {{ ($user->avatar ?? 'default-avatar.jpg') == $i.'.jpg' ? 'selected' : '' }}" 
                                                 data-avatar="{{ $i }}.jpg"
                                                 alt="Сурет {{ $i }}">
                                        @endfor
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Суретті сақтау
                                </button>
                            </form>
                        </div>
                        
                        <!-- Құпия сөз бөлімі -->
                        <div class="tab-pane fade" id="password">
                            <form method="POST" action="{{ route('profile.password') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Ағымдағы құпия сөз</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Жаңа құпия сөз</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Жаңа құпия сөзді растау</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>Құпия сөзді өзгерту
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Сурет таңдау функциясы
        document.querySelectorAll('.avatar-option').forEach(option => {
            option.addEventListener('click', function() {
                // Барлық таңдаулардан selected класын алып тастау
                document.querySelectorAll('.avatar-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Ағымдағы таңдалғанға selected класын қосу
                this.classList.add('selected');
                
                // Таңдалған суретті сақтау
                const selectedAvatar = this.getAttribute('data-avatar');
                document.getElementById('selected-avatar').value = selectedAvatar;
                
                // Ағымдағы суретті жаңарту
                document.getElementById('current-avatar').src = '{{ asset("storage/avatars/") }}/' + selectedAvatar;
            });
        });
    </script>
</body>
</html>