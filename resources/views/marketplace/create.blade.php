{{-- resources/views/marketplace/create.blade.php --}}
@extends('layouts.marketplace')

@section('title', 'Тауар қосу - Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-blue-900 mb-4">
            <i class="fas fa-plus-circle mr-3 text-blue-600"></i>
            Жаңа тауар қосу
        </h1>
        <p class="text-xl text-blue-700 opacity-80">Тауарыңызды сипаттаңыз және сатуды бастаңыз</p>
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
        
        <form method="POST" action="{{ route('marketplace.store') }}" id="productForm" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
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
                               value="{{ old('title') }}"
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
                                  placeholder="Тауардың сипаттамасын толық жазыңыз...
• Техникалық сипаттамалар
• Жағдайы
• Қосымша аксессуарлар
• Сату себебі">{{ old('description') }}</textarea>
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
                               value="{{ old('price') }}"
                               placeholder="0">
                        <div class="text-sm text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                            Нарықтағы бағаларды зерттеп, бәсекеге қабілетті баға қойыңыз
                        </div>
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                        <select id="category" name="category" 
                                class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition appearance-none bg-white">
                            <option value="">Категорияны таңдаңыз</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        <div class="text-sm text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                            Тауардың негізгі санатын көрсетіңіз
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Бренд</label>
                        <input type="text" id="brand" name="brand" 
                               class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                               value="{{ old('brand') }}"
                               placeholder="Мысалы: Apple, Samsung, HP, Lenovo, т.б.">
                        <div class="text-sm text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                            Өндіруші фирманы көрсетіңіз
                        </div>
                    </div>
                </div>
            </div>

            <!-- Қосымша ақпарат -->
            <div class="pb-8">
                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                    <i class="fas fa-cogs mr-3 text-blue-600"></i>
                    Қосымша ақпарат
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Жағдайы</label>
                        <select id="condition" name="condition" 
                                class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition appearance-none bg-white">
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>🆕 Жаңа</option>
                            <option value="used" {{ old('condition') == 'used' || !old('condition') ? 'selected' : '' }}>👍 Қолданылған</option>
                            <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>🔧 Жөнделген</option>
                        </select>
                        <div class="text-sm text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                            Тауардың ағымдағы жағдайын нақты көрсетіңіз
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Суреттер</label>
                        
                        <!-- Файл жүктеу -->
                        <div class="border-2 border-dashed border-blue-300 rounded-2xl p-8 text-center hover:border-blue-500 transition-colors bg-blue-50/50 mb-6">
                            <label for="fileInput" class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-5xl text-blue-500 mb-4"></i>
                                <p class="text-lg font-semibold text-gray-700">Суреттерді жүктеу үшін осы жерге басыңыз</p>
                                <p class="text-sm text-gray-500 mt-2">немесе файлдарды осы жерге тартыңыз</p>
                                <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF (Әрқайсысы 2MB дейін)</p>
                            </label>
                            <input type="file" id="fileInput" name="images[]" class="hidden" multiple 
                                   accept="image/jpeg,image/png,image/gif" onchange="updateFilePreview()">
                        </div>
                        
                        <!-- Файлдар алдын ала қарау -->
                        <div class="flex flex-wrap gap-4 mb-8" id="imagePreview"></div>
                        
                        <!-- URL суреттер -->
                        <div class="mb-6">
                            <label for="image_urls" class="block text-sm font-medium text-gray-700 mb-2">
                                Суреттер URL (қосымша)
                            </label>
                            <textarea id="image_urls" name="image_urls" 
                                      class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition h-32"
                                      placeholder="https://example.com/image1.jpg, https://example.com/image2.jpg, https://example.com/image3.jpg"
                                      oninput="updateUrlImagePreview()">{{ old('image_urls') }}</textarea>
                            <div class="text-sm text-gray-500 mt-2 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-blue-500"></i>
                                Суреттердің интернеттегі адрестерін үтірмен бөліп жазыңыз
                            </div>
                            
                            <!-- URL суреттер алдын ала қарау -->
                            <div class="flex flex-wrap gap-4 mt-4" id="urlImagePreview"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Форма әрекеттері -->
            <div class="border-t border-blue-200 pt-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg hover:shadow-xl flex items-center justify-center"
                            id="submitBtn">
                        <i class="fas fa-plus mr-3"></i>
                        Тауар қосу
                    </button>
                    <a href="{{ route('marketplace.index') }}" 
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
    // Файл алдын ала қарау
    function updateFilePreview() {
        const files = document.getElementById('fileInput').files;
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (files.length === 0) return;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Тек сурет файлдарын тексеру
            if (!file.type.match('image.*')) continue;
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'w-24 h-24 border-2 border-blue-200 rounded-xl overflow-hidden relative transition-transform hover:scale-105 shadow';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Сурет алдын ала қарау';
                img.className = 'w-full h-full object-cover';
                
                previewItem.appendChild(img);
                preview.appendChild(previewItem);
            }
            
            reader.readAsDataURL(file);
        }
    }

    // URL суреттерін алдын ала қарау
    function updateUrlImagePreview() {
        const urlsText = document.getElementById('image_urls').value;
        const preview = document.getElementById('urlImagePreview');
        preview.innerHTML = '';
        
        if (urlsText.trim() === '') return;
        
        const urls = urlsText.split(',').map(url => url.trim()).filter(url => url !== '');
        
        urls.forEach(url => {
            if (isValidUrl(url)) {
                const previewItem = document.createElement('div');
                previewItem.className = 'w-24 h-24 border-2 border-blue-200 rounded-xl overflow-hidden relative transition-transform hover:scale-105 shadow';
                
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Сурет алдын ала қарау';
                img.className = 'w-full h-full object-cover';
                img.onerror = function() {
                    previewItem.innerHTML = `
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100">
                            <i class="fas fa-exclamation-triangle text-gray-400 mb-2"></i>
                            <div class="text-xs text-gray-500 text-center px-1">Сурет жүктелмеді</div>
                        </div>
                    `;
                };
                
                previewItem.appendChild(img);
                preview.appendChild(previewItem);
            }
        });
    }

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Символдар санын есептеу
    function updateCharacterCount() {
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const titleCount = document.getElementById('titleCount');
        const descriptionCount = document.getElementById('descriptionCount');
        
        titleCount.textContent = `${title.value.length}/100`;
        descriptionCount.textContent = `${description.value.length}/1000`;
        
        if (title.value.length > 80) {
            titleCount.className = 'text-sm text-orange-500 font-medium';
        } else {
            titleCount.className = 'text-sm text-gray-500';
        }
        
        if (description.value.length > 800) {
            descriptionCount.className = 'text-sm text-orange-500 font-medium';
        } else {
            descriptionCount.className = 'text-sm text-gray-500';
        }
    }

    // Форманы тексеру
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const price = document.getElementById('price').value;
        
        if (!title || !description || !price || price <= 0) {
            e.preventDefault();
            alert('Барлық міндетті өрістерді дұрыс толтырыңыз!');
            return false;
        }
        
        // Жүктелу анимациясы
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<div class="inline-block w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin mr-3"></div> Жүктелуде...';
        submitBtn.disabled = true;
        
        return true;
    });

    // Бағаны форматтау
    document.getElementById('price').addEventListener('blur', function() {
        let value = parseFloat(this.value);
        if (!isNaN(value) && value >= 0) {
            this.value = Math.round(value / 100) * 100; // 100 теңгеге дейін дөңгелектеу
        }
    });

    // Символдар санын бақылау
    document.getElementById('title').addEventListener('input', updateCharacterCount);
    document.getElementById('description').addEventListener('input', updateCharacterCount);

    // Бет жүктелген кезде суреттерді алдын ала көрсету және символдар санын есептеу
    document.addEventListener('DOMContentLoaded', function() {
        updateUrlImagePreview();
        updateCharacterCount();
        
        // URL суреттерін қалпына келтіру
        @if(old('image_urls'))
            updateUrlImagePreview();
        @endif
    });

    // Файлды алып тастау драг-энд-дроп функциясы
    const dropArea = document.querySelector('.border-dashed');
    
    if (dropArea) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-100');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-100');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            const fileInput = document.getElementById('fileInput');
            const dataTransfer = new DataTransfer();
            
            // Барлық файлдарды қосу
            for (let i = 0; i < fileInput.files.length; i++) {
                dataTransfer.items.add(fileInput.files[i]);
            }
            
            // Жаңа файлдарды қосу
            for (let i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }
            
            fileInput.files = dataTransfer.files;
            updateFilePreview();
        }
    }
</script>
@endpush