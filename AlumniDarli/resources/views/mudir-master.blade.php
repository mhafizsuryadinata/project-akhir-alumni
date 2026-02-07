<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pimpinan Alumni Dar el-ilmi</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-mudir/images/logos/favicon.png') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('css/style.min.css')}}" rel="stylesheet">
    
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
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            color: #444;
            background-color: #f4f7fe;
        }

        .card {
            border: none !important;
            border-radius: var(--border-radius) !important;
            box-shadow: var(--shadow) !important;
            transition: var(--transition);
        }
        .card:hover {
            box-shadow: var(--shadow-hover) !important;
        }

        /* Topbar & Header */
        .topbar {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1050;
        }

        .navbar-header {
            background: transparent !important;
            width: 250px;
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-right: 1px solid rgba(0,0,0,0.05);
        }

        .brand-text span {
            color: #333 !important;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .search-input-wrapper {
            background: rgba(0,0,0,0.04);
            border-radius: 12px;
            padding: 2px 15px;
            display: flex;
            align-items: center;
            border: 1px solid transparent;
            transition: var(--transition);
            width: 400px;
        }
        .search-input-wrapper:focus-within {
            background: #fff;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.1);
        }

        /* Sidebar */
        .left-sidebar {
            background: #fff !important;
            border-right: 1px solid rgba(0,0,0,0.05);
            position: fixed;
            height: 100%;
            top: 64px;
            width: 250px;
            z-index: 1040;
        }

        .scroll-sidebar {
            padding-top: 0 !important;
        }

        .sidebar-nav {
            padding-top: 0 !important;
        }

        #sidebarnav {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        #sidebarnav .nav-small-cap {
            color: #000 !important;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 5px 25px 5px !important;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            margin-top: 0 !important;
        }

        #sidebarnav .nav-small-cap::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0,0,0,0.05);
            margin-left: 10px;
        }

        #sidebarnav .sidebar-item .sidebar-link {
            border-radius: 12px;
            margin: 4px 15px;
            padding: 12px 18px;
            font-weight: 500;
            color: #666;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #sidebarnav .sidebar-item .sidebar-link:hover {
            background: rgba(26, 115, 232, 0.05);
            color: var(--primary-blue);
        }

        #sidebarnav .sidebar-item .sidebar-link.active {
            background: var(--primary-blue);
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }

        #sidebarnav .sidebar-item .sidebar-link.active i,
        #sidebarnav .sidebar-item .sidebar-link.active iconify-icon {
            color: #fff !important;
        }

        .page-wrapper {
            margin-left: 250px;
            margin-top: 64px;
            background-color: #f4f7fe !important;
            min-height: calc(100vh - 64px);
        }

        .badge-soft-primary {
            background: rgba(26, 115, 232, 0.1);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .navbar-header { width: 100%; }
            .page-wrapper { margin-left: 0; }
            .left-sidebar { left: -250px; }
            .main-wrapper[data-sidebartype="full"] .left-sidebar { left: 0; }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light bg-transparent">
                <div class="navbar-header">
                    <a class="navbar-brand d-flex align-items-center" href="{{url('mudir')}}" style="gap: 15px;">
                        <div class="logo-icon-container" style="flex-shrink: 0; background: #fff; padding: 5px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
                            <img src="{{url('images/logo_alumni.png')}}" alt="Logo" style="height: 40px; width: auto;" />
                        </div>
                        <div class="brand-text d-flex flex-column" style="line-height: 1.0;">
                            <span style="font-weight: 800; font-size: 1.3rem; color: #333; text-transform: uppercase;">PIMPINAN</span>
                            <small style="font-weight: 600; font-size: 0.7rem; color: var(--primary-blue);">Dar el-ilmi</small>
                        </div>
                    </a>
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none ms-auto" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto ps-4">
                        <li class="nav-item">
                            <div class="search-input-wrapper">
                                <iconify-icon icon="solar:magnifer-linear" class="text-muted me-2"></iconify-icon>
                                <input type="text" id="globalSearchInput" class="form-control border-0 bg-transparent py-2" placeholder="Cari data..." style="box-shadow: none; font-size: 0.9rem;">
                            </div>
                        </li>
                    </ul>

                    <ul class="navbar-nav pe-4 align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 12px; padding: 0;">
                                <div class="text-end d-none d-lg-block" style="line-height: 1.2;">
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->nama }}</span>
                                    <span class="badge-soft-primary" style="font-size: 0.6rem;">PIMPINAN PONDOK</span>
                                </div>
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets-mudir/images/profile/user-1.jpg') }}" 
                                     alt="user" style="width: 42px; height: 42px; border-radius: 12px; object-fit: cover; box-shadow: 0 3px 6px rgba(0,0,0,0.1); border: 2px solid #fff;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="navbarDropdown" style="min-width: 220px; padding: 10px;">
                                <li class="px-3 py-2 border-bottom mb-2 d-lg-none">
                                    <h6 class="mb-0 fw-bold">{{ Auth::user()->nama }}</h6>
                                    <span class="badge-soft-primary" style="font-size: 0.6rem;">PIMPINAN PONDOK</span>
                                </li>
                                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('mudir.akun') }}"><iconify-icon icon="solar:user-bold-duotone" class="me-2 text-primary align-middle"></iconify-icon> Profil Saya</a></li>
                                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('mudir.akun') }}#password"><iconify-icon icon="solar:settings-bold-duotone" class="me-2 text-primary align-middle"></iconify-icon> Pengaturan Keamanan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-2 py-2 text-danger" href="{{url('logout')}}"><iconify-icon icon="solar:logout-linear" class="me-2 align-middle"></iconify-icon> Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">NAVIGASI MODUL UTAMA</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir') ? 'active' : '' }}" href="{{url('mudir')}}">
                                <iconify-icon icon="solar:widget-3-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/alumni*') ? 'active' : '' }}" href="{{ route('mudir.alumni.index') }}">
                                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Kelola Alumni</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/komentar*') ? 'active' : '' }}" href="{{ route('mudir.komentar.index') }}">
                                <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Kelola Komentar </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/event*') ? 'active' : '' }}" href="{{ route('mudir.event.index') }}">
                                <iconify-icon icon="solar:calendar-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Kelola Event</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/galeri*') ? 'active' : '' }}" href="{{ route('mudir.galeri.index') }}">
                                <iconify-icon icon="solar:gallery-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Kelola Galeri</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/lowongan*') ? 'active' : '' }}" href="{{ route('mudir.lowongan.index') }}">
                                <iconify-icon icon="solar:case-minimalistic-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Kelola Lowongan</span>
                            </a>
                        </li>
                        
                        <li class="nav-small-cap">
                            <span class="hide-menu">MANAJEMEN AKUN & PROFIL</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('mudir/akun*') ? 'active' : '' }}" href="{{ route('mudir.akun') }}">
                                <iconify-icon icon="solar:user-circle-bold-duotone" class="fs-5"></iconify-icon>
                                <span class="hide-menu">Profil Saya</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets-mudir/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-mudir/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-mudir/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const globalSearch = document.getElementById('globalSearchInput');
            
            if (globalSearch) {
                globalSearch.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    // 1. Filter Tables
                    const tables = document.querySelectorAll('table');
                    tables.forEach(table => {
                        const rows = table.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            // Skip rows that are explicitly marked as no-search or empty message rows
                            if (!row.classList.contains('no-search') && row.querySelector('td') && row.querySelector('td').getAttribute('colspan') === null) {
                                row.style.display = text.includes(searchTerm) ? '' : 'none';
                            }
                        });
                    });

                    // 2. Filter Cards (Gallery Albums)
                    const albums = document.querySelectorAll('.album-card');
                    albums.forEach(card => {
                        const wrapper = card.closest('.col-md-4') || card.closest('.col-xl-4') || card; // Adjust based on grid
                        // For gallery grid (div.album-card is direct child of grid in some layouts, or wrapped)
                        // In galeri/index.blade.php .album-grid > .album-card
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(searchTerm) ? '' : 'none';
                    });

                    // 3. Filter Job Cards (Lowongan)
                    const jobItems = document.querySelectorAll('.mudir-lowongan-item');
                    if (jobItems.length > 0) {
                        jobItems.forEach(item => {
                            const title = item.getAttribute('data-title') || '';
                            const company = item.getAttribute('data-company') || '';
                            const status = item.getAttribute('data-active') || '';
                            
                            // Check existing filter status if element exists
                            const statusFilter = document.getElementById('mudirStatusFilter');
                            const hideClosed = document.getElementById('mudirHideClosedToggle');
                            
                            const statusVal = statusFilter ? statusFilter.value : '';
                            const hideClosedVal = hideClosed ? hideClosed.checked : false;

                            const matchSearch = title.includes(searchTerm) || company.includes(searchTerm);
                            const matchStatus = statusVal === "" || status === statusVal;
                            const matchHideClosed = !hideClosedVal || status === 'active';

                            if (matchSearch && matchStatus && matchHideClosed) {
                                item.style.display = "";
                            } else {
                                item.style.display = "none";
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>