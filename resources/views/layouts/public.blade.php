<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Horarios de Buses') – Terminal FECOSA Alajuela</title>
    <meta name="description" content="@yield('meta_description', 'Horarios de buses de la Terminal FECOSA, Alajuela. Consulta rutas, salidas y andenes. ¡Como Alajuela se merece!')">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'Terminal FECOSA') – Alajuela">
    <meta property="og:description" content="@yield('meta_description', 'Horarios de buses Terminal FECOSA Alajuela')">
    <meta property="og:type" content="website">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts: Barlow Condensed + Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SVYFGSRTYC"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-SVYFGSRTYC');
</script>




    <style>
        :root {
            --red:     #cc1e37;
            --red-dk:  #a3152b;
            --red-lt:  #fdeaed;
            --white:   #ffffff;
            --dark:    #262626;
            --gray:    #f5f5f5;
            --gray-2:  #e8e8e8;
            --gray-3:  #999;
            --shadow:  0 4px 24px rgba(0,0,0,.10);
            --radius:  14px;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; background: var(--gray); color: var(--dark); margin: 0; }

        /* ── NAVBAR ── */
        .navbar-fecosa {
            background: var(--dark);
            border-bottom: 3px solid var(--red);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: .75rem 1.5rem;
        }
        .navbar-fecosa .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .navbar-fecosa .brand img { height: 40px; filter: brightness(0) invert(1); }
        .navbar-fecosa .brand-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: #fff;
            line-height: 1;
            letter-spacing: .5px;
        }
        .navbar-fecosa .brand-sub {
            font-size: .65rem;
            color: var(--red);
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
        }
        .navbar-fecosa .nav-links a {
            color: rgba(255,255,255,.75);
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            padding: .4rem .8rem;
            border-radius: 8px;
            transition: all .2s;
        }
        .navbar-fecosa .nav-links a:hover { color: #fff; background: rgba(255,255,255,.08); }

        /* ── SEARCH BAR ── */
        .search-wrapper {
            background: var(--dark);
            padding: .75rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .search-input-group {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        .search-input-group input {
            background: rgba(255,255,255,.08);
            border: 1.5px solid rgba(255,255,255,.15);
            color: #fff;
            border-radius: 50px;
            padding: .65rem 1.2rem .65rem 3rem;
            width: 100%;
            font-family: 'Nunito', sans-serif;
            font-size: .95rem;
            transition: all .2s;
        }
        .search-input-group input::placeholder { color: rgba(255,255,255,.4); }
        .search-input-group input:focus {
            outline: none;
            border-color: var(--red);
            background: rgba(255,255,255,.12);
        }
        .search-input-group .search-icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,.4);
            font-size: .9rem;
            pointer-events: none;
        }
        .search-results-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0; right: 0;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            z-index: 200;
            overflow: hidden;
            display: none;
        }
        .search-results-dropdown.show { display: block; }
        .search-result-item {
            padding: .75rem 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--gray-2);
            transition: background .15s;
            text-decoration: none;
            color: var(--dark);
        }
        .search-result-item:hover { background: var(--gray); }
        .search-result-item .anden-badge {
            background: var(--red);
            color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: .8rem;
            padding: 2px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }
        .search-result-item .route-name { font-weight: 700; font-size: .9rem; }
        .search-result-item .route-meta { font-size: .78rem; color: var(--gray-3); }

        /* ── CARDS RUTA ── */
        .route-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            transition: transform .2s, box-shadow .2s;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .route-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(204,30,55,.15);
            color: inherit;
        }
        .route-card .card-stripe {
            height: 4px;
            background: var(--red);
        }
        .route-card .card-body-custom {
            padding: 1rem 1.1rem .9rem;
        }
        .route-card .anden-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--red);
            line-height: 1;
        }
        .route-card .anden-label {
            font-size: .65rem;
            font-weight: 700;
            color: var(--gray-3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .route-card .route-name-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.2;
        }
        .route-card .horarios-count {
            font-size: .78rem;
            color: var(--gray-3);
        }
        .route-card .arrow-icon {
            color: var(--red);
            opacity: .5;
            transition: opacity .2s, transform .2s;
        }
        .route-card:hover .arrow-icon { opacity: 1; transform: translateX(3px); }

        /* ── SECTION TITLES ── */
        .section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: clamp(1.8rem, 4vw, 2.4rem);
            line-height: 1;
        }
        .section-title .accent { color: var(--red); }

        /* ── FEATURES SECTION ── */
        .features-section { background: var(--dark); }
        .feature-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 50px;
            padding: .6rem 1.2rem;
            color: #fff;
            transition: all .2s;
        }
        .feature-pill:hover {
            background: var(--red);
            border-color: var(--red);
            transform: translateY(-2px);
        }
        .feature-pill i { font-size: 1.1rem; color: var(--red); transition: color .2s; }
        .feature-pill:hover i { color: #fff; }
        .feature-pill span { font-weight: 600; font-size: .9rem; }

        /* ── HERO ── */
        .hero-section {
            background: linear-gradient(135deg, var(--dark) 0%, #1a1a1a 60%, #2a0a10 100%);
            padding: 3.5rem 1.5rem 6.5rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(204,30,55,.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-tagline {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: clamp(2rem, 6vw, 3.5rem);
            color: #fff;
            line-height: 1.05;
        }
        .hero-tagline .red { color: var(--red); }
        .hero-sub { color: rgba(255,255,255,.6); font-size: .95rem; }

        /* ── FOOTER ── */
        footer {
            background: var(--dark);
            border-top: 3px solid var(--red);
            color: rgba(255,255,255,.5);
        }
        footer .footer-brand {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff;
        }

        /* ── MISC ── */
        .btn-red {
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            padding: .5rem 1.2rem;
            transition: background .2s, transform .15s;
        }
        .btn-red:hover { background: var(--red-dk); color: #fff; transform: translateY(-1px); }

        .tag-label {
            display: inline-block;
            background: var(--red-lt);
            color: var(--red);
            font-size: .72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 576px) {
            .route-card .anden-num { font-size: 1.3rem; }
            .route-card .route-name-text { font-size: .95rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-fecosa d-flex justify-content-between align-items-center">
    <a href="{{ route('home') }}" class="brand">
        {{-- Logo inline SVG (blanco) --}}
        <svg width="38" height="28" viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 110 Q100 10 190 110" stroke="white" stroke-width="8" fill="none" stroke-linecap="round"/>
            <path d="M30 110 Q100 30 170 110" stroke="white" stroke-width="5" fill="none" opacity=".4" stroke-linecap="round"/>
            <line x1="10" y1="110" x2="190" y2="110" stroke="white" stroke-width="5"/>
            <line x1="10" y1="110" x2="10" y2="120" stroke="white" stroke-width="5"/>
            <line x1="190" y1="110" x2="190" y2="120" stroke="white" stroke-width="5"/>
        </svg>
        <div>
            <span class="brand-text">TERMINAL FECOSA</span>
            <span class="brand-sub">¡Como Alajuela se merece!</span>
        </div>
    </a>
    <div class="nav-links d-none d-md-flex align-items-center gap-1">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house me-1"></i>Inicio</a>
        <a href="{{ route('home') }}#features"><i class="fa-solid fa-star me-1"></i>Terminal</a>
    </div>
</nav>

@yield('content')


@include('components.colabora-modal')
<!-- FOOTER -->
<footer class="py-4 mt-5">
    <div class="container text-center">
        <div class="footer-brand mb-1">TERMINAL FECOSA</div>
        <p class="mb-1" style="font-size:.82rem;">¡Como Alajuela se merece! · Cantón de Alajuela, Costa Rica</p>
        <p class="mb-0" style="font-size:.75rem; color:rgba(255,255,255,.3);">
            © {{ date('Y') }} Terminal FECOSA · Los horarios pueden cambiar sin previo aviso.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
