<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sistem SPPD DPRD</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    /* Global fix for modal blur effect */
    .modal-open {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    
    .modal-open * {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    
    /* Ensure no blur on any element when modal is active */
    .modal.show ~ * {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    
    /* Remove blur from all elements globally */
    * {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    
    /* Navbar: kembali ke biru polos seperti sebelumnya */
    .navbar {
        background: #0d6efd !important; /* biru Bootstrap primary */
        border: none !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navbar-brand {
        color: #ffffff !important;
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    .nav-link {
        color: #e3f2fd !important;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 2px;
        position: relative;
        font-weight: 500;
    }
    
    .nav-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }
    
    /* Icon styling untuk menu non-aktif */
    .nav-link i {
        color: #e3f2fd;
    }
    
    .nav-link:hover i {
        color: #ffffff;
    }
    
    /* Menu aktif dengan background putih */
    .nav-link.active-menu {
        background-color: #ffffff !important;
        color: #667eea !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        font-weight: 600;
        position: relative;
    }
    
    .nav-link.active-menu:hover {
        background-color: #f8f9fa !important;
        color: #5a6fd8 !important;
    }
    
    /* Icon dalam menu aktif */
    .nav-link.active-menu i {
        color: #667eea !important;
    }
    
    /* Underline untuk menu aktif */
    .nav-link.active-menu::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 2px;
        background-color: #667eea;
        border-radius: 1px;
    }
    
    /* Bell icon styling */
    .nav-link i.fa-bell {
        color: #e3f2fd;
        font-size: 1.2rem;
    }
    
    .nav-link:hover i.fa-bell {
        color: #ffffff;
    }
    
    /* Dropdown styling */
    .dropdown-toggle {
        color: #ffffff !important;
    }
    
    .dropdown-toggle:hover {
        color: #ffffff !important;
    }
    
    /* Notification badge styling */
    .badge {
        font-size: 0.7rem !important;
        font-weight: 600 !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .navbar-nav {
            gap: 0.5rem !important;
        }
        
        .nav-link {
            font-size: 0.9rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        .navbar-brand {
            font-size: 1.2rem !important;
        }
        
        /* Mobile navigation improvements */
        .navbar .container-fluid {
            padding: 0 10px !important;
        }
        
        /* Stack navigation items vertically on mobile */
        .navbar-nav.flex-row {
            flex-direction: column !important;
            width: 100% !important;
            gap: 0.25rem !important;
        }
        
        .navbar-nav.flex-row .nav-item {
            width: 100% !important;
        }
        
        .navbar-nav.flex-row .nav-link {
            text-align: center !important;
            border-radius: 8px !important;
            margin: 2px 0 !important;
        }
    }
    
    /* Extra small devices (phones, 576px and down) */
    @media (max-width: 576px) {
        .navbar-nav .nav-link { 
            font-size: 0.85rem !important; 
            padding: 8px 10px !important; 
        }
        
        .navbar-brand { 
            font-size: 1rem !important; 
        }
        
        .container, .container-fluid { 
            padding: 0 8px !important; 
        }
        
        .card { 
            margin-bottom: 0.75rem !important; 
            border-radius: 8px !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        /* Mobile table improvements */
        .table-responsive {
            font-size: 0.8rem !important;
        }
        
        .table th, .table td {
            padding: 0.5rem 0.25rem !important;
            font-size: 0.75rem !important;
        }
        
        /* Mobile button improvements */
        .btn {
            font-size: 0.85rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        .btn-sm {
            font-size: 0.75rem !important;
            padding: 0.25rem 0.5rem !important;
        }
        
        /* Mobile form improvements */
        .form-control, .form-select {
            font-size: 0.9rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        /* Mobile modal improvements */
        .modal-dialog {
            margin: 0.5rem !important;
        }
        
        .modal-content {
            border-radius: 12px !important;
        }
        
        .modal-header {
            padding: 1rem !important;
        }
        
        .modal-body {
            padding: 1rem !important;
        }
        
        .modal-footer {
            padding: 1rem !important;
        }
        
        /* Mobile notification badge adjustments */
        #notifBadge {
            font-size: 0.6em !important;
            min-width: 16px !important;
            height: 16px !important;
            line-height: 16px !important;
            padding: 1px 4px !important;
        }
        
        /* Mobile dropdown improvements */
        .dropdown-menu {
            min-width: 280px !important;
            max-width: 90vw !important;
            font-size: 0.9rem !important;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem !important;
        }
    }
    
    /* Very small devices (320px and down) */
    @media (max-width: 320px) {
        .navbar-brand {
            font-size: 0.9rem !important;
        }
        
        .nav-link {
            font-size: 0.8rem !important;
            padding: 6px 8px !important;
        }
        
        .container, .container-fluid {
            padding: 0 5px !important;
        }
        
        .card-body {
            padding: 0.75rem !important;
        }
        
        .table th, .table td {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.15rem !important;
        }
    }
    
    /* Separator line di bawah navbar (dinonaktifkan) */
    .navbar::after { display: none !important; }
    
    /* Pastikan navbar memiliki position relative */
    .navbar {
        position: relative;
    }
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.6); /* transparan smooth */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1040; /* modal Bootstrap 1050, loader di bawah modal */
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .page-loader.active {
            opacity: 1;
            visibility: visible;
        }
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>
    
    <nav class="navbar navbar-dark @guest p-0 m-0 border-0 @else py-0 @endguest">
        <div class="container-fluid flex-column align-items-start">
            <div class="w-100 d-flex align-items-center @guest py-3 @else py-2 @endguest">
                <span class="navbar-brand mb-0 h1 d-flex align-items-center" style="cursor:default;">
                    <i class="fas fa-file-alt me-2"></i>
                    <span class="d-none d-sm-inline">Sistem SPPD DPRD</span>
                    <span class="d-inline d-sm-none">SPPD DPRD</span>
                </span>
                
                @auth
                <!-- Mobile menu button -->
                <button class="navbar-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endauth
            </div>
            @auth
            <!-- Desktop Navigation -->
            <div class="w-100 d-flex align-items-center justify-content-between flex-wrap mb-2 d-none d-md-flex">
                <ul class="navbar-nav flex-row justify-content-start gap-2 mb-0">
                    @if(auth()->check() && auth()->user()->role === 'supervisor')
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('supervisor.dashboard') ? 'active-menu' : '' }}" href="{{ route('supervisor.dashboard') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('supervisor.pengajuan.index') ? 'active-menu' : '' }}" href="{{ route('supervisor.pengajuan.index') }}">
                            <i class="fas fa-list me-1"></i> Daftar Pengajuan
                        </a>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('admin.sppd.create') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.create') }}">
                            <i class="fas fa-plus me-1"></i> Ajukan SPPD
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('admin.sppd.riwayat') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.riwayat') }}">
                            <i class="fas fa-history me-1"></i> Riwayat Pengajuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold py-2 px-3 {{ request()->routeIs('admin.sppd.status') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.status') }}">
                            <i class="fas fa-tasks me-1"></i> Status Pengajuan
                        </a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav flex-row align-items-center mb-0 ms-3">
                    <!-- Tombol Lonceng Notifikasi -->
                    <li class="nav-item dropdown me-4 position-relative">
                        <a class="nav-link position-relative fs-5" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 15px;">
                            <i class="fas fa-bell"></i>
                            @php 
                                // Fallback jika View Composer gagal
                                if (!isset($unreadCount)) {
                                    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count();
                                }
                                if (!isset($notifications)) {
                                    $notifications = \App\Models\Notification::where('user_id', auth()->id())->orderByDesc('created_at')->limit(10)->get();
                                }
                                echo "<script>console.log('Debug - unreadCount: " . $unreadCount . "');</script>";
                            @endphp
                        </a>
                        @if($unreadCount > 0)
                            <div class="position-absolute" style="top: -5px; right: -5px; z-index: 9999;">
                                <span class="badge rounded-circle bg-danger" id="notifBadge" style="font-size: 0.7em; min-width: 20px; height: 20px; line-height: 20px; padding: 2px 6px; display: flex; align-items: center; justify-content: center; font-weight: bold; background-color: #dc3545 !important; color: white !important; border: 2px solid white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;">{{ $unreadCount }}</span>
                            </div>
                            <script>console.log('Badge rendered with count: {{ $unreadCount }}');</script>
                        @else
                            <script>console.log('No badge rendered - unreadCount: {{ $unreadCount }}');</script>
                        @endif
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdown" style="min-width:320px;max-width:400px;">
                            <li class="dropdown-header fw-bold d-flex justify-content-between align-items-center">
                                Notifikasi
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger" id="notifHeaderBadge">{{ $unreadCount }}</span>
                                @endif
                                @if(isset($notifications) && count($notifications) > 0)
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="clearNotifications" style="font-size: 0.75em; padding: 2px 8px;">
                                        <i class="fas fa-trash me-1"></i>Clear
                                    </button>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(isset($notifications) && count($notifications) > 0)
                                @foreach($notifications as $notif)
                                    <li class="px-3 py-2 border-bottom small {{ !$notif->read_at ? 'bg-light' : '' }} notif-item" data-id="{{ $notif->id }}">
                                        <div class="fw-semibold mb-1" style="font-size:1em;">{!! highlightNamaPegawai($notif->message) !!}</div>
                                        <div class="text-muted" style="font-size:0.85em;">{{ $notif->created_at->diffForHumans() }}</div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center text-muted py-2" id="notifEmpty">Belum ada notifikasi</li>
                            @endif
                        </ul>
                    </li>
                    <!-- Akun -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fs-5 fw-bold text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                            <span class="d-inline d-sm-none">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" id="logoutBtn">
                                        <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            
            <!-- Mobile Navigation -->
            <div class="collapse w-100 d-md-none" id="navbarMobile">
                <ul class="navbar-nav flex-column gap-1 mb-2">
                    @if(auth()->check() && auth()->user()->role === 'supervisor')
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('supervisor.dashboard') ? 'active-menu' : '' }}" href="{{ route('supervisor.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('supervisor.pengajuan.index') ? 'active-menu' : '' }}" href="{{ route('supervisor.pengajuan.index') }}">
                            <i class="fas fa-list me-2"></i> Daftar Pengajuan
                        </a>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('admin.sppd.create') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.create') }}">
                            <i class="fas fa-plus me-2"></i> Ajukan SPPD
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('admin.sppd.riwayat') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.riwayat') }}">
                            <i class="fas fa-history me-2"></i> Riwayat Pengajuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 px-3 {{ request()->routeIs('admin.sppd.status') ? 'active-menu' : '' }}" href="{{ route('admin.sppd.status') }}">
                            <i class="fas fa-tasks me-2"></i> Status Pengajuan
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <!-- Mobile Notification -->
                    <div class="dropdown">
                        <a class="nav-link text-white" href="#" id="notifDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell me-2"></i> Notifikasi
                            @if($unreadCount > 0)
                                <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdownMobile" style="min-width:280px;max-width:90vw;">
                            <li class="dropdown-header fw-bold d-flex justify-content-between align-items-center">
                                Notifikasi
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger">{{ $unreadCount }}</span>
                                @endif
                                @if(isset($notifications) && count($notifications) > 0)
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="clearNotificationsMobile" style="font-size: 0.75em; padding: 2px 8px;">
                                        <i class="fas fa-trash me-1"></i>Clear
                                    </button>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(isset($notifications) && count($notifications) > 0)
                                @foreach($notifications as $notif)
                                    <li class="px-3 py-2 border-bottom small {{ !$notif->read_at ? 'bg-light' : '' }} notif-item" data-id="{{ $notif->id }}">
                                        <div class="fw-semibold mb-1" style="font-size:1em;">{!! highlightNamaPegawai($notif->message) !!}</div>
                                        <div class="text-muted" style="font-size:0.85em;">{{ $notif->created_at->diffForHumans() }}</div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center text-muted py-2" id="notifEmptyMobile">Belum ada notifikasi</li>
                            @endif
                        </ul>
                    </div>
                    <!-- Mobile User -->
                    <div class="dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" id="logoutBtnMobile">
                                        <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <main class="@guest p-0 m-0 border-0 bg-transparent @else py-4 @endguest">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
    <script>
    $(document).ready(function() {
        $('#notifDropdown').on('click', function() {
            var badge = $('#notifBadge');
            if (badge.text() !== '0' && badge.is(':visible')) {
                $.ajax({
                    url: "{{ route('notifications.mark-read') }}",
                    type: 'POST',
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    success: function(res) {
                        var unread = (res && typeof res.unread !== 'undefined') ? res.unread : 0;
                        if (unread <= 0) {
                            badge.text('0').hide();
                            $('#notifHeaderBadge').text('0').hide();
                            $('.notif-item').removeClass('bg-light');
                        } else {
                            badge.text(unread).show();
                            $('#notifHeaderBadge').text(unread).show();
                        }
                    }
                });
            }
        });

        // Mobile notification handler
        $('#notifDropdownMobile').on('click', function() {
            var badge = $('#notifDropdownMobile .badge');
            if (badge.text() !== '0' && badge.is(':visible')) {
                $.ajax({
                    url: "{{ route('notifications.mark-read') }}",
                    type: 'POST',
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    success: function(res) {
                        var unread = (res && typeof res.unread !== 'undefined') ? res.unread : 0;
                        if (unread <= 0) {
                            badge.text('0').hide();
                            $('.notif-item').removeClass('bg-light');
                        } else {
                            badge.text(unread).show();
                        }
                    }
                });
            }
        });

        // Handle Logout
        $('#logoutForm, #logoutFormMobile').on('submit', function(e) {
            // Tampilkan loading jika diperlukan
            $('#pageLoader').addClass('active');
        });

        // Handle Clear Notifications (Desktop)
        $('#clearNotifications').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $.ajax({
                url: "{{ route('notifications.clear') }}",
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                success: function(res) {
                    $('#notifBadge').text('0').hide();
                    $('#notifHeaderBadge').text('0').hide();
                    $('.notif-item').remove();
                    
                    // Update dropdown content
                    var dropdownMenu = $('.dropdown-menu');
                    dropdownMenu.find('li:not(.dropdown-header):not(:has(hr))').remove();
                    dropdownMenu.append('<li class="text-center text-muted py-2" id="notifEmpty">Belum ada notifikasi</li>');
                    $('#clearNotifications').hide();
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus notifikasi.');
                }
            });
        });

        // Handle Clear Notifications (Mobile)
        $('#clearNotificationsMobile').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $.ajax({
                url: "{{ route('notifications.clear') }}",
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                success: function(res) {
                    $('#notifDropdownMobile .badge').text('0').hide();
                    $('.notif-item').remove();
                    
                    // Update mobile dropdown content
                    var dropdownMenu = $('#notifDropdownMobile').next('.dropdown-menu');
                    dropdownMenu.find('li:not(.dropdown-header):not(:has(hr))').remove();
                    dropdownMenu.append('<li class="text-center text-muted py-2" id="notifEmptyMobile">Belum ada notifikasi</li>');
                    $('#clearNotificationsMobile').hide();
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus notifikasi.');
                }
            });
        });

        // Auto-hide mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.navbar').length) {
                $('#navbarMobile').collapse('hide');
            }
        });

        // Close mobile menu when clicking on a link
        $('#navbarMobile .nav-link').on('click', function() {
            $('#navbarMobile').collapse('hide');
        });
    });
    </script>
    @php
    function highlightNamaPegawai($message) {
        // Tebalkan nama pegawai (setelah kata 'atas nama ' dan sebelum ' telah')
        return preg_replace('/atas nama ([^ ]+)(.*?) telah/', 'atas nama <b>$1</b>$2 telah', $message);
    }
    @endphp
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #f6f8fb;
        }
        
        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.6); /* transparan smooth */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1040; /* modal Bootstrap 1050, loader di bawah modal */
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        /* Success Modal Override */
        .success-notification {
            z-index: 99999 !important;
        }
        

        
        /* Notification Badge Fix */
        #notifBadge {
            transition: none !important;
            animation: none !important;
            transform: translate(-10%, -40%) !important;
            overflow: visible !important;
            z-index: 1000 !important;
            box-sizing: border-box !important;
            margin-left: 12px !important;
            margin-top: -5px !important;
            background-color: #dc3545 !important;
            color: white !important;
            border: 2px solid white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;
        }
        
        /* Pastikan badge selalu terlihat */
        .position-absolute.badge.bg-danger {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Page Transition Animation */
        .page-content {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Smooth Navigation Links */
        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.15);
        }
        
        /* Active Menu Animation */
        /* Nonaktifkan underline/border/animasi lama pada menu aktif */
        .active-menu {
            text-decoration: none !important;
            border: none !important;
            animation: none !important;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08); }
            50% { box-shadow: 0 2px 12px rgba(25, 118, 210, 0.2); }
            100% { box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08); }
        }
        
        /* Button Animations */
        .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        /* Card Animations */
        .card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        /* Table Row Animations */
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: linear-gradient(90deg, #e3f2fd, #f3e5f5);
            transform: scale(1.01);
        }
        
        /* Form Input Animations */
        .form-control, .form-select {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .form-control:focus, .form-select:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.15);
            border-color: #1976d2;
        }
        
        /* Dropdown Animations */
        .dropdown-menu {
            animation: slideDown 0.3s ease-out;
            transform-origin: top;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: scaleY(0);
            }
            to {
                opacity: 1;
                transform: scaleY(1);
            }
        }
        
        /* Dashboard Card Animations */
        .dashboard-card {
            animation: slideInUp 0.6s ease-out;
        }
        
        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Chart Animations */
        canvas {
            animation: fadeIn 1s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Success/Error Message Animations */
        .alert {
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Loading States */
        .loading {
            position: relative;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        /* Responsive Animations */
        @media (max-width: 768px) {
            .nav-link:hover {
                transform: none;
            }
            
            .card:hover {
                transform: none;
            }
        }
        
        .navbar-nav .nav-link {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .dropdown-menu {
            background: #fff !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border-radius: 12px;
            min-width: 180px;
            padding: 0.5rem 0;
            margin-top: 8px !important;
            position: absolute !important;
            z-index: 1050 !important;
            right: 0;
            left: auto;
        }
        .dropdown-menu .dropdown-item {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .dropdown-menu .dropdown-item:hover {
            background: #f1f3f6;
            color: #1976d2;
        }
        .navbar-nav .show > .dropdown-menu {
            display: block;
        }
        /* Card dashboard modern */
        .card.modern {
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card.modern:hover {
            transform: scale(1.04);
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18);
        }
        /* Avatar user */
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
        }
        /* Tabel modern */
        .table-modern {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.08);
        }
        .table-modern thead {
            background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%);
            color: #fff;
        }
        .table-modern tbody tr:nth-child(even) {
            background: #f1f3f6;
        }
        .table-modern tbody tr:hover {
            background: #e3f0fc;
        }
        .table-modern th, .table-modern td {
            vertical-align: middle !important;
        }
        @media (max-width: 576px) {
            .navbar-nav .nav-link { font-size: 1rem; padding: 8px 10px; }
            .navbar-brand { font-size: 1rem; }
            .dropdown-menu .dropdown-item { font-size: 0.95rem; padding: 8px 12px; }
            .container, .container-fluid, .row, .col-md-12, .col-md-8 { padding: 0 4px !important; }
            .main, main { padding: 10px 0 !important; }
            .card { margin-bottom: 1rem; }
        }
        /* Mobile Navigation Improvements */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 0 !important;
            }
            
            .navbar-brand {
                font-size: 1.1rem !important;
            }
            
            .navbar-toggler {
                border: none !important;
                padding: 0.25rem 0.5rem !important;
            }
            
            .navbar-toggler:focus {
                box-shadow: none !important;
            }
            
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
            
            #navbarMobile {
                background: rgba(13, 110, 253, 0.95) !important;
                border-radius: 0 0 12px 12px !important;
                margin-top: 0.5rem !important;
                padding: 1rem !important;
            }
            
            #navbarMobile .nav-link {
                color: rgba(255, 255, 255, 0.9) !important;
                border-radius: 8px !important;
                margin: 0.25rem 0 !important;
                transition: all 0.2s ease !important;
            }
            
            #navbarMobile .nav-link:hover {
                background: rgba(255, 255, 255, 0.1) !important;
                color: white !important;
            }
            
            #navbarMobile .nav-link.active-menu {
                background: rgba(255, 255, 255, 0.2) !important;
                color: white !important;
                font-weight: 600 !important;
            }
            
            #navbarMobile .border-top {
                border-color: rgba(255, 255, 255, 0.2) !important;
            }
        }
        
        /* Touch-friendly improvements */
        @media (max-width: 576px) {
            .btn, .nav-link, .dropdown-item {
                min-height: 44px !important;
                display: flex !important;
                align-items: center !important;
            }
            
            .form-control, .form-select {
                min-height: 44px !important;
                font-size: 16px !important; /* Prevent zoom on iOS */
            }
            
            /* Improve table scrolling on mobile */
            .table-responsive {
                border-radius: 8px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
            }
            
            /* Better card spacing on mobile */
            .card {
                margin-bottom: 1rem !important;
                border-radius: 12px !important;
                box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
            }
            
            /* Improve modal on mobile */
            .modal-dialog {
                margin: 1rem !important;
                max-width: calc(100vw - 2rem) !important;
            }
            
            .modal-content {
                border-radius: 16px !important;
            }
        }
    </style>
    
    <script>
        // Page Loading Animation (versi lama)
        if (!window.disablePageLoader) {
            document.addEventListener('DOMContentLoaded', function() {
                const loader = document.getElementById('pageLoader');
                // Hide loader after page loads
                setTimeout(() => {
                    loader.classList.remove('active');
                }, 500);
                // Show loader on navigation
                document.addEventListener('click', function(e) {
                    // Jangan tampilkan loader jika modal sedang terbuka
                    if (document.querySelector('.modal.show') || document.querySelector('.success-notification')) return;
                    const link = e.target.closest('a');
                    if (link && !link.target && !e.ctrlKey && !e.metaKey) {
                        const href = link.getAttribute('href');
                        if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                            loader.classList.add('active');
                        }
                    }
                });
                // Show loader on form submission
                document.addEventListener('submit', function(e) {
                    // Jangan tampilkan loader jika modal sedang terbuka
                    if (document.querySelector('.modal.show') || document.querySelector('.success-notification')) return;
                    loader.classList.add('active');
                });
                // Show loader on page refresh
                window.addEventListener('beforeunload', function() {
                    // Jangan tampilkan loader jika modal sedang terbuka
                    if (document.querySelector('.modal.show') || document.querySelector('.success-notification')) return;
                    loader.classList.add('active');
                });
            });
        }
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add loading state to buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 2000);
                }
            });
        });
        
        // Add hover effects to cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
    <footer class="text-center py-3 mt-5" style="color:#888; font-size:1.05rem; background:transparent;">
        &copy; {{ date('Y') }} SPPD Kota Bogor. All rights reserved. | Developed with <i class="fas fa-heart text-danger"></i> by Tim IT
    </footer>
</body>
</html> 