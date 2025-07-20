@extends('frontend.layouts.app')

@section('title', 'Produtos')
@section('page-title', 'Produtos')
@section('content')

    <section class="products-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="logo">Descubra Projetos Incríveis</h1>
                <p>Explore nossa coleção completa de projetos profissionais prontos para uso. Encontre a solução perfeita
                    para seu negócio.</p>
            </div>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="filters-section">
                <div class="filters-header">
                    <h3>Filtrar Produtos</h3>
                    <button class="filter-toggle" onclick="toggleFilters()">
                        <i class="fas fa-filter"></i> Filtros
                    </button>
                </div>

                <div class="filters-container" id="filtersContainer">
                    <!-- Search Filter -->
                    <div class="filter-group">
                        <label for="search">Buscar:</label>
                        <div class="search-input-group">
                            <input type="text" id="search" name="search" placeholder="Digite o nome do produto..."
                                value="{{ request('search') }}">
                            <button type="button" onclick="applyFilters()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-group">
                        <label for="category">Categoria:</label>
                        <select id="category" name="category_id">
                            <option value="">Todas as Categorias</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-group">
                        <label>Faixa de Preço:</label>
                        <div class="price-range">
                            <input type="number" id="min_price" name="min_price" placeholder="Min"
                                value="{{ request('min_price') }}">
                            <span>até</span>
                            <input type="number" id="max_price" name="max_price" placeholder="Max"
                                value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <!-- Featured Filter -->
                    <div class="filter-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="featured" name="featured"
                                {{ request('featured') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            Apenas em Destaque
                        </label>
                    </div>

                    <!-- Sort Filter -->
                    <div class="filter-group">
                        <label for="sort">Ordenar por:</label>
                        <select id="sort" name="sort">
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>
                                Mais Recentes</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor Preço
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Maior Preço
                            </option>
                            <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Melhor
                                Avaliação</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Nome A-Z
                            </option>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn btn-primary" onclick="applyFilters()">
                            <i class="fas fa-filter"></i> Aplicar Filtros
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                            <i class="fas fa-times"></i> Limpar
                        </button>
                    </div>
                </div>
            </div>

            <div class="products-content">
                <div class="products-header">
                    <div class="results-info">
                        <span>{{ $products->count() }} produtos encontrados</span>
                    </div>
                    <div class="view-toggle">
                        <button class="view-btn active" onclick="setView('grid')" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" onclick="setView('list')" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <div class="products-grid" id="productsGrid">
                    @forelse($products as $product)
                        <div class="product-card">
                            @if ($product->is_featured)
                                <div class="product-badge">
                                    <i class="fas fa-star"></i> Destaque
                                </div>
                            @endif
                            @php
                                $cover = $product->files->firstWhere('type', 'cover_image');
                                $imageUrl = $cover
                                    ? asset('storage/' . $cover->file_path)
                                    : asset('images/default.jpg');
                            @endphp

                            <div class="product-image">
                                <div class="image-placeholder">
                                    <img src="{{ $imageUrl }}" alt="" srcset="" width="400px">

                                </div>
                                <div class="product-overlay">
                                    <div class="overlay-actions">
                                        <a href="{{ route('frontend.show', $product->slug) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i> Ver Detalhes
                                        </a>
                                        @if ($product->demo_url)
                                            <a href="{{ $product->demo_url }}" target="_blank" class="btn btn-secondary">
                                                <i class="fas fa-external-link-alt"></i> Demo
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="product-content">
                                <div class="product-header">
                                    <h3 class="product-title">{{ $product->title }}</h3>
                                    <div class="product-rating">
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= ($product->average_rating ?? 0) ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span
                                            class="rating-number">({{ number_format($product->average_rating ?? 0, 1) }})</span>
                                    </div>
                                </div>

                                <p class="product-description">
                                    {{ Str::limit($product->excerpt ?? $product->description, 100) }}
                                </p>

                                <div class="product-meta">
                                    <span class="product-category">
                                        <i class="fas fa-tag"></i> {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                    <span class="product-type">
                                        <i class="fas fa-cube"></i> {{ ucfirst($product->product_type) }}
                                    </span>
                                </div>

                                @if ($product->tags)
                                    <div class="product-tags">
                                        @php
                                            $tags =
                                                is_string($product->tags) && Str::startsWith($product->tags, '[')
                                                    ? json_decode($product->tags, true)
                                                    : (is_array($product->tags)
                                                        ? $product->tags
                                                        : explode(',', $product->tags));
                                        @endphp
                                        @foreach (array_slice($tags, 0, 3) as $tag)
                                            <span class="tag">{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="product-price">
                                    @if ($product->discount_price)
                                        <span class="price-current">R$
                                            {{ number_format($product->discount_price, 2, ',', '.') }}</span>
                                        <span class="price-old">R$
                                            {{ number_format($product->price, 2, ',', '.') }}</span>
                                        <span class="discount-percent">
                                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                            OFF
                                        </span>
                                    @else
                                        <span class="price-current">R$
                                            {{ number_format($product->price, 2, ',', '.') }}</span>
                                    @endif
                                </div>

                                <div class="product-actions">
                                    <button type="button" class="btn btn-primary"
                                        onclick="openPurchaseModal(
    {{ $product->id }},
    {{ number_format($product->price, 2, '.', '') }},
    {{ number_format($product->discount_price ?? 0, 2, '.', '') }}
)">
                                        <i class="fas fa-shopping-cart"></i> Comprar Agora
                                    </button>


                                    <button class="btn btn-secondary" onclick="addToWishlist({{ $product->id }})">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-products">
                            <div class="no-products-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Nenhum produto encontrado</h3>
                            <p>Tente ajustar seus filtros ou fazer uma nova busca.</p>
                            <button class="btn btn-primary" onclick="clearFilters()">
                                <i class="fas fa-refresh"></i> Limpar Filtros
                            </button>
                        </div>
                    @endforelse
                </div>

                @if ($products->hasPages())
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        function toggleFilters() {
            const container = document.getElementById('filtersContainer');
            container.classList.toggle('active');
        }

        function applyFilters() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route('frontend.shop') }}';

            const inputs = document.querySelectorAll('#filtersContainer input, #filtersContainer select');
            inputs.forEach(input => {
                if (input.value && (input.type !== 'checkbox' || input.checked)) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = input.name;
                    hiddenInput.value = input.value;
                    form.appendChild(hiddenInput);
                }
            });

            document.body.appendChild(form);
            form.submit();
        }

        function clearFilters() {
            window.location.href = '{{ route('frontend.shop') }}';
        }

        function setView(view) {
            const grid = document.getElementById('productsGrid');
            const buttons = document.querySelectorAll('.view-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-view="${view}"]`).classList.add('active');

            grid.className = view === 'list' ? 'products-list' : 'products-grid';
        }

        function addToWishlist(productId) {
            // Implementar lógica de wishlist aqui
            console.log('Adicionado à wishlist:', productId);
        }

        // Auto-apply filters on input change
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        document.getElementById('category').addEventListener('change', applyFilters);
        document.getElementById('sort').addEventListener('change', applyFilters);
    </script>

    <!-- Modal para Efetuar Compra -->
    <div id="purchaseModal"
        class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 flex items-center justify-center min-h-screen">
        <div class="bg-white dark:bg-gray-800 w-full max-w-lg mx-auto rounded-xl shadow p-6 relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                onclick="closePurchaseModal()">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Finalizar Compra</h2>

            <form id="purchaseForm" method="POST" action="{{ route('orders.store') }}">
                @csrf

                <!-- User ID -->
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <!-- Product ID -->
                <input type="hidden" name="product_id" id="purchaseProductId">

                <!-- Número do Pedido -->
                <div class="mb-4">
                    <label for="order_number"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número do Pedido</label>
                    <input type="text" name="order_number" id="order_number"
                        value="{{ 'ORD-' . strtoupper(Str::random(6)) }}"
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white"
                        readonly>
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <label for="price_display"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Preço</label>
                    <input type="text" id="price_display" readonly
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white">
                    <input type="hidden" name="price" id="purchasePrice">
                </div>



                <!-- Método de Pagamento -->
                <div class="mb-4">
                    <label for="payment_method"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de Pagamento</label>
                    <select name="payment_method" id="payment_method"
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white">
                        <option value="mpesa">M-pesa</option>
                        <option value="emola">E-mola</option>
                    </select>
                </div>
                <!-- Desconto -->
                <div class="mb-4">
                    <label for="discount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numero
                        de Telefone</label>
                    <input type="text" step="0.01" name="phone"
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white">
                </div>

                <!-- Status -->
                <input type="hidden" name="status" value="pending">

                <!-- Data de Pagamento -->
                <input type="hidden" name="paid_at" id="paid_at" value="">
                <input type="hidden" name="platform_fee" id="platform_fee" value="">
                <input type="hidden" name="payout_amount" id="payout_amount" value="">
                <input type="hidden" name="discount" id="discount" value="">
                <input type="hidden" name="status" id="status" value="">

                <!-- Moeda -->
                <input type="hidden" name="currency" value="BRL">

                <div class="flex justify-end mt-6">
                    <button type="button" onclick="closePurchaseModal()"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mr-2">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">
                        Confirmar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>

  <script>
const commissionRate = parseFloat("{{ $settings->commission_rate ?? 100 }}") / 100;
    console.log('comissão da empresa:', commissionRate);

    function openPurchaseModal(productId, originalPrice, discountedPrice) {
        document.getElementById('purchaseProductId').value = productId;
        const now = new Date().toISOString();
        document.getElementById('paid_at').value = now;
        document.getElementById('status').value = "completed";
        originalPrice = parseFloat(originalPrice) || 0;
        discountedPrice = parseFloat(discountedPrice) || 0;

        console.log('preco: ',originalPrice,' disconto: ',discountedPrice)

        // Se houver desconto válido, usa ele para cálculo e exibição
        let priceForCalculation = 0;
        let displayPrice = 0;

        if (discountedPrice > 0 ) {
            priceForCalculation = discountedPrice;
            displayPrice = discountedPrice;
        }else{
            priceForCalculation = originalPrice;
            displayPrice = originalPrice;
        }
        console.log('calculos: ',priceForCalculation,' mostrar: ',displayPrice)

        const platformFee = priceForCalculation * commissionRate;
        const payout = priceForCalculation - platformFee;

        // Exibição formatada no campo de visualização
        document.getElementById('price_display').value = displayPrice.toFixed(2).replace('.', ',');

        // Armazena o preço original (sempre)
        document.getElementById('purchasePrice').value = originalPrice.toFixed(2);
        document.getElementById('discount').value = discountedPrice.toFixed(2);


        // Armazena os valores baseados no desconto (se houver)
        document.getElementById('payout_amount').value = payout.toFixed(2);
        document.getElementById('platform_fee').value = platformFee.toFixed(2);

        // Exibe o modal
        const modal = document.getElementById('purchaseModal');
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.warn('Modal não encontrado');
        }
    }

    function closePurchaseModal() {
        const modal = document.getElementById('purchaseModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>






@endsection
