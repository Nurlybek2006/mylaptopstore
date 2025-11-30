<!DOCTYPE html>
<html lang="kk" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Өнімдерді Басқару - MYLAPTOPSTORE</title>
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
        
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
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
                    <a class="nav-link active" href="{{ route('admin.products.index') }}">
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
                    <h2>Өнімдерді Басқару</h2>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Жаңа өнім
                    </a>
                </div>
                
                <!-- Хабарламалар -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                                
                <!-- Өнімдер кестесі -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Барлық өнімдер ({{ $products->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($products->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Өнімдер табылмады</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Бірінші өнімді қосу
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Сурет</th>
                                            <th>Атауы</th>
                                            <th>Бағасы</th>
                                            <th>Қор</th>
                                            <th>Категория</th>
                                            <th>Қосқан</th>
                                            <th>Әрекет</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                @if($product->image_url)
                                                <img src="{{ $product->image_url }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="product-image"
                                                     onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0zMCAzNEMzMi4yMDkxIDM0IDM0IDMyLjIwOTEgMzQgMzBDMzQgMjcuNzkwOSAzMi4yMDkxIDI2IDMwIDI2QzI3Ljc5MDkgMjYgMjYgMjcuNzkwOSAyNiAzMEMyNiAzMi4yMDkxIDI3Ljc5MDkgMzQgMzAgMzRaIiBmaWxsPSIjOEU5MEEwIi8+CjxwYXRoIGQ9Ik0zNiAzNkgyNEwyOCAyOEwzMiAyNEwzNiAyOEw0MCAzMkwzNiAzNloiIGZpbGw9IiM4RTlBQTAiLz4KPC9zdmc+Cg=='">
                                                @else
                                                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-laptop text-muted"></i>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                <div class="text-muted small">{{ Str::limit($product->description, 50) }}</div>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($product->price, 0, ',', ' ') }} ₸</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->category)
                                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Категория жоқ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $product->user->username ?? 'Жоқ' }}</small>
                                                <div class="text-muted small">
                                                    {{ $product->created_at->format('d.m.Y') }}
                                                </div>
                                            </td>
                                            <td class="table-actions">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                       class="btn btn-warning" 
                                                       title="Өңдеу">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                title="Өшіру"
                                                                onclick="return confirm('Өнімді шынымен өшірейін бе?')">
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

                            <!-- Статистика -->
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h5>{{ $products->count() }}</h5>
                                            <small>Барлық өнімдер</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h5>{{ $products->where('stock', '>', 0)->count() }}</h5>
                                            <small>Қолжетімді өнімдер</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h5>{{ $products->where('stock', 0)->count() }}</h5>
                                            <small>Сатылымнан шығарылған</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h5>{{ number_format($products->avg('price'), 0, ',', ' ') }} ₸</h5>
                                            <small>Орташа баға</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>