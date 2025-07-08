@extends('frontend.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Projetos Prontos de Qualidade Profissional</h1>
                <p>Descubra nossa coleção exclusiva de aplicativos, plataformas web e sistemas completos. Economize tempo e
                    recursos com soluções testadas e prontas para uso.</p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Começar Agora
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <i class="fas fa-play"></i>
                        Ver Demonstração
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Por que Escolher o CodeMarket?</h2>
                <p>Oferecemos soluções completas e profissionais para acelerar seu negócio</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Código Limpo</h3>
                    <p>Todos os projetos são desenvolvidos seguindo as melhores práticas de programação, com código
                        organizado e bem documentado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Segurança Garantida</h3>
                    <p>Implementamos as mais recentes medidas de segurança para proteger seus dados e de seus usuários.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Responsivo</h3>
                    <p>Todos os projetos são otimizados para funcionar perfeitamente em qualquer dispositivo e tamanho de
                        tela.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Suporte Técnico</h3>
                    <p>Oferecemos suporte completo para instalação, configuração e personalização dos projetos adquiridos.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Deploy Rápido</h3>
                    <p>Documentação completa para colocar seu projeto no ar em minutos, com guias passo a passo.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Atualizações</h3>
                    <p>Receba atualizações regulares com novas funcionalidades e melhorias de segurança.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-projects">
        <div class="container">
            <div class="section-title">
                <h2>Projetos Mais Vendidos</h2>
                <p>Descubra os projetos que estão transformando negócios ao redor do mundo</p>
            </div>



            <div class="slideshow-container">
                @forelse ($products as $index => $product)
                    <div class="slides {{ $index === 0 ? 'active' : '' }}">
                        <div class="slide-content">
                            <div class="slide-image">
                                @php
                                    $cover = $product->files->firstWhere('type', 'cover_image');
                                    $imageUrl = $cover
                                        ? asset('storage/' . $cover->file_path)
                                        : asset('images/default.jpg');
                                @endphp
                                <img src="{{ $imageUrl }}" alt="" srcset="" width="900px">
                            </div>
                            <div class="slide-info">
                                <div class="slide-badge">
                                    {{ $index === 0 ? '🔥 Mais Vendido' : ($index === 1 ? '⭐ Melhor Avaliado' : '🚀 Lançamento') }}
                                </div>
                                <h3 class="slide-title">{{ $product->title }}</h3>
                                <p class="slide-description">
                                    {{ Str::limit($product->excerpt ?? $product->description, 180) }}
                                </p>
                                <div class="slide-features">
                                    <ul>
                                        <li>Categoria: {{ $product->category->name ?? 'N/A' }}</li>
                                        <li>Avaliação: {{ number_format($product->average_rating ?? 0, 1) }} ★</li>
                                        <li>{{ $product->is_featured ? '🚩 Produto em Destaque' : '📦 Produto Comum' }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="slide-price-action">
                                    <div>
                                        <span class="slide-price">
                                            R$
                                            {{ number_format($product->discount_price ?? $product->price, 2, ',', '.') }}
                                        </span>
                                        @if ($product->discount_price)
                                            <span class="slide-old-price">
                                                R$ {{ number_format($product->price, 2, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('frontend.show', $product->slug) }}" class="btn btn-primary">Ver
                                        Projeto</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Nenhum produto disponível no momento.</p>
                @endforelse

                <button class="nav-arrow prev" onclick="changeSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-arrow next" onclick="changeSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="slide-indicators">
                @foreach ($products as $i => $product)
                    <span class="indicator {{ $i === 0 ? 'active' : '' }}"
                        onclick="currentSlide({{ $i + 1 }})"></span>
                @endforeach
            </div>

            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">2.5K+</span>
                        <span class="stat-label">Projetos Vendidos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1.2K+</span>
                        <span class="stat-label">Clientes Satisfeitos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">150+</span>
                        <span class="stat-label">Projetos Disponíveis</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">4.9★</span>
                        <span class="stat-label">Avaliação Média</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="projects" id="projects">
        <div class="container">
            <div class="section-title">
                <h2>Projetos em Destaque</h2>
                <p>Explore nossa seleção de projetos mais populares e bem avaliados</p>
            </div>
            <div class="projects-grid">
                @forelse($productsfeature as $product)
                    <div class="project-card">
                        <div class="project-image">
                @php
                    $cover = $product->files->firstWhere('type', 'cover_image');
                    $imageUrl = $cover ? asset('storage/' . $cover->file_path) : asset('images/default.jpg');
                @endphp
                <img src="{{ $imageUrl}}" alt="" srcset="" width="450px">
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">{{ $product->title }}</h3>
                            <p class="project-description">
                                {{ Str::limit($product->excerpt ?? $product->description, 100) }}</p>
                            <div class="project-price">
                                R$ {{ number_format($product->discount_price ?? $product->price, 2, ',', '.') }}
                            </div>
                            <div class="project-tags">
                                @php
                                    $tags = old('tags', $product->tags);
                                    if (is_string($tags) && Str::startsWith($tags, '[')) {
                                        $tagsArray = json_decode($tags, true);
                                        $tags = is_array($tagsArray) ? implode(', ', $tagsArray) : $tags;
                                    } elseif (is_array($tags)) {
                                        $tags = implode(', ', $tags);
                                    }
                                @endphp
                                <span class="tag">{{ $tags }}</span>
                            </div>
                            <a href="{{ route('frontend.show', $product->slug) }}" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                @empty
                    <p>Nenhum produto em destaque encontrado.</p>
                @endforelse
            </div>
        </div>
    </section>



    <section class="cta-section">
        <div class="container">
            <h2>Pronto para Começar?</h2>
            <p>Junte-se a milhares de desenvolvedores e empresas que já aceleram seus projetos com nossa plataforma.
                Cadastre-se agora e tenha acesso a todos os recursos.</p>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Criar Conta Gratuita
            </a>
        </div>
    </section>


@endsection
