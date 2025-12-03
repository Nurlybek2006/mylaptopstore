{{-- resources/views/marketplace/my-products.blade.php --}}
@extends('layouts.marketplace')

@section('title', 'Менің тауарларым - Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Бет тақырыбы -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-3 flex items-center justify-center gap-3">
            <i class="fas fa-box"></i>
            Менің тауарларым
        </h1>
        <p class="text-xl text-blue-700 opacity-80">Сіздің барлық тауарларыңыз бір жерде</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Статистика -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-blue-100">
            <div class="text-3xl font-bold text-blue-900">{{ $stats['total'] }}</div>
            <div class="text-gray-600 mt-1">Барлық тауар</div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-green-100">
            <div class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</div>
            <div class="text-gray-600 mt-1">Белсенді</div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-red-100">
            <div class="text-3xl font-bold text-red-600">{{ $stats['sold'] }}</div>
            <div class="text-gray-600 mt-1">Сатылған</div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-center border border-purple-100">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_views'] }}</div>
            <div class="text-gray-600 mt-1">Жалпы қаралым</div>
        </div>
    </div>

    <!-- Әрекеттер -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8">
        <a href="{{ route('marketplace.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
            <i class="fas fa-plus"></i>
            Жаңа тауар қосу
        </a>
        <a href="{{ route('marketplace.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-gray-700 hover:to-gray-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
            <i class="fas fa-store"></i>
            Барлық тауарлар
        </a>
        <a href="{{ route('marketplace.chats') }}" 
           class="bg-gradient-to-r from-green-600 to-green-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-700 hover:to-green-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
            <i class="fas fa-comments"></i>
            Чат
        </a>
    </div>

    <!-- Сүзгілер -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-200">
        <form method="GET" action="{{ route('marketplace.myProducts') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Барлық статус</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Белсенді</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Сатылған</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Белсенді емес</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Іздеу</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Тауар аты, сипаттамасы...">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>Іздеу
                    </button>
                    <a href="{{ route('marketplace.myProducts') }}" class="ml-2 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Тауарлар -->
    @if($products->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <i class="fas fa-box-open text-6xl text-blue-400 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-700 mb-3">Тауарлар табылмады</h3>
            <p class="text-gray-600 mb-8">Сізде әлі ешқандай тауар жоқ. Бірінші тауарыңызды қосыңыз!</p>
            <a href="{{ route('marketplace.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-3 px-8 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl inline-flex items-center gap-3">
                <i class="fas fa-plus"></i>
                Тауар қосу
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow">
                    <!-- Сурет -->
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $product->first_image }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                             alt="{{ $product->title }}">
                    </div>
                    
                    <!-- Контент -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">
                            {{ $product->title }}
                        </h3>
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-red-600">
                                ₸{{ number_format($product->price, 0, ',', ' ') }}
                            </span>
                            <span class="text-sm text-gray-500 flex items-center gap-1">
                                <i class="fas fa-eye"></i> {{ $product->views }}
                            </span>
                        </div>
                        
                        <!-- Статус -->
                        <div class="mb-4">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-800 border-green-200',
                                    'sold' => 'bg-red-100 text-red-800 border-red-200',
                                    'inactive' => 'bg-gray-100 text-gray-800 border-gray-200'
                                ];
                                $statusText = [
                                    'active' => 'Белсенді',
                                    'sold' => 'Сатылған',
                                    'inactive' => 'Белсенді емес'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColors[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                {{ $statusText[$product->status] ?? 'Белгісіз' }}
                            </span>
                        </div>
                        
                        <!-- Мета ақпарат -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-tag text-blue-500 mr-2 w-4"></i>
                                {{ $product->condition_text }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-heart text-red-500 mr-2 w-4"></i>
                                {{ $product->interests_count }} қызығушылық
                            </div>
                        </div>
                        
                        <!-- Әрекет түймелері -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('marketplace.show', $product->id) }}" 
                               class="bg-blue-600 text-white text-center py-2 px-3 rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-eye"></i>
                                Көру
                            </a>
                            
                            @if($product->status == 'active')
                                <button onclick="markAsSold({{ $product->id }})" 
                                        class="bg-green-600 text-white py-2 px-3 rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-check"></i>
                                    Сатылды
                                </button>
                                
                                <a href="{{ route('marketplace.edit', $product->id) }}" 
                                   class="bg-yellow-600 text-white text-center py-2 px-3 rounded-lg hover:bg-yellow-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    Өңдеу
                                </a>
                                
                                <button onclick="deleteProduct({{ $product->id }})" 
                                        class="bg-red-600 text-white py-2 px-3 rounded-lg hover:bg-red-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-trash"></i>
                                    Жою
                                </button>
                            @elseif($product->status == 'sold')
                                <button onclick="updateStatus({{ $product->id }}, 'active')" 
                                        class="bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Белсенді ету
                                </button>
                            @else
                                <button onclick="updateStatus({{ $product->id }}, 'active')" 
                                        class="bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Белсенді ету
                                </button>
                            @endif
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
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Тауарды сатылды деп белгілеу
    async function markAsSold(productId) {
        const result = await Swal.fire({
            title: 'Сатылды деп белгілеу',
            text: 'Бұл тауарды сатылды деп белгілегіңіз келе ме?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Иә, сатылды',
            cancelButtonText: 'Болдырмау'
        });
        
        if (result.isConfirmed) {
            await updateStatus(productId, 'sold');
        }
    }
    
    // Тауарды жою
    async function deleteProduct(productId) {
        const result = await Swal.fire({
            title: 'Тауарды жою',
            text: 'Бұл тауарды жойғыңыз келетініне сенімдісіз бе? Бұл әрекетті қайтару мүмкін емес!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Иә, жою',
            cancelButtonText: 'Болдырмау',
            dangerMode: true
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch('{{ route("marketplace.destroy", ":id") }}'.replace(':id', productId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success || response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Тауар жойылды!',
                        text: 'Тауар сәтті жойылды.',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Қате орын алды');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Қате',
                    text: error.message,
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    }
    
    // Статусты өзгерту
    async function updateStatus(productId, status) {
        const statusText = {
            'active': 'белсенді',
            'sold': 'сатылған',
            'inactive': 'белсенді емес'
        };
        
        try {
            const response = await fetch('{{ route("marketplace.update-status", ":id") }}'.replace(':id', productId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Статус өзгертілді!',
                    text: `Тауар "${statusText[status]}" деп белгіленді.`,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(data.message || 'Қате орын алды');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Қате',
                text: error.message,
                confirmButtonColor: '#ef4444'
            });
        }
    }
    
    // SweetAlert2 қосу (егер жоқ болса)
    if (typeof Swal === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        document.head.appendChild(script);
    }
</script>

<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .hover-scale {
        transition: transform 0.3s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-5px);
    }
</style>
@endpush