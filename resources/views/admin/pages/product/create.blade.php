@extends('admin.layouts.app')
@section('title', 'Criar Produto')
@section('page-title', 'Criar Novo Produto')

@section('content')
    <div class=" mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informações do Produto</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Preencha os campos abaixo para criar um novo produto.</p>
            </div>

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Título -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Título
                        *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
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
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
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
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resumo -->
                <div>
                    <label for="excerpt"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumo</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preço e Preço com Desconto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preço</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
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
                            value="{{ old('discount_price') }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('discount_price')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- URL Demo -->
                <div>
                    <label for="demo_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL de
                        Demonstração</label>
                    <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    @error('demo_url')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo e Licença -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="product_type"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                        <input type="text" name="product_type" id="product_type" value="{{ old('product_type') }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('product_type')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="license"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Licença</label>
                        <input type="text" name="license" id="license" value="{{ old('license') }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('license')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Versão e Requisitos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="version"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Versão</label>
                        <input type="text" name="version" id="version" value="{{ old('version') }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('version')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="requirements"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requisitos</label>
                        <input type="text" name="requirements" id="requirements" value="{{ old('requirements') }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('requirements')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Compatibilidade -->
                <div>
                    <label for="compatibility"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Compatibilidade</label>
                    <input type="text" name="compatibility" id="compatibility" value="{{ old('compatibility') }}"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    @error('compatibility')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags
                        (separadas por vírgula)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        placeholder="ex: tag1, tag2, tag3">
                    @error('tags')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active') ? 'checked' : '' }} class="rounded text-primary-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ativo</span>
                        </label>
                    </div>
                    <div>
                        <input type="hidden" name="is_featured" value="0">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }} class="rounded text-primary-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Destaque</span>
                        </label>
                    </div>
                </div>


<div class="flex ">

                <!-- Imagem Capa -->
                <div>
                    <label for="cover_image"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagem de Capa</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                        class="w-full text-gray-900 dark:text-gray-100">
                    @error('cover_image')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagens Adicionais -->
                <div>
                    <label for="additional_images"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagens Adicionais</label>
                    <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple
                        class="w-full text-gray-900 dark:text-gray-100">
                    @error('additional_images')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arquivo -->
                <div>
                    <label for="download_file"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Arquivo do Produto</label>
                    <input type="file" name="download_file" id="download_file" accept=".zip,.rar,.7z,.tar,.gz"
                        class="w-full text-gray-900 dark:text-gray-100">
                    @error('download_file')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
</div>


                <!-- Botão Enviar -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-[#d4d5ff] text-[#5855eb] 
        hover:bg-[#c2c3f0] 
        dark:bg-[#3d3fbf] dark:text-[#a7a9ff] 
        dark:hover:bg-[#2f31a5] font-semibold rounded-lg shadow-md transition">
                        Criar Produto
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
