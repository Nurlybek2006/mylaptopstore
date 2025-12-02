{{-- resources/views/marketplace/show.blade.php --}}
@extends('layouts.marketplace')

@section('title', $product->title . ' - Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Тауар атауы -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-4">{{ $product->title }}</h1>
    </div>

    <!-- Негізгі ақпарат -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Суреттер галереясы -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
            <div class="relative rounded-xl overflow-hidden mb-6">
                <img id="mainImage" src="{{ $product->first_image }}" 
                     class="w-full h-[500px] object-cover rounded-xl transition-transform duration-300 hover:scale-105"
                     alt="{{ $product->title }}">
                
                <!-- Бейдждер -->
                <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                    <i class="fas fa-eye mr-1"></i> {{ $product->views }} қаралым
                </div>
                <div class="absolute top-4 left-4 bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                    {{ $product->condition_text }}
                </div>
            </div>
            
            <!-- Суреттер тізімі -->
            @if(count($product->images) > 1)
                <div class="flex gap-3 overflow-x-auto py-3">
                    @foreach($product->images as $index => $image)
                        <img src="{{ $image }}" 
                             class="w-20 h-20 object-cover rounded-lg cursor-pointer border-2 {{ $index === 0 ? 'border-blue-500' : 'border-transparent' }} hover:border-blue-300 transition"
                             onclick="changeImage('{{ $image }}', this)"
                             alt="{{ $product->title }} - сурет {{ $index + 1 }}">
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Тауар ақпараты -->
        <div class="space-y-6">
            <!-- Баға -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-8 border-2 border-blue-200 text-center">
                <div class="text-5xl font-bold text-red-600 mb-2">
                    ₸{{ number_format($product->price, 0, ',', ' ') }}
                </div>
                <p class="text-gray-600">Бірлік бағасы</p>
            </div>

            <!-- Мета ақпарат -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-folder text-blue-500 text-lg"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Категория</p>
                            <p class="font-semibold">{{ $product->category ?: 'Жоқ' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-green-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-copyright text-green-500 text-lg"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Бренд</p>
                            <p class="font-semibold">{{ $product->brand ?: 'Жоқ' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-purple-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar text-purple-500 text-lg"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Қосылған</p>
                            <p class="font-semibold">{{ $product->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-heart text-yellow-500 text-lg"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Қызығушылық</p>
                            <p class="font-semibold">{{ $product->interests_count ?? 0 }} адам</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Сипаттама -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-600"></i>
                    Сипаттама
                </h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $product->description }}
                </div>
            </div>

            <!-- Сатушы ақпараты -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center text-white text-xl font-bold">
                        {{ strtoupper(mb_substr($product->user->name, 0, 1, 'UTF-8')) }}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">{{ $product->user->name }}</h4>
                        <p class="text-gray-600">Сатушы</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('marketplace.chat', $product->user_id) }}" 
                       class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <i class="fas fa-comments"></i>
                        Сатушымен сөйлесу
                    </a>
                    
                    @if($product->user->phone)
                        <a href="tel:{{ $product->user->phone }}" 
                           class="w-full bg-gradient-to-r from-green-600 to-green-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-700 hover:to-green-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                            <i class="fas fa-phone"></i>
                            {{ $product->user->phone }}
                        </a>
                    @endif
                    
                    <button onclick="addInterest({{ $product->id }})" 
                           class="w-full bg-gradient-to-r from-yellow-600 to-yellow-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-yellow-700 hover:to-yellow-900 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <i class="fas fa-heart"></i>
                        Қызығушылық білдіру
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Чат бөлімі -->
    @auth
        @if(auth()->id() != $product->user_id)
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-12 border border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <i class="fas fa-comments text-blue-600 text-xl"></i>
                    <h3 class="text-xl font-bold text-gray-800">Сатушымен сөйлесу</h3>
                </div>
                
                <!-- Чат хабарламалары -->
                <div class="h-80 overflow-y-auto mb-6 p-4 bg-gray-50 rounded-xl space-y-4" id="chatMessages">
                    @foreach($chatMessages as $message)
                        <div class="max-w-3/4 {{ $message->sender_id == auth()->id() ? 'ml-auto' : 'mr-auto' }}">
                            <div class="p-4 rounded-2xl {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none' }}">
                                <p class="mb-2">{{ $message->message }}</p>
                                <div class="text-xs opacity-75 {{ $message->sender_id == auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                                    {{ $message->sender->name }} • {{ $message->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Хабарлама жіберу формасы -->
                <form method="POST" action="{{ route('marketplace.send-product-message', $product->id) }}" 
                      id="chatForm" class="flex gap-3">
                    @csrf
                    <input type="text" name="message" 
                           class="flex-1 px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                           placeholder="Хабарламаңызды осы жерге жазыңыз..." required>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Жіберу
                    </button>
                </form>
                
                @if(session('success'))
                    <div class="mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            <span class="text-red-700">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @else
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-xl mb-12">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                <div>
                    <p class="text-blue-700 font-medium">Сатушымен сөйлесу үшін</p>
                    <p class="text-blue-600">
                        <a href="{{ route('login') }}" class="underline font-semibold">жүйеге кіріңіз</a>
                    </p>
                </div>
            </div>
        </div>
    @endauth

    <!-- Ұқсас тауарлар -->
    @if($similarProducts->isNotEmpty())
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-th-large text-blue-600"></i>
                Ұқсас тауарлар
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarProducts as $similar)
                    <a href="{{ route('marketplace.show', $similar->id) }}" 
                       class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden border border-gray-200 hover:-translate-y-1 transition-transform">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $similar->first_image }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 alt="{{ $similar->title }}">
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                                {{ $similar->title }}
                            </h4>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-red-600">
                                    ₸{{ number_format($similar->price, 0, ',', ' ') }}
                                </span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-eye"></i> {{ $similar->views }}
                                </span>
                            </div>
                            <div class="mt-3 text-center">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                                    <i class="fas fa-eye mr-1"></i> Толығырақ
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Бағыттау түймелері -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('marketplace.index') }}" 
           class="bg-gray-600 text-white font-semibold py-3 px-6 rounded-xl hover:bg-gray-700 transition shadow text-center flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Барлық тауарларға оралу
        </a>
        
        @auth
            @if(auth()->id() == $product->user_id)
                <a href="{{ route('marketplace.edit', $product->id) }}" 
                   class="bg-yellow-600 text-white font-semibold py-3 px-6 rounded-xl hover:bg-yellow-700 transition shadow text-center flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i>
                    Тауарды өңдеу
                </a>
            @endif
        @endauth
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Суреттерді ауыстыру
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        
        // Барлық суреттердің border-ын алып тастау
        document.querySelectorAll('.thumbnail').forEach(img => {
            img.classList.remove('border-blue-500');
            img.classList.add('border-transparent');
        });
        
        // Таңдалған суретті белгілеу
        element.classList.remove('border-transparent');
        element.classList.add('border-blue-500');
    }

    // Чатты төменгі жағына скроллдау
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Документ жүктелген кезде скролл
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
    });

    // Форма жіберілген кезде скролл
    document.getElementById('chatForm')?.addEventListener('submit', function() {
        setTimeout(scrollToBottom, 100);
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
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Құттықтаймын!',
                    text: data.message,
                    confirmButtonColor: '#3498db'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Қате',
                    text: data.message,
                    confirmButtonColor: '#e74c3c'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Қате орын алды!',
                text: 'Жүйеде қате орын алды',
                confirmButtonColor: '#e74c3c'
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
    /* Additional styles for chat */
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .thumbnail {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .thumbnail:hover {
        transform: scale(1.05);
    }
    
    #chatMessages::-webkit-scrollbar {
        width: 6px;
    }
    
    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    #chatMessages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endpush