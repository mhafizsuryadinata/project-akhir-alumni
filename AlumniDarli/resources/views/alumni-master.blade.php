<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alumni - Dar el-ilmi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #4285f4;
            --dark-blue: #1557b0;
            --white: #ffffff;
            --light-blue: #e3f2fd;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
            --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--white) 0%, var(--light-blue) 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }
        
        .nav-link {
            color: #666 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
            transition: var(--transition);
            position: relative;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue) !important;
            background: rgba(26, 115, 232, 0.05);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15%;
            width: 70%;
            height: 2px;
            background: var(--primary-blue);
            border-radius: 2px;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-blue);
            object-fit: cover;
        }

        .profile-pic {
            width: 40px;              /* Ukuran tetap kecil di navbar */
            height: 40px;
            border-radius: 50%;       /* Bulat */
            object-fit: cover;        /* Gambar proporsional */
            border: 2px solid #fff;   /* Opsional, biar rapi */
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            padding: 3rem 0;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.05"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
            background-size: cover;
        }
        
        .hero h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            position: relative;
        }
        
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid rgba(26, 115, 232, 0.1);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-blue);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header .card-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
            background: var(--white);
        }
        
        /* Stats Cards */
        .stats-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            background: rgba(26, 115, 232, 0.1);
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.25rem;
        }
        
        .stats-label {
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        /* Info Items */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--light-gray);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: var(--transition);
            border-left: 4px solid var(--primary-blue);
        }
        
        .info-item:hover {
            background: var(--light-blue);
        }
        
        .info-icon {
            width: 45px;
            height: 45px;
            background: var(--primary-blue);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }
        
        .info-content {
            flex: 1;
        }
        
        .info-content h6 {
            margin-bottom: 0.25rem;
        }
        
        .info-content p {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .info-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--dark-gray);
        }
        
        .info-meta .badge {
            font-size: 0.7rem;
        }
        
        /* Events */
        .event-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--light-gray);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: var(--transition);
        }
        
        .event-item:hover {
            background: var(--light-blue);
        }
        
        .event-date {
            width: 60px;
            height: 60px;
            background: var(--primary-blue);
            color: var(--white);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .event-date span {
            font-size: 1.25rem;
            line-height: 1;
        }
        
        .event-date small {
            font-size: 0.75rem;
            margin-top: 2px;
        }
        
        .event-content {
            flex: 1;
        }
        
        .event-content h6 {
            margin-bottom: 0.25rem;
        }
        
        .event-content p {
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
            color: var(--dark-gray);
        }
        
        .event-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Ustadz */
        .ustadz-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .ustadz-item:last-child {
            border-bottom: none;
        }
        
        .ustadz-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .ustadz-info {
            flex: 1;
            margin-left: 1rem;
        }
        
        .ustadz-info h6 {
            margin-bottom: 0.25rem;
        }
        
        .ustadz-info small {
            color: var(--dark-gray);
        }
        
        /* Alumni Table */
        .alumni-table {
            margin-bottom: 0;
        }
        
        .alumni-table thead th {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 1rem;
            font-weight: 600;
        }
        
        .alumni-table tbody td {
            padding: 1rem;
            border-color: var(--medium-gray);
            vertical-align: middle;
        }
        
        .alumni-table tbody tr:hover {
            background: var(--light-blue);
        }
        
        .alumni-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.75rem;
            border: 2px solid var(--primary-blue);
            object-fit: cover;
        }
        
        .batch-badge {
            background: var(--primary-blue);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Search and Filter */
        .search-filter {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }
        
        /* Charts */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        /* Modal */
        .modal-content {
            border-radius: var(--border-radius);
            border: 1px solid rgba(26, 115, 232, 0.1);
            box-shadow: var(--shadow);
        }
        
        .modal-header {
            background: var(--primary-blue);
            color: var(--white);
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 1.5rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-blue);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 115, 232, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: var(--white);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .event-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .event-actions {
                align-self: flex-end;
                margin-top: 0.5rem;
            }
            
            .ustadz-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .ustadz-actions {
                align-self: flex-end;
                margin-top: 0.5rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--light-gray);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-blue);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-blue);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{url('alumni')}}">
                <i class="fas fa-graduation-cap me-2"></i>DARLI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('alumni') ? 'active' : '' }}" href="{{url('alumni')}}"><i class="fas fa-home me-1"></i>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('akun') ? 'active' : '' }}" href="{{url('akun')}}"><i class="fas fa-user me-1"></i>Akun</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('event') ? 'active' : '' }}" href="{{url('event')}}"><i class="fas fa-calendar-alt me-1"></i>Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('galeri') ? 'active' : '' }}" href="{{url('galeri')}}"><i class="fas fa-images me-1"></i>Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('lowongan') ? 'active' : '' }}" href="{{url('lowongan')}}"><i class="fas fa-briefcase me-1"></i>Lowongan</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link {{ request()->is('kontak') ? 'active' : '' }}" href="{{url('kontak')}}"><i class="fa-solid fa-phone me-1" aria-hidden="true"></i> </i>Kontak</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-5"></i>
                            @if($notifications->count() > 0)
                                <span class="notification-badge">{{ $notifications->count() }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 300px;">
                            <li class="dropdown-header fw-bold">Notifikasi</li>
                            <li><hr class="dropdown-divider"></li>
                            @forelse($notifications as $notif)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2" href="{{ $notif['url'] }}">
                                        <div class="flex-shrink-0">
                                            <div class="bg-{{ $notif['color'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="{{ $notif['icon'] }} text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fw-semibold">{{ $notif['title'] }}</div>
                                            <div class="small text-muted">{{ $notif['description'] }}</div>
                                            <div class="very-small text-muted" style="font-size: 0.7rem;">{{ $notif['time']->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="p-3 text-center text-muted">
                                    <i class="fas fa-bell-slash d-block mb-2 fs-4"></i>
                                    <small>Belum ada notifikasi baru</small>
                                </li>
                            @endforelse
                            @if($notifications->count() > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center text-primary" href="{{ url('alumni') }}">Tutup</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="{{url('akun')}}" role="button" data-bs-toggle="dropdown">
                            @if (Auth::user()->profile)
                               <img 
                                    src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/default-avatar.png') }}" 
                                    alt="Profile"
                                    class="profile-pic me-2"
                                    id="navbarProfileImage">

                            @else
                                <div class="profile-img placeholder-avatar me-2">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ Auth::user()->nama ?? 'Alumni' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{url('akun')}}"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-container">
        @yield('alumni')
    </div>

    <!-- Similar modals for other profiles would go here -->

    <!-- Bootstrap JS -->
    
    <!-- Di bagian bawah sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const fadeInOnScroll = function() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('fade-in');
                    }
                });
            };
            
            window.addEventListener('scroll', fadeInOnScroll);
            fadeInOnScroll(); // Initial check
        });
    </script>
    
    @stack('scripts')
</body>
</html>