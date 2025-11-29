<!DOCTYPE html>
<html lang="kk">
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
        
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            margin-top: 10px;
            display: none;
        }
        
        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 1.5rem;
            border-radius: 0 0 0.375rem 0.375rem;
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
                
                @if ($action == 'add' || $action == 'edit')
                <!-- Өнім қосу/өңдеу формасы -->
                <div class="form-container">
                    <h4>{{ $action == 'add' ? 'Жаңа өнім қосу' : 'Өнімді өңдеу' }}</h4>
                    
                    <form method="POST" 
                          action="{{ $action == 'add' ? route('admin.products.store') : route('admin.products.update', $edit_product->id) }}" 
                          enctype="multipart/form-data" 
                          class="mt-4">
                        @csrf
                        @if($action == 'edit')
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Өнім атауы *</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ old('name', $edit_product->name ?? '') }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Бағасы (₸) *</label>
                                    <input type="number" name="price" class="form-control" step="0.01" 
                                           value="{{ old('price', $edit_product->price ?? '') }}" required>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Қор саны *</label>
                                    <input type="number" name="stock" class="form-control" 
                                           value="{{ old('stock', $edit_product->stock ?? 0) }}" required>
                                    @error('stock')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Категория</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">Категория таңдаңыз</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $edit_product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Сурет жүктеу табтары -->
                                <div class="mb-3">
                                    <label class="form-label">Сурет</label>
                                    
                                    <ul class="nav nav-tabs" id="imageTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="file-tab" data-bs-toggle="tab" data-bs-target="#file" type="button" role="tab">
                                                <i class="fas fa-upload me-1"></i>Файл жүктеу
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button" role="tab">
                                                <i class="fas fa-link me-1"></i>URL арқылы
                                            </button>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content" id="imageTabContent">
                                        <div class="tab-pane fade show active" id="file" role="tabpanel">
                                            <input type="file" name="image" class="form-control" accept="image/*" id="fileInput">
                                            <div class="form-text">PNG, JPG, JPEG форматындағы суреттер (макс. 2MB)</div>
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="tab-pane fade" id="url" role="tabpanel">
                                            <input type="url" name="image_url" class="form-control" 
                                                   placeholder="https://example.com/image.jpg" 
                                                   value="{{ old('image_url', $edit_product->image ?? '') }}" 
                                                   id="urlInput">
                                            <div class="form-text">Интернеттегі суретке сілтеме</div>
                                            <img src="" alt="URL суреті" class="image-preview" id="urlPreview">
                                            @error('image_url')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    @if(isset($edit_product) && $edit_product->image)
                                        <div class="mt-3">
                                            <strong>Қазіргі сурет:</strong>
                                            <div class="mt-2">
                                                <img src="{{ $edit_product->image_url }}" 
                                                     alt="Қазіргі сурет" class="product-image" style="width: 100px; height: 100px;">
                                                <div class="form-text">
                                                    {{ filter_var($edit_product->image, FILTER_VALIDATE_URL) ? 'URL суреті' : 'Жергілікті сурет' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Сипаттама *</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $edit_product->description ?? '') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                {{ $action == 'add' ? 'Өнімді қосу' : 'Өзгерістерді сақтау' }}
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Болдырмау</a>
                        </div>
                    </form>
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
                                                <img src="{{ $product->image_url }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="product-image"
                                                     onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
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
                                                          onsubmit="return confirm('Өнімді шынымен өшірейін бе?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Өшіру">
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
    <script>
        // URL суретін алдын ала көрсету
        document.getElementById('urlInput')?.addEventListener('input', function() {
            const preview = document.getElementById('urlPreview');
            const url = this.value.trim();
            
            if (url && isValidUrl(url)) {
                preview.src = url;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });

        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        // Табтарды ауыстырғанда инпуттарды тазалау
        document.getElementById('file-tab')?.addEventListener('click', function() {
            const urlInput = document.getElementById('urlInput');
            const urlPreview = document.getElementById('urlPreview');
            if (urlInput) urlInput.value = '';
            if (urlPreview) urlPreview.style.display = 'none';
        });

        document.getElementById('url-tab')?.addEventListener('click', function() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput) fileInput.value = '';
        });

        // Егер URL суреті бар болса, алдын ала көрсету
        document.addEventListener('DOMContentLoaded', function() {
            const urlInput = document.getElementById('urlInput');
            const urlPreview = document.getElementById('urlPreview');
            
            if (urlInput && urlInput.value && isValidUrl(urlInput.value)) {
                urlPreview.src = urlInput.value;
                urlPreview.style.display = 'block';
            }
        });
    </script>
</body>
</html>