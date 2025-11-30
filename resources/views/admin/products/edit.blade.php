<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Өнімді Өңдеу - MYLAPTOPSTORE</title>
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
        }
        
        .current-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            margin-top: 10px;
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
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
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
                    <h2>Өнімді Өңдеу</h2>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Өнімдер тізіміне оралу
                    </a>
                </div>
                
                <!-- Хабарламаларды көрсету -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Өнім өңдеу формасы -->
                <div class="form-container">
                    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Өнім атауы *</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Бағасы (₸) *</label>
                                    <input type="number" name="price" class="form-control" step="0.01" 
                                           value="{{ old('price', $product->price) }}" required>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Қор саны *</label>
                                    <input type="number" name="stock" class="form-control" 
                                           value="{{ old('stock', $product->stock) }}" min="0" step="1" required>
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
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                    
                                    <!-- Қазіргі сурет -->
                                    @if($product->image)
                                        <div class="mb-3">
                                            <strong>Қазіргі сурет:</strong>
                                            <div class="mt-2">
                                                <img src="{{ $product->image_url }}" 
                                                     alt="Қазіргі сурет" class="current-image">
                                                <div class="form-text">
                                                    {{ filter_var($product->image, FILTER_VALIDATE_URL) ? 'URL суреті' : 'Жергілікті сурет' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
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
                                                   value="{{ old('image_url') }}" 
                                                   id="urlInput">
                                            <div class="form-text">Интернеттегі суретке сілтеме</div>
                                            <img src="" alt="URL суреті" class="image-preview" id="urlPreview">
                                            @error('image_url')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Сипаттама *</label>
                            <textarea name="description" class="form-control" rows="6" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Өзгерістерді сақтау
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Болдырмау</a>
                        </div>
                    </form>
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
    </script>
</body>
</html>