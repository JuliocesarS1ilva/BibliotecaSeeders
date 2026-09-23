<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#17201d">
    <title>{{ config('app.name', 'Biblioteca') }} · Acervo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-mark"><span>BS</span></div>
            <div>
                <strong>Biblioteca</strong>
                <small>Acervo & gestão</small>
            </div>
        </div>

        <nav class="nav">
            <p class="nav-label">Navegação</p>
            <a class="nav-item active" href="#inicio"><span class="nav-icon">⌂</span>Visão geral</a>
            <a class="nav-item" href="#acervo"><span class="nav-icon">▤</span>Acervo</a>
            <a class="nav-item" href="#categorias"><span class="nav-icon">◈</span>Categorias</a>
            <a class="nav-item" href="#emprestimos"><span class="nav-icon">↗</span>Empréstimos</a>
        </nav>

        <div class="sidebar-bottom">
            <div class="quote-card">
                <span class="quote-mark">“</span>
                <p>Uma biblioteca é uma casa cheia de histórias esperando para ser aberta.</p>
            </div>
            <div class="profile">
                <div class="avatar">BS</div>
                <div><strong>Bibliotecário</strong><small>Administrador</small></div>
                <span class="dots">•••</span>
            </div>
        </div>
    </aside>

    <main class="main">
        <header class="topbar" id="inicio">
            <div>
                <span class="eyebrow">QUARTA · 23 SET 2026</span>
                <h1>Bom dia, <em>Bibliotecário.</em></h1>
                <p>Um olhar claro sobre tudo o que acontece no seu acervo.</p>
            </div>
            <div class="top-actions">
                <label class="search">
                    <span>⌕</span>
                    <input id="bookSearch" type="search" placeholder="Buscar no acervo..." aria-label="Buscar no acervo">
                    <kbd>⌘ K</kbd>
                </label>
                <button class="icon-button" aria-label="Notificações">♢<i></i></button>
            </div>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <span class="hero-kicker">COLEÇÃO EM DESTAQUE</span>
                <h2>Conhecimento que<br><strong>fica com você.</strong></h2>
                <p>Explore títulos de tecnologia, literatura, história e ciência em um espaço pensado para tornar a leitura mais simples.</p>
                <a href="#acervo" class="primary-button">Explorar acervo <span>→</span></a>
            </div>
            <div class="hero-ornament" aria-hidden="true">
                <div class="orb orb-a"></div><div class="orb orb-b"></div>
                <div class="book-stack"><span></span><span></span><span></span></div>
                <small>DESDE 2026</small>
            </div>
        </section>

        <section class="stats-grid" aria-label="Resumo do acervo">
            <article class="stat-card">
                <span class="stat-icon">▤</span><div><small>Títulos disponíveis</small><strong>{{ $stats['books'] }}</strong></div><span class="trend">+{{ $stats['books'] }}</span>
            </article>
            <article class="stat-card">
                <span class="stat-icon">◈</span><div><small>Categorias</small><strong>{{ $stats['categories'] }}</strong></div><span class="trend neutral">Acervo</span>
            </article>
            <article class="stat-card">
                <span class="stat-icon">↗</span><div><small>Em empréstimo</small><strong>{{ $stats['active_loans'] }}</strong></div><span class="trend">ativos</span>
            </article>
            <article class="stat-card">
                <span class="stat-icon">○</span><div><small>Leitores cadastrados</small><strong>{{ $stats['users'] }}</strong></div><span class="trend neutral">leitores</span>
            </article>
        </section>

        <div class="content-grid">
            <section class="panel collection-panel" id="acervo">
                <div class="panel-heading">
                    <div><span class="section-number">01</span><h3>Acervo recente</h3><p>Os títulos que compõem sua coleção.</p></div>
                    <button class="text-button" id="clearSearch">Ver todos <span>→</span></button>
                </div>

                <div class="book-list" id="bookList">
                    @foreach($books as $book)
                        <article class="book-row" data-search="{{ strtolower($book->title . ' ' . $book->author . ' ' . $book->category) }}">
                            <div class="cover cover-{{ ($loop->index % 4) + 1 }}"><span>{{ strtoupper(substr($book->category, 0, 2)) }}</span></div>
                            <div class="book-info">
                                <span>{{ $book->category }}</span>
                                <h4>{{ $book->title }}</h4>
                                <p>{{ $book->author }} · {{ $book->publication_year }}</p>
                            </div>
                            <button class="more" aria-label="Mais opções para {{ $book->title }}">•••</button>
                        </article>
                    @endforeach
                    <div id="emptyState" class="empty-state" hidden>Nenhum título encontrado.</div>
                </div>
            </section>

            <aside class="right-column">
                <section class="panel categories-panel" id="categorias">
                    <div class="panel-heading compact">
                        <div><span class="section-number">02</span><h3>Seções</h3></div>
                        <span class="count">{{ $categories->count() }}</span>
                    </div>
                    <div class="category-list">
                        @foreach($categories as $category)
                            @php
                                $count = $books->where('category', $category->name)->count();
                                $initial = strtoupper(substr($category->name, 0, 1));
                            @endphp
                            <div class="category-item">
                                <span class="category-letter">{{ $initial }}</span>
                                <div><strong>{{ $category->name }}</strong><small>{{ $count }} {{ $count === 1 ? 'título' : 'títulos' }}</small></div>
                                <span>↗</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="panel activity-panel" id="emprestimos">
                    <div class="panel-heading compact">
                        <div><span class="section-number">03</span><h3>Movimentações</h3></div>
                        <span class="live-dot">AO VIVO</span>
                    </div>
                    @if($loans->count())
                        <div class="activity-list">
                            @foreach($loans as $loan)
                                <div class="activity-item">
                                    <span class="activity-line"></span>
                                    <div><strong>{{ $loan->title }}</strong><small>{{ $loan->user_name }} · {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</small></div>
                                    <span class="status {{ $loan->return_date ? 'returned' : '' }}">{{ $loan->return_date ? 'Devolvido' : 'Ativo' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="activity-empty">Nenhuma movimentação registrada.</div>
                    @endif
                </section>
            </aside>
        </div>

        <footer>
            <span>Biblioteca · Gestão de acervo</span>
            <span>Organizar. Descobrir. Ler.</span>
        </footer>
    </main>
</div>
</body>
</html>
