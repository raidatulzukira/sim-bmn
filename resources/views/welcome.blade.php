<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM BMN - Sistem Informasi Manajemen Barang Milik Negara | Balai Diklat Industri Padang</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo-server.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== BASE & TOKENS ===== */
        :root { 
            --glass-bg: rgba(255, 255, 255, 0.75); 
            --glass-border: rgba(255, 255, 255, 0.6); 
            --theme-light: #f8fafc;
            --theme-dark: #0f172a;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--theme-light); }
        
        /* ===== UTILITIES ===== */
        .grad-blue { background: linear-gradient(135deg, #0284c7, #2563eb, #0ea5e9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        /* ===== COMPONENTS ===== */
        .glass-card { background: var(--glass-bg); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid var(--glass-border); box-shadow: 0 8px 32px rgba(15, 23, 42, 0.05); }
        
        /* ===== NAVBAR ===== */
        .navbar-glass { background: transparent; border-bottom: 1px solid transparent; }
        .navbar-scrolled { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(15, 23, 42, 0.05); box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08); }
        
        /* ===== BUTTONS ===== */
        .btn-glow { position: relative; background: linear-gradient(135deg, #0284c7, #0ea5e9); transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.2); }
        .btn-glow::before { content: ''; position: absolute; inset: -2px; background: linear-gradient(135deg, #38bdf8, #7dd3fc); filter: blur(12px); opacity: 0; transition: opacity 0.3s ease; z-index: -1; border-radius: inherit; }
        .btn-glow:hover { transform: translateY(-2px); border-color: rgba(255,255,255,0.4); }
        .btn-glow:hover::before { opacity: 0.8; }
        
        /* ===== ANIMATIONS ===== */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left { opacity: 0; transform: translateX(-40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right { opacity: 0; transform: translateX(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible, .reveal-left.visible, .reveal-right.visible { opacity: 1; transform: translate(0); }
        
        /* Delay Classes */
        .d-100 { transition-delay: 100ms; } .d-200 { transition-delay: 200ms; } .d-300 { transition-delay: 300ms; } .d-400 { transition-delay: 400ms; }
        
        /* ===== PARTICLES ===== */
        @keyframes float { 0% { transform: translateY(0) scale(1); opacity: 0; } 50% { opacity: 0.6; } 100% { transform: translateY(-100px) scale(1.5); opacity: 0; } }
        .particle { position: absolute; border-radius: 50%; pointer-events: none; animation: float linear infinite; }
        
        /* ===== HERO MESH ===== */
        @keyframes blob-bounce { 0%, 100% { transform: translate(0, 0) scale(1); } 25% { transform: translate(20px, -30px) scale(1.1); } 50% { transform: translate(-20px, 20px) scale(0.9); } 75% { transform: translate(30px, 30px) scale(1.05); } }
        .mesh-blob { animation: blob-bounce 15s infinite cubic-bezier(0.4, 0, 0.2, 1); }
        .mesh-blob-2 { animation: blob-bounce 18s infinite cubic-bezier(0.4, 0, 0.2, 1) reverse; animation-delay: -5s; }
        .mesh-blob-3 { animation: blob-bounce 20s infinite cubic-bezier(0.4, 0, 0.2, 1); animation-delay: -10s; }
        
        /* ===== CARDS ===== */
        .feature-card { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08); }
        .feature-card:hover .card-icon { transform: scale(1.1) rotate(5deg); }
        .card-icon { transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
        
        /* ===== STAT GLOW ===== */
        @keyframes count-glow { 0%,100% { text-shadow: 0 0 10px rgba(14, 165, 233, 0.2); } 50% { text-shadow: 0 0 25px rgba(14, 165, 233, 0.5); } }
        .stat-number { animation: count-glow 3s ease-in-out infinite; }
        
        /* ===== SHIMMER ===== */
        @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
        .shimmer-line { position: relative; overflow: hidden; }
        .shimmer-line::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); animation: shimmer 2.5s infinite; }
        
        /* ===== DOT GRID ===== */
        .dot-grid { background-image: radial-gradient(circle, rgba(15,23,42,0.04) 1px, transparent 1px); background-size: 28px 28px; }
        
        /* ===== PING RING ===== */
        @keyframes ping-ring { 0% { transform: scale(1); opacity: 0.8; } 100% { transform: scale(2.2); opacity: 0; } }
        .ping-ring { animation: ping-ring 2s ease-out infinite; }
        
        /* ===== FLOAT CARD ===== */
        @keyframes float-card { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .float-card { animation: float-card 5s ease-in-out infinite; }
        .float-card-2 { animation: float-card 6s ease-in-out 1.5s infinite; }
        
        /* ===== PROGRESS BAR ===== */
        @keyframes progress-fill { from { width: 0%; } to { width: var(--target-width); } }
        .progress-animated { animation: progress-fill 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-play-state: paused; }
        .progress-animated.running { animation-play-state: running; }
        
        /* ===== BADGE PULSE ===== */
        @keyframes pulse-badge { 0%,100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.3); } 50% { box-shadow: 0 0 0 8px rgba(14, 165, 233, 0); } }
        .badge-pulse { animation: pulse-badge 2s infinite; }
        
        input:focus { outline: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">

    <!-- ======================== NAVBAR ======================== -->
    @include('landing.navbar')

    <!-- ======================== HERO SECTION ======================== -->
    @include('landing.hero')

    <!-- ======================== STATISTIK SECTION ======================== -->
    @include('landing.statistik')

    <!-- ======================== FITUR SECTION ======================== -->
    @include('landing.fitur')

    <!-- ======================== ALUR SISTEM ======================== -->
    @include('landing.alur')

    <!-- ======================== CTA SECTION ======================== -->
    @include('landing.cta')

    <!-- ======================== FOOTER ======================== -->
    @include('landing.footer')

    <!-- ======================== LOGIN MODAL ======================== -->
    @include('landing.login-modal')

    <!-- ======================== SCRIPTS ======================== -->
    @include('landing.scripts')

</body>
</html>
