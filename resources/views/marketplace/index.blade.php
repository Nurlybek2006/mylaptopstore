@extends('layouts.marketplace')

@section('title', 'Marketplace')

@section('styles')
<style>
    :root {
        --primary-blue: #1e3c72;
        --secondary-blue: #2a5298;
        --accent-blue: #3498db;
        --light-blue: #e3f2fd;
        --success-green: #27ae60;
        --warning-orange: #f39c12;
        --danger-red: #e74c3c;
    }

    .marketplace-hero {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border-radius: 1rem;
        overflow: hidden;
    }

    .marketplace-product-card {
        transition: all 0.3s ease;
        border: 1px solid #e3f2fd;
    }

    .marketplace-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(30, 60, 114, 0.15);
    }

    .product-badge {
        background: var(--accent-blue);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
    }

    .pagination-btn {
        border: 2px solid var(--light-blue);
        color: var(--primary-blue);
        transition: all 0.3s ease;
    }

    .pagination-btn:hover,
    .pagination-btn.active {
        background: var(--accent-blue);
        color: white;
        border-color: var(--accent-blue);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 2rem;
        border-radius: 1rem;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero секция -->
    <div class="marketplace-hero p-8 mb-8">
        <h1 class="text-4xl font-bold mb-4">Marketplace</h1>
        <p class="text-xl opacity-90">Бай базарда қолданылған ноутбуктерді сатыңыз немесе сатып алыңыз</p>
        
        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-box text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-80">Барлық тауарлар</p>
                        <p class="text-2xl font-bold">{{ $products->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-users text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-80">Белсенді сатушылар</p>
                        <p class="text-2xl font-bold">{{ \App\Models\MarketplaceProduct::distinct('user_id')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-eye text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-80">Жалпы қаралымдар</p>
                        <p class="text-2xl font-bold">{{ \App\Models\MarketplaceProduct::sum('views') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Сүзгілер -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form action="{{ route('marketplace.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Іздеу -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Іздеу</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Тауар аты, сипаттамасы...">
                </div>
                
                <!-- Категория -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Барлығы</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Жағдай -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Жағдай</label>
                    <select name="condition" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Барлығы</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Жаңа</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Қолданылған</option>
                        <option value="refurbished" {{ request('condition') == 'refurbished' ? 'selected' : '' }}>Жөнделген</option>
                    </select>
                </div>
                
                <!-- Баға диапазоны -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Баға диапазоны</label>
                    <div class="flex space-x-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" 
                               class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg" 
                               placeholder="Min" min="0">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" 
                               class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg" 
                               placeholder="Max" min="0">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <div class="text-gray-600">
                    <span>{{ $products->total() }} тауар табылды</span>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('marketplace.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-2"></i>Тазалау
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>Іздеу
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Ескерту -->
    @guest
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Тауар қосу немесе хабарлама жіберу үшін 
                    <a href="{{ route('login') }}" class="font-medium underline">жүйеге кіріңіз</a>.
                </p>
            </div>
        </div>
    </div>
    @endguest

    <!-- Тауарлар -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="marketplace-product-card bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Сурет -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $product->first_image }}" 
                             alt="{{ $product->title }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        
                        <!-- Жағдай баджды -->
                        <div class="product-badge absolute top-3 right-3">
                            {{ $product->condition_text }}
                        </div>
                        
                        <!-- Қаралымдар -->
                        <div class="absolute bottom-3 left-3 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-eye mr-1"></i>{{ $product->views }}
                        </div>
                    </div>
                    
                    <!-- Контент -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-1">
                            {{ $product->title }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($product->description, 100) }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-2xl font-bold text-red-600">
                                    ₸{{ number_format($product->price, 0, ',', ' ') }}
                                </p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-user mr-1"></i>
                                {{ $product->user->name }}
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <a href="{{ route('marketplace.show', $product->id) }}" 
                               class="block w-full py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-eye mr-2"></i>Толығырақ
                            </a>
                            
                            @auth
                                @if(auth()->id() != $product->user_id)
                                    <button onclick="openMessageModal({{ $product->id }}, {{ $product->user_id }})"
                                            class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        <i class="fas fa-comment mr-2"></i>Хабарлама
                                    </button>
                                    <button onclick="addInterest({{ $product->id }})"
                                            class="w-full py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                        <i class="fas fa-heart mr-2"></i>Қызығушылық
                                    </button>
                                @else
                                    <button class="w-full py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-user mr-2"></i>Сіздің тауарыңыз
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full py-2 bg-green-600 text-white text-center rounded-lg hover:bg-green-700 transition">
                                    <i class="fas fa-comment mr-2"></i>Хабарлама
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Пагинация -->
        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <!-- Тауар жоқ болса -->
        <div class="text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Әзірше ешқандай тауар жоқ</h3>
            <p class="text-gray-600 mb-6">Бірінші болып тауар қосыңыз!</p>
            @auth
                <a href="{{ route('marketplace.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Тауар қосу
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-user-plus mr-2"></i>Тіркеліп, тауар қосыңыз
                </a>
            @endauth
        </div>
    @endif
</div>

<!-- Хабарлама модальды терезесі -->
<div id="messageModal" class="modal">
    <div class="flex items-center justify-center min-h-screen">
        <div class="modal-content">
            <span class="close absolute top-4 right-4 text-gray-500 hover:text-gray-700 cursor-pointer text-2xl" onclick="closeMessageModal()">&times;</span>
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-comment mr-2 text-blue-600"></i>Хабарлама жіберу
            </h3>
            
            <form id="messageForm" method="POST" action="{{ route('marketplace.sendMessage') }}">
                @csrf
                <input type="hidden" id="product_id" name="product_id">
                <input type="hidden" id="receiver_id" name="receiver_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Хабарламаңыз
                    </label>
                    <textarea name="message" id="message" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Хабарламаңызды осы жерге жазыңыз..."
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeMessageModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Бас тарту
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>Жіберу
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Хабарлама модальды терезесі
    function openMessageModal(productId, receiverId) {
        document.getElementById('product_id').value = productId;
        document.getElementById('receiver_id').value = receiverId;
        document.getElementById('messageModal').style.display = 'block';
        document.getElementById('message').focus();
    }
    
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        document.getElementById('messageForm').reset();
    }
    
    // Хабарлама формасы
    document.getElementById('messageForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Жіберілуде...';
            submitBtn.disabled = true;
            
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('✅ Хабарлама жіберілді!');
                closeMessageModal();
            } else {
                alert('❌ ' + (data.message || 'Қате орын алды'));
            }
        } catch (error) {
            alert('❌ Қате орын алды!');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
    
    // Қызығушылық білдіру
    async function addInterest(productId) {
        try {
            const response = await fetch('{{ url("marketplace/interest") }}/' + productId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            alert(data.message);
        } catch (error) {
            alert('❌ Қате орын алды!');
        }
    }
    
    // Модальды терезені сыртқы жерге басқанда жабу
    window.onclick = function(event) {
        const modal = document.getElementById('messageModal');
        if (event.target == modal) {
            closeMessageModal();
        }
    }
</script>
@endpush