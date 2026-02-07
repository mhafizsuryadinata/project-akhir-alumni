<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Monsterlite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Monster admin lite design, Monster admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Monster Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Alumni Dar el-ilmi</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('./assets/plugins/chartist/dist/chartist.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('css/style.min.css')}}" rel="stylesheet">
    
    <!-- Style -->
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
            --shadow: 0 4px 20px rgba(26, 115, 232, 0.08);
            --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.12);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Global Typography Enhancements */
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            color: #444;
            background-color: #f4f7fe;
        }

        /* Card Standard */
        .card {
            border: none !important;
            border-radius: var(--border-radius) !important;
            box-shadow: var(--shadow) !important;
            transition: var(--transition);
        }
        .card:hover {
            box-shadow: var(--shadow-hover) !important;
        }
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            padding: 1.25rem 1.5rem !important;
        }
        .card-title {
            color: #333 !important;
            font-weight: 700 !important;
            font-size: 1.1rem !important;
        }

        /* Button Standard */
        .btn {
            border-radius: 10px !important;
            padding: 0.6rem 1.25rem !important;
            font-weight: 600 !important;
            transition: var(--transition) !important;
        }
        .btn-primary {
            background-color: var(--primary-blue) !important;
            border-color: var(--primary-blue) !important;
        }
        .btn-primary:hover {
            background-color: var(--dark-blue) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }

        /* Form Standard */
        .form-control {
            border-radius: 10px !important;
            border: 2px solid var(--medium-gray) !important;
            padding: 0.7rem 1rem !important;
            transition: var(--transition) !important;
        }
        .form-control:focus {
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.1) !important;
        }

        /* Fixed Layout Overrides */
        #main-wrapper[data-layout=vertical][data-header-position=fixed] .topbar {
            position: fixed;
            width: 100%;
        }
        #main-wrapper[data-layout=vertical][data-sidebar-position=fixed] .left-sidebar {
            position: fixed;
            height: 100%;
        }
        .page-wrapper {
            margin-top: 64px;
            background-color: #f4f7fe !important;
        }

        /* ========================================= */
        /* GLOBAL UI ENHANCEMENT CLASSES (NEW)      */
        /* ========================================= */

        /* Glassmorphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
        }

        /* Premium Hero Header for All Pages */
        .page-hero {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            border-radius: var(--border-radius);
            box-shadow: 0 15px 35px rgba(15, 12, 41, 0.2);
            position: relative;
            overflow: hidden;
        }
        .page-hero .floating-icon {
            animation: floatAnimation 6s ease-in-out infinite;
        }
        @keyframes floatAnimation {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-15px) rotate(3deg); }
        }

        /* Staggered Entry Animations - Auto-Animate on Load */
        .animate-box {
            animation: fadeInUpAnim 0.7s ease-out forwards;
        }
        @keyframes fadeInUpAnim {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Light Color Background Utilities */
        .bg-light-primary { background: rgba(26, 115, 232, 0.1) !important; }
        .bg-light-success { background: rgba(40, 167, 69, 0.1) !important; }
        .bg-light-info { background: rgba(6, 182, 212, 0.1) !important; }
        .bg-light-warning { background: rgba(255, 193, 7, 0.1) !important; }
        .bg-light-danger { background: rgba(220, 53, 69, 0.1) !important; }
        .bg-light-purple { background: rgba(124, 58, 237, 0.1) !important; }

        /* Text Color Utilities */
        .text-purple { color: #7c3aed !important; }
        .text-orange { color: #f97316 !important; }

        /* Typography Enhancements */
        .fw-800 { font-weight: 800 !important; }
        .fw-700 { font-weight: 700 !important; }
        .fw-600 { font-weight: 600 !important; }
        .ls-1 { letter-spacing: 1px; }

        /* Modern Table Styling */
        .table-modern thead th {
            background: #f8fafc;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border: none;
            padding: 1rem;
        }
        .table-modern tbody tr {
            transition: all 0.2s ease;
        }
        .table-modern tbody tr:hover {
            background: rgba(26, 115, 232, 0.03);
        }

        /* Icon Button Styling */
        .btn-icon-modern {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        .btn-icon-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Trend Badge Styling */
        .trend-badge {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
        }
        .trend-badge.up { background: rgba(40, 167, 69, 0.15); color: #28a745; }
        .trend-badge.down { background: rgba(220, 53, 69, 0.15); color: #dc3545; }

        /* Fade In Animation (Legacy Support) */
        .fade-in { animation: fadeInLegacy 0.5s ease-out; }
        @keyframes fadeInLegacy { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <!-- TAMBAHAN: Stack untuk styles dari child view -->
    @stack('styles')
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" style="background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: fixed; width: 100%; top: 0; z-index: 1050;">
            <nav class="navbar top-navbar navbar-expand-md navbar-light bg-transparent">
                <div class="navbar-header" style="background: transparent !important; border-right: 1px solid rgba(0,0,0,0.05);">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand d-flex align-items-center" href="{{url('admin')}}" style="gap: 15px; padding: 5px 20px; height: 64px;">
                        <!-- Bagian Ikon -->
                        <div class="logo-icon-container" style="flex-shrink: 0; background: #fff; padding: 5px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
                            <img src="{{url('images/logo_alumni.png')}}" alt="Logo" class="dark-logo" style="height: 50px; width: auto; display: block;" />
                        </div>
                        
                        <!-- Bagian Teks (Hierarki Baru) -->
                        <div class="brand-text d-flex flex-column" style="line-height: 1.0; justify-content: center;">
                            <span style="font-weight: 800; font-size: 1.4rem; color: #333; text-transform: uppercase; letter-spacing: 1px; font-family: 'Poppins', sans-serif;">ADMIN</span>
                            <span style="font-weight: 600; font-size: 0.75rem; color: #4fc3f7; white-space: nowrap; font-family: 'Poppins', sans-serif; letter-spacing: 0.5px;">
                                Alumni Der El Ilmi
                            </span>
                        </div>
                    </a>
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav me-auto mt-md-0 ">
                        <li class="nav-item hidden-sm-down ps-4">
                            <div class="global-search-container position-relative" style="width: 400px;">
                                <div class="search-input-wrapper" style="background: rgba(0,0,0,0.04); border-radius: 12px; padding: 2px 15px; display: flex; align-items: center; border: 1px solid transparent; transition: all 0.3s;" id="searchWrapper">
                                    <i class="ti-search text-muted me-2"></i>
                                    <input type="text" id="global-search-input" class="form-control border-0 bg-transparent py-2" placeholder="Cari alumni, event, atau berita..." style="box-shadow: none; font-size: 0.9rem;">
                                </div>
                                
                                <!-- Hasil Pencarian Global -->
                                <div id="search-results-dropdown" class="position-absolute mt-2 shadow-lg border-0 rounded-3 w-100 bg-white" style="display: none; z-index: 1100; max-height: 450px; overflow-y: auto; border: 1px solid rgba(0,0,0,0.05) !important;">
                                    <div class="p-3 text-center text-muted" id="search-loading" style="display: none;">
                                        <div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div> Mencari...
                                    </div>
                                    <div id="search-items-list" class="list-group list-group-flush">
                                        <!-- Hasil akan muncul di sini -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav pe-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 12px; padding: 0;">
                                <div class="text-end d-none d-lg-block" style="line-height: 1.2;">
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->nama ?? Auth::user()->username }}</span>
                                    <span class="badge bg-primary-light text-primary text-uppercase" style="font-size: 0.6rem; background: rgba(26, 115, 232, 0.1); border-radius: 4px;">Administrator</span>
                                </div>
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/saya.jpeg') }}" 
                                     alt="user" class="profile-pic" style="width: 42px; height: 42px; border-radius: 12px; object-fit: cover; box-shadow: 0 3px 6px rgba(0,0,0,0.1); border: 2px solid #fff;">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="navbarDropdown" style="min-width: 220px; padding: 10px;">
                                <li class="px-3 py-2 border-bottom mb-2 d-lg-none">
                                    <h6 class="mb-0 fw-bold">{{ Auth::user()->nama ?? Auth::user()->username }}</h6>
                                    <small class="text-muted">Administrator</small>
                                </li>
                                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('admin.akun') }}"><i class="dw dw-user1 me-3 text-primary"></i> Profil Saya</a></li>
                                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('admin.akun') }}#password"><i class="dw dw-settings2 me-3 text-primary"></i> Keamanan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-2 py-2 text-danger" href="{{url('logout')}}"><i class="dw dw-logout me-3 text-danger"></i> Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}" href="{{url('admin')}}" aria-expanded="false">
                                <iconify-icon icon="solar:chart-2-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('alumni/tampil*') ? 'active' : '' }}" href="{{url('alumni/tampil')}}" aria-expanded="false">
                                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Data Alumni</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('alumni/komentar*') ? 'active' : '' }}" href="{{url('alumni/komentar')}}" aria-expanded="false">
                                <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Komentar Alumni</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/event*') ? 'active' : '' }}" href="{{ route('admin.event.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:calendar-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Pengelolaan Event</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:gallery-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Pengelolaan Galeri</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/lowongan*') ? 'active' : '' }}" href="{{ route('admin.lowongan.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:case-minimalistic-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Pengelolaan Lowongan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/info*') ? 'active' : '' }}" href="{{ route('admin.info.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:documents-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Info Pondok</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/kontak*') ? 'active' : '' }}" href="{{ route('admin.kontak.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:user-id-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Kontak Ustadz</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/faq*') ? 'active' : '' }}" href="{{ route('admin.faq.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:question-circle-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Manajemen FAQ</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/pesan*') ? 'active' : '' }}" href="{{ route('admin.pesan.index') }}" aria-expanded="false">
                                <iconify-icon icon="solar:letter-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Pesan Kontak</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/akun*') ? 'active' : '' }}" href="{{ route('admin.akun') }}" aria-expanded="false">
                                <iconify-icon icon="solar:settings-bold-duotone" class="fs-5 me-2"></iconify-icon>
                                <span class="hide-menu">Pengaturan Akun</span>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="page-title mb-0 p-0">Dashboard</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div> -->
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('isi')
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                © 2021 Monster Admin by <a href="{{url('https://www.wrappixel.com/')}}">wrappixel.com</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{url('./assets/plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{url('./assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('js/app-style-switcher.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{url('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{url('js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{url('js/custom.js')}}"></script>
    <!--This page JavaScript -->
    <!--flot chart-->
    <script src="{{url('./assets/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{url('./assets/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{url('js/pages/dashboards/dashboard1.js')}}"></script>
    
    <!-- Global Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('global-search-input');
            const searchWrapper = document.getElementById('searchWrapper');
            const resultsDropdown = document.getElementById('search-results-dropdown');
            const resultsList = document.getElementById('search-items-list');
            const loadingIndicator = document.getElementById('search-loading');
            let debounceTimer;

            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    resultsDropdown.style.display = 'none';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            searchInput.addEventListener('focus', function() {
                searchWrapper.style.background = '#fff';
                searchWrapper.style.borderColor = '#1a73e8';
                searchWrapper.style.boxShadow = '0 0 0 4px rgba(26, 115, 232, 0.1)';
                if (resultsList.children.length > 0) {
                    resultsDropdown.style.display = 'block';
                }
            });

            searchInput.addEventListener('blur', function() {
                searchWrapper.style.background = 'rgba(0,0,0,0.04)';
                searchWrapper.style.borderColor = 'transparent';
                searchWrapper.style.boxShadow = 'none';
                // Delay hiding to allow clicking results
                setTimeout(() => {
                    resultsDropdown.style.display = 'none';
                }, 200);
            });

            async function performSearch(query) {
                loadingIndicator.style.display = 'block';
                resultsList.innerHTML = '';
                resultsDropdown.style.display = 'block';

                try {
                    const response = await fetch(`{{ route('admin.search.global') }}?q=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    
                    loadingIndicator.style.display = 'none';
                    
                    if (data.results.length === 0) {
                        resultsList.innerHTML = '<div class="p-3 text-center text-muted small">Tidak ada hasil ditemukan</div>';
                    } else {
                        data.results.forEach(item => {
                            const element = document.createElement('a');
                            element.href = item.url;
                            element.className = 'list-group-item list-group-item-action d-flex align-items-center py-2 px-3 border-0';
                            element.innerHTML = `
                                <div class="icon-box me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="${item.icon} text-primary"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 text-truncate fw-bold" style="font-size: 0.9rem;">${item.title}</h6>
                                    <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">${item.type} • ${item.subtitle}</small>
                                </div>
                            `;
                            resultsList.appendChild(element);
                        });
                    }
                } catch (error) {
                    console.error('Search error:', error);
                    loadingIndicator.style.display = 'none';
                    resultsList.innerHTML = '<div class="p-3 text-center text-danger small">Terjadi kesalahan pencarian</div>';
                }
            }
        });
    </script>
    
    <!-- Iconify for modern icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- PENTING: Stack untuk scripts dari child view -->
    @stack('scripts')
</body>

</html>