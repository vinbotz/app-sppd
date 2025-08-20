<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem SPPD DPRD - Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .login-main-wrapper {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(120deg, #2196f3 0%, #e3f0fc 100%);
            position: relative;
            overflow: hidden;
            padding: 0 10px;
        }
        
        /* Floating decorative elements */
        .bg-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 20%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-circle:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        .floating-circle:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: 15%;
            right: 10%;
            animation-delay: 1s;
        }
        
        .floating-square {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            transform: rotate(45deg);
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-square:nth-child(5) {
            width: 40px;
            height: 40px;
            top: 60%;
            left: 5%;
            animation-delay: 3s;
        }
        
        .floating-square:nth-child(6) {
            width: 60px;
            height: 60px;
            top: 15%;
            right: 5%;
            animation-delay: 5s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Subtle grid pattern */
        .grid-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 1;
        }
        
        /* Enhanced gradient overlay */
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 20%, rgba(33, 150, 243, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(33, 203, 243, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }
        
        .login-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px 0 rgba(31, 38, 135, 0.10);
            display: flex;
            flex-direction: row;
            width: 700px;
            max-width: 98vw;
            min-height: 400px;
            overflow: hidden;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-form-col {
            flex: 1 1 0;
            padding: 40px 32px 32px 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            min-width: 0;
        }
        .login-form-col h2 {
            font-weight: 700;
            color: #222;
            letter-spacing: 1px;
            margin-bottom: 1.5em;
            font-size: 2rem;
            text-align: left;
            width: 100%;
        }
        .login-form-col .form-control {
            background: #f8fafd !important;
            border: 1px solid #e3f0fc;
            font-size: 1.05rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .login-form-col .form-control:focus {
            box-shadow: 0 0 0 2px #1976d2;
            border-color: #1976d2;
            background: #fff !important;
        }
        .login-form-col .form-control::placeholder {
            color: #4a5a6a;
            opacity: 0.8;
        }
        .login-form-col .btn-login {
            width: 100%;
            font-weight: 600;
            font-size: 1.1em;
            border-radius: 8px;
            background: linear-gradient(90deg, #1976d2 0%, #21cbf3 100%);
            border: none;
            padding: 0.7em 0;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
            margin-top: 8px;
        }
        .login-form-col .btn-login:hover {
            background: linear-gradient(90deg, #1565c0 0%, #1de9b6 100%);
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 18px rgba(25, 118, 210, 0.13);
        }
        .login-form-col .alert {
            width: 100%;
        }
        .login-illustration-col {
            flex: 1 1 0;
            background: linear-gradient(120deg, #21cbf3 0%, #2196f3 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 0;
            padding: 32px 18px;
            color: #222;
        }
        .login-illustration-col img {
            width: 160px;
            max-width: 90%;
            margin-bottom: 18px;
        }
        .login-illustration-col h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.7em;
            color: #fff;
        }
        .login-illustration-col p {
            font-size: 1.02rem;
            color: #fff;
            margin-bottom: 0;
            text-align: center;
        }
        .footer-text {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #666;
            font-size: 0.9rem;
            text-align: center;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Enhanced form styling */
        .login-form-col .form-control {
            background: rgba(248, 250, 253, 0.8) !important;
            border: 1px solid rgba(227, 240, 252, 0.8);
            font-size: 1.05rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .login-form-col .form-control:focus {
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
            border-color: #1976d2;
            background: rgba(255, 255, 255, 0.95) !important;
            transform: translateY(-2px);
        }
        
        /* Enhanced button styling */
        .login-form-col .btn-login {
            background: linear-gradient(135deg, #1976d2 0%, #21cbf3 50%, #1976d2 100%);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        .login-form-col .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .login-form-col .btn-login:hover::before {
            left: 100%;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Logo/brand element */
        .brand-logo {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 24px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .brand-logo i {
            font-size: 1.3rem;
        }
        
        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: all 0.5s ease;
        }
        
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader-content {
            text-align: center;
            color: white;
        }
        
        .loader-spinner {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        .loader-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .loader-subtext {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Button loading state */
        .btn-login.loading {
            position: relative;
            pointer-events: none;
        }
        
        .btn-login.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .btn-login.loading span {
            opacity: 0;
        }
        @media (max-width: 900px) {
            .login-container { flex-direction: column; width: 98vw; min-height: unset; }
            .login-illustration-col { display: none; }
            .login-form-col { align-items: center; padding: 32px 8vw; }
            .brand-logo { top: 20px; font-size: 1rem; padding: 10px 20px; }
            .floating-circle, .floating-square { display: none; }
        }
        @media (max-width: 600px) {
            .login-form-col { padding: 18px 2vw; }
            .footer-text { font-size: 0.8rem; bottom: 10px; padding: 6px 12px; }
            .brand-logo { top: 15px; font-size: 0.9rem; padding: 8px 16px; }
            .grid-pattern { background-size: 30px 30px; }
        }
    </style>
</head>
<body>
    <!-- Page Loading Overlay -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text">Memuat Sistem SPPD...</div>
            <div class="loader-subtext">Mohon tunggu sebentar</div>
        </div>
    </div>
    
    <div class="login-main-wrapper">
        <!-- Background decorations -->
        <div class="bg-decoration">
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-square"></div>
            <div class="floating-square"></div>
        </div>
        
        <!-- Grid pattern overlay -->
        <div class="grid-pattern"></div>
        
        <!-- Enhanced gradient overlay -->
        <div class="gradient-overlay"></div>
        
        <!-- Brand Logo -->
        <div class="brand-logo">
            <i class="fas fa-file-alt"></i>
            <span>Sistem SPPD DPRD</span>
        </div>
        
        <div class="login-container">
            <div class="login-form-col">
                <h2>LOGIN</h2>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="w-100 mt-2">
                    @csrf
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email or UserName" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-login mb-2" id="loginBtn">
                        <span>LOGIN</span>
                    </button>
                </form>
            </div>
            <div class="login-illustration-col">
                <img src="/img/gambar3.svg" alt="Ilustrasi Login">
                <h3>Selamat Datang!</h3>
                <p>Silakan login untuk mengakses website SPPD. Data Anda aman dan rahasia.</p>
            </div>
        </div>
        <div class="footer-text">
            © 2025 SPPD Kota Bogor. All rights reserved. | Developed with ❤️ by Tim IT
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pageLoader = document.getElementById('pageLoader');
            const loginBtn = document.getElementById('loginBtn');
            const loginForm = document.querySelector('form');
            const logoutForm = document.getElementById('logoutForm');

            // Hide page loader after page loads
            setTimeout(() => {
                pageLoader.classList.add('hidden');
                setTimeout(() => {
                    pageLoader.style.display = 'none';
                }, 500);
            }, 1500);

            // Show loader on navigation (except logout)
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && !link.target && !e.ctrlKey && !e.metaKey) {
                    const href = link.getAttribute('href');
                    if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                        pageLoader.style.display = 'flex';
                        pageLoader.classList.remove('hidden');
                    }
                }
            });

            // Show loader on login form submit only (not logout)
            if (loginForm && loginForm.id !== 'logoutForm') {
                loginForm.addEventListener('submit', function(e) {
                    // Only show loader for login, not logout
                    if (loginForm.id === 'logoutForm') return;
                    if (loginBtn) {
                        loginBtn.classList.add('loading');
                        loginBtn.disabled = true;
                    }
                    setTimeout(() => {
                        pageLoader.style.display = 'flex';
                        pageLoader.classList.remove('hidden');
                    }, 800);
                });
            }

            // DO NOT show loader on logout form submit
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    // Do nothing, let logout proceed without loader
                });
            }

            // Show loader on page refresh
            window.addEventListener('beforeunload', function() {
                pageLoader.style.display = 'flex';
                pageLoader.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>
