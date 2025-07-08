@extends('admin.layouts.app')
@section('title', 'Editar Produto')
@section('page-title', 'Editar Produto')

@section('content')
    <div class="mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Editar Informações do Produto</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Altere os dados conforme necessário e clique em salvar.</p>
            </div>

            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Título -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Título
                        *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                    @error('title')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    @error('slug')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resumo -->
                <div>
                    <label for="excerpt"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumo</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">{{ old('excerpt', $product->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preço e Preço com Desconto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preço</label>
                        <input type="number" step="0.01" name="price" id="price"
                            value="{{ old('price', $product->price) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('price')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="discount_price"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preço com
                            Desconto</label>
                        <input type="number" step="0.01" name="discount_price" id="discount_price"
                            value="{{ old('discount_price', $product->discount_price) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('discount_price')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Categoria -->
                <div>
                    <label for="category_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Categoria *</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo, Licença, Versão, Requisitos, Compatibilidade, Tags -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="product_type"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                        <input type="text" name="product_type" id="product_type"
                            value="{{ old('product_type', $product->product_type) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('product_type')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="license"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Licença</label>
                        <input type="text" name="license" id="license" value="{{ old('license', $product->license) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('license')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="version"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Versão</label>
                        <input type="text" name="version" id="version" value="{{ old('version', $product->version) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('version')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="requirements"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requisitos</label>
                        <input type="text" name="requirements" id="requirements"
                            value="{{ old('requirements', $product->requirements) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('requirements')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="compatibility"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Compatibilidade</label>
                        <input type="text" name="compatibility" id="compatibility"
                            value="{{ old('compatibility', $product->compatibility) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('compatibility')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @php
                        $tags = old('tags', $product->tags);
                        // Se for string JSON, decodifica para array
                        if (is_string($tags) && Str::startsWith($tags, '[')) {
                            $tagsArray = json_decode($tags, true);
                            $tags = is_array($tagsArray) ? implode(', ', $tagsArray) : $tags;
                        }
                    @endphp
                    <div class="col-span-2">
                        <label for="tags"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                        <input type="text" name="tags" id="tags" value="{{ $tags }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('tags')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Ativo e Destaque -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="rounded text-primary-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ativo</span>
                        </label>
                    </div>
                    <div>
                        <input type="hidden" name="is_featured" value="0">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="rounded text-primary-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Destaque</span>
                        </label>
                    </div>
                </div>


                <!-- Upload de Nova Imagem de Capa -->
                <div class="grid md:grid-cols-2 gap-4 items-start">
                    <div>
                        <label for="cover_image"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nova Imagem de
                            Capa</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*"
                            class="w-full text-gray-900 dark:text-gray-100">
                    </div>
                    @php
                        $cover = $product->files->firstWhere('type', 'cover_image');
                    @endphp
                    @if ($cover)
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Imagem Atual</p>
                            <img src="{{ asset('storage/' . $cover->file_path) }}" alt="Capa atual"
                                class="w-32 h-32 object-cover mx-auto rounded-lg border dark:border-gray-600">
                        </div>
                    @endif
                </div>

                <!-- Upload de Novas Imagens Adicionais -->
                <div class="grid md:grid-cols-2 gap-4 items-start mt-6">
                    <div>
                        <label for="additional_images"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Novas Imagens Adicionais
                        </label>
                        <input type="file" name="additional_images[]" id="additional_images" accept="image/*"
                            multiple class="w-full text-gray-900 dark:text-gray-100">
                    </div>

                    @php
                        $additionalImages = $product->files->where('type', 'additional_image')->values();
                    @endphp

                    @if ($additionalImages->count() > 0)
                        <div class="w-full">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Imagens Atuais</p>

                            <div class="relative">
                                <!-- Carousel Wrapper -->
                                <div id="carousel"
                                    class="flex gap-x-2 transition-transform duration-300 ease-in-out overflow-hidden w-full">
                                    @foreach ($additionalImages as $image)
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            class="w-32 h-32 object-cover rounded-lg border dark:border-gray-600 shrink-0"
                                            alt="Imagem adicional">
                                    @endforeach
                                </div>


                                <!-- Carousel Controls -->
                                <button type="button" onclick="scrollCarousel(-1)"
                                    class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded-l hover:bg-gray-300 dark:hover:bg-gray-600">
                                    ‹
                                </button>
                                <button type="button" onclick="scrollCarousel(1)"
                                    class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded-r hover:bg-gray-300 dark:hover:bg-gray-600">
                                    ›
                                </button>
                            </div>
                        </div>
                    @endif
                </div>


                <!-- Upload de Novo Arquivo do Produto -->
                <div class="grid md:grid-cols-2 gap-4 items-start mt-6">
                    <div>
                        <label for="download_file"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Novo Arquivo do
                            Produto</label>
                        <input type="file" name="download_file" id="download_file" accept=".zip,.rar,.7z,.tar,.gz"
                            class="w-full text-gray-900 dark:text-gray-100">
                    </div>
                    @php
                        $download = $product->files->firstWhere('type', 'download_file');
                    @endphp
                    @if ($download)
                        <div class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                            <p>Arquivo Atual:
                                <a href="{{ asset('storage/' . $download->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    {{ basename($download->file_path) }}
                                </a>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Botão Enviar -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] font-semibold rounded-lg shadow-md transition">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let scrollIndex = 0;

        function scrollCarousel(direction) {
            const carousel = document.getElementById('carousel');
            const itemWidth = carousel.querySelector('img')?.offsetWidth ?? 128; // fallback 128px
            const gap = 8; // Tailwind gap-x-2 = 0.5rem = 8px
            const step = itemWidth + gap;

            scrollIndex += direction;
            const maxIndex = carousel.children.length - 1;

            // clamp scrollIndex
            scrollIndex = Math.max(0, Math.min(scrollIndex, maxIndex));

            carousel.scrollTo({
                left: scrollIndex * step,
                behavior: 'smooth'
            });
        }
    </script>


@endsection
