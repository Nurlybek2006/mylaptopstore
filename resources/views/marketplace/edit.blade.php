{{-- resources/views/marketplace/edit.blade.php --}}
@extends('layouts.marketplace')

@section('title', 'Тауарды өңдеу - Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-blue-900 mb-4">
            <i class="fas fa-edit mr-3 text-blue-600"></i>
            Тауарды өңдеу
        </h1>
        <p class="text-xl text-blue-700 opacity-80">Тауарыңыздың ақпаратын жаңартыңыз</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-3xl mx-auto border border-blue-100">
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">Төмендегі қателерді түзетіңіз:</p>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('marketplace.update', $product->id) }}" id="editForm" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Негізгі ақпарат -->
            <div class="border-b border-blue-200 pb-8">
                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                    Негізгі ақпарат
                </h3>

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Тауар атауы <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                               class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                               required
                               value="{{ old('title', $product->title) }}"
                               placeholder="Мысалы: MacBook Pro M2 2023 16GB RAM 512GB SSD"
                               maxlength="100">
                        <div class="flex justify-between items-center mt-2">
                            <div class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                                Тауардың толық және нақты атауын жазыңыз
                            </div>
                            <div class="text-sm text-gray-500" id="titleCount">0/100</div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Сипаттама <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description"
                                  class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition h-48"
                                  required
                                  placeholder="Тауардың сипаттамасын толық жазыңыз...">{{ old('description', $product->description) }}</textarea>
                        <div class="flex justify-between items-center mt-2">
                            <div class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                                Сипаттама неғұрлым толық болса, сатылым соғұрлым жылдам болады
                            </div>
                            <div class="text-sm text-gray-500" id="descriptionCount">0/1000</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Баға және санат -->
            <div class="border-b border-blue-200 pb-8">
                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                    <i class="fas fa-tag mr-3 text-blue-600"></i>
                    Баға және санат
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Баға (₸) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="price" name="price"
                               class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                               step="100" min="0" required
                               value="{{ old('price', $product->price) }}"
                               placeholder="0">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                        <select id="category" name="category"
                                class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition appearance-none bg-white">
                            <option value="">Категорияны таңдаңыз</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Бренд</label>
                        <input type="text" id="brand" name="brand"
                               class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                               value="{{ old('brand', $product->brand) }}"
                               placeholder="Мысалы: Apple, Samsung, HP, Lenovo, т.б.">
                    </div>
                </div>
            </div>

            <!-- Қосымша ақпарат -->
            <div class="border-b border-blue-200 pb-8">
                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                    <i class="fas fa-cogs mr-3 text-blue-600"></i>
                    Қосымша ақпарат
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Жағдайы</label>
                        <select id="condition" name="condition"
                                class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition appearance-none bg-white">
                            <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>🆕 Жаңа</option>
                            <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>👍 Қолданылған</option>
                            <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>🔧 Жөнделген</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                        <select id="status" name="status"
                                class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition appearance-none bg-white">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>✅ Белсенді</option>
                            <option value="sold" {{ old('status', $product->status) == 'sold' ? 'selected' : '' }}>💰 Сатылды</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>❌ Белсенді емес</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Суреттер -->
            <div class="pb-8">
                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                    <i class="fas fa-images mr-3 text-blue-600"></i>
                    Суреттер
                </h3>

                <!-- Қазіргі суреттер -->
                @if($product->images && count($product->images) > 0)
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Қазіргі суреттер (жою үшін басыңыз):</p>
                        <div class="flex flex-wrap gap-4" id="currentImages">
                            @foreach($product->images as $image)
                                <div class="relative w-24 h-24 border-2 border-blue-200 rounded-xl overflow-hidden group cursor-pointer"
                                     onclick="toggleRemoveImage(this, '{{ $image }}')">
                                    <img src="{{ $image }}" alt="Сурет" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-red-500/60 hidden group-hover:flex items-center justify-center remove-overlay">
                                        <i class="fas fa-trash text-white text-xl"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <input type="hidden" name="remove_images" id="removeImages" value="">

                <!-- Жаңа суреттер қосу -->
                <div class="border-2 border-dashed border-blue-300 rounded-2xl p-8 text-center hover:border-blue-500 transition-colors bg-blue-50/50 mb-6">
                    <label for="fileInput" class="cursor-pointer block">
                        <i class="fas fa-cloud-upload-alt text-5xl text-blue-500 mb-4"></i>
                        <p class="text-lg font-semibold text-gray-700">Жаңа суреттер қосу үшін осы жерге басыңыз</p>
                        <p class="text-sm text-gray-500 mt-2">немесе файлдарды осы жерге тартыңыз</p>
                        <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF (Әрқайсысы 2MB дейін)</p>
                    </label>
                    <input type="file" id="fileInput" name="images[]" class="hidden" multiple
                           accept="image/jpeg,image/png,image/gif" onchange="updateFilePreview()">
                </div>

                <div class="flex flex-wrap gap-4 mb-8" id="imagePreview"></div>
            </div>

            <!-- Форма әрекеттері -->
            <div class="border-t border-blue-200 pt-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl flex items-center justify-center"
                            id="submitBtn">
                        <i class="fas fa-save mr-3"></i>
                        Сақтау
                    </button>
                    <a href="{{ route('marketplace.myProducts') }}"
                       class="flex-1 bg-gray-600 text-white font-semibold py-4 px-6 rounded-xl hover:bg-gray-700 transition shadow hover:shadow-lg text-center flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Артқа
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let imagesToRemove = [];

    function toggleRemoveImage(el, imageUrl) {
        const overlay = el.querySelector('.remove-overlay');
        const idx = imagesToRemove.indexOf(imageUrl);

        if (idx === -1) {
            imagesToRemove.push(imageUrl);
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            el.classList.add('opacity-50', 'border-red-400');
        } else {
            imagesToRemove.splice(idx, 1);
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            el.classList.remove('opacity-50', 'border-red-400');
        }

        document.getElementById('removeImages').value = JSON.stringify(imagesToRemove);
    }

    function updateFilePreview() {
        const files = document.getElementById('fileInput').files;
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.match('image.*')) continue;

            const reader = new FileReader();
            reader.onload = function(e) {
                const item = document.createElement('div');
                item.className = 'w-24 h-24 border-2 border-blue-200 rounded-xl overflow-hidden shadow';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';
                item.appendChild(img);
                preview.appendChild(item);
            };
            reader.readAsDataURL(file);
        }
    }

    function updateCharacterCount() {
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const titleCount = document.getElementById('titleCount');
        const descriptionCount = document.getElementById('descriptionCount');

        titleCount.textContent = `${title.value.length}/100`;
        descriptionCount.textContent = `${description.value.length}/1000`;
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const price = document.getElementById('price').value;

        if (!title || !description || !price || price < 0) {
            e.preventDefault();
            alert('Барлық міндетті өрістерді дұрыс толтырыңыз!');
            return false;
        }

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<div class="inline-block w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin mr-3"></div> Сақталуда...';
        submitBtn.disabled = true;
    });

    document.getElementById('title').addEventListener('input', updateCharacterCount);
    document.getElementById('description').addEventListener('input', updateCharacterCount);

    document.addEventListener('DOMContentLoaded', updateCharacterCount);
</script>
@endpush
