<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панелі - MYLAPTOPSTORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-sidebar {
            background: #1f2937;
            color: white;
            min-height: 100vh;
            padding: 0;
        }
        
        .admin-sidebar .nav-link {
            color: #d1d5db;
            padding: 1rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background: #374151;
            border-left-color: #3b82f6;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .bg-users { background: #dbeafe; color: #2563eb; }
        .bg-products { background: #dcfce7; color: #16a34a; }
        .bg-orders { background: #fef3c7; color: #d97706; }
        .bg-revenue { background: #fce7f3; color: #db2777; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Админ sidebar -->
            <div class="col-lg-2 admin-sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-laptop me-2"></i>Админ
                    </h4>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Басты бет
                    </a>
                    <a class="nav-link" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-laptop me-2"></i>Өнімдер
                    </a>
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i>Тапсырыстар
                    </a>
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>Пайдаланушылар
                    </a>
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i>Сайтқа өту
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a class="nav-link" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Шығу
                        </a>
                    </form>
                </nav>
            </div>
            
            <!-- Негізгі контент -->
            <div class="col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Админ Панелі</h2>
                    <div class="text-muted">
                        Қош келдіңіз, {{ Auth::user()->username }}!
                    </div>
                </div>
                
                <!-- Хабарламаларды көрсету -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <!-- Статистика -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-users">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>{{ $stats['total_users'] }}</h3>
                            <p class="text-muted mb-0">Пайдаланушылар</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-products">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h3>{{ $stats['total_products'] }}</h3>
                            <p class="text-muted mb-0">Өнімдер</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-orders">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h3>{{ $stats['total_orders'] }}</h3>
                            <p class="text-muted mb-0">Тапсырыстар</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-revenue">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <h3>{{ number_format($stats['total_revenue'], 0, ',', ' ') }} ₸</h3>
                            <p class="text-muted mb-0">Жалпы табыс</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Соңғы өнімдер -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-laptop me-2"></i>Соңғы өнімдер
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($stats['recent_products']->isEmpty())
                                    <p class="text-muted">Өнімдер жоқ</p>
                                @else
                                    @foreach($stats['recent_products'] as $product)
                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <div class="text-muted small">{{ number_format($product->price, 0, ',', ' ') }} ₸</div>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                Қор: {{ $product->stock }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Соңғы пайдаланушылар -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-plus me-2"></i>Соңғы пайдаланушылар
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($stats['recent_users']->isEmpty())
                                    <p class="text-muted">Пайдаланушылар жоқ</p>
                                @else
                                    @foreach($stats['recent_users'] as $user)
                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                        <div>
                                            <strong>{{ $user->username }}</strong>
                                            <div class="text-muted small">{{ $user->email }}</div>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $user->role == 'admin' ? 'warning' : 'secondary' }}">
                                                {{ $user->role }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Жылдам әрекеттер -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Жылдам әрекеттер</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-2"></i>Жаңа өнім
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-success w-100">
                                    <i class="fas fa-laptop me-2"></i>Барлық өнімдер
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-warning w-100">
                                    <i class="fas fa-users me-2"></i>Пайдаланушылар
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('home') }}" class="btn btn-info w-100">
                                    <i class="fas fa-home me-2"></i>Сайтқа өту
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>