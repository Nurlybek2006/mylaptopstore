<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категорияларды Басқару - MYLAPTOPSTORE</title>
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
            margin-bottom: 1.5rem;
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
        
        .bg-total { background: #dbeafe; color: #2563eb; }
        .bg-with-products { background: #dcfce7; color: #16a34a; }
        .bg-empty { background: #fef3c7; color: #d97706; }
        .bg-products { background: #fce7f3; color: #db2777; }
        
        .table-actions {
            white-space: nowrap;
        }
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
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Басты бет
                    </a>
                    <a class="nav-link" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-laptop me-2"></i>Өнімдер
                    </a>
                    <a class="nav-link active" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-folder me-2"></i>Категориялар
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
                    <h2>Категорияларды Басқару</h2>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Жаңа категория
                    </a>
                </div>
                
                <!-- Хабарламаларды көрсету -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Статистика -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-total">
                                <i class="fas fa-folder"></i>
                            </div>
                            <h3>{{ $stats['total_categories'] }}</h3>
                            <p class="text-muted mb-0">Барлық категориялар</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-with-products">
                                <i class="fas fa-box"></i>
                            </div>
                            <h3>{{ $stats['categories_with_products'] }}</h3>
                            <p class="text-muted mb-0">Өнімдері бар</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-empty">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3>{{ $stats['empty_categories'] }}</h3>
                            <p class="text-muted mb-0">Бос категориялар</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-products">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h3>{{ $stats['total_products'] }}</h3>
                            <p class="text-muted mb-0">Барлық өнімдер</p>
                        </div>
                    </div>
                </div>
                
                <!-- Категориялар кестесі -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Барлық категориялар ({{ $categories->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($categories->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Категориялар табылмады</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Бірінші категорияны қосу
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Атауы</th>
                                            <th>Сипаттама</th>
                                            <th>Өнімдер саны</th>
                                            <th>Құрылған күні</th>
                                            <th>Әрекет</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                <strong>{{ $category->name }}</strong>
                                            </td>
                                            <td>
                                                @if($category->description)
                                                    {{ Str::limit($category->description, 50) }}
                                                @else
                                                    <span class="text-muted">Сипаттама жоқ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $category->products_count > 0 ? 'success' : 'secondary' }}">
                                                    {{ $category->products_count }} өнім
                                                </span>
                                            </td>
                                            <td>
                                                {{ $category->created_at->format('d.m.Y') }}
                                            </td>
                                            <td class="table-actions">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('categories.show', $category->id) }}" 
                                                       class="btn btn-info" 
                                                       title="Көру" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                                       class="btn btn-warning" 
                                                       title="Өңдеу">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Категорияны шынымен өшірейін бе?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                title="Өшіру"
                                                                {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Ақпараттық блок -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle me-2"></i>Ақпарат</h6>
                    <ul class="mb-0">
                        <li>Өнімдері бар категорияларды өшіруге болмайды</li>
                        <li>Категорияны өшіру алдында барлық өнімдерді басқа категорияға көшіріңіз</li>
                        <li>Бос категорияларды ғана өшіруге болады</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>