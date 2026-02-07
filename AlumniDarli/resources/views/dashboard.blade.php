<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Dar el-ilmi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --accent: #f39c12;
            --light: #f8f9fa;
            --dark: #343a40;
            --primary: #43e3eeff;
            --secondary: #3a0ca3;
            --accent: #248977ff;
            --success: #4cc9f0;
            --warning: #f9c74f;
            --light: #f8f9fa;
            --dark: #212529;
            --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
            --gradient-accent: linear-gradient(135deg, var(--accent), #5bdaf0ff);
            --gradient-success: linear-gradient(135deg, var(--success), #48ecefff);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        
        .hero-section {
            background: 
                linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.3)), 
                url('{{ asset('images/alumni3.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 0;
            border-radius: 0 0 30px 30px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 40px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent);
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1a73e8, var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .testimonial-card {
            background: linear-gradient(135deg, #ffffff, #f5f7fa);
            border-left: 4px solid var(--accent);
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            color: white;
            padding: 60px 0 30px;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }


        /* Kurva pada section */
        .curve-top {
            position: relative;
        }
        
        .curve-top::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 50px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        .curve-bottom {
            position: relative;
        }
        
        .curve-bottom::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 50px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
            transform: rotate(180deg);
        }
        
        .section-title {
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }
        
        .text-center .section-title:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* App Stats */
        .app-stat-box {
            padding: 30px 25px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .app-stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient-primary);
        }
        
        .app-stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .app-stat-box i {
            font-size: 48px;
            margin-bottom: 20px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Feature Cards */
        .app-feature-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
            background: white;
        }
        
        .app-feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .app-icon {
            width: 90px;
            height: 90px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 40px;
            color: white;
        }
        
        .feature-1 .app-icon { background: var(--gradient-primary); }
        .feature-2 .app-icon { background: var(--gradient-accent); }
        .feature-3 .app-icon { background: var(--gradient-success); }
        .feature-4 .app-icon { background: linear-gradient(135deg, #7209b7, #560bad); }
        .feature-5 .app-icon { background: linear-gradient(135deg, #f9c74f, #f8961e); }
        .feature-6 .app-icon { background: linear-gradient(135deg, #90be6d, #43aa8b); }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list li i {
            margin-right: 12px;
            font-size: 18px;
        }
        
        .feature-1 .feature-list li i { color: var(--primary); }
        .feature-2 .feature-list li i { color: var(--accent); }
        .feature-3 .feature-list li i { color: var(--success); }
        .feature-4 .feature-list li i { color: #7209b7; }
        .feature-5 .feature-list li i { color: #f9c74f; }
        .feature-6 .feature-list li i { color: #90be6d; }
        
        /* Testimonials */
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-card {
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-card::before {
            content: ''";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: var(--gradient-primary);
        }
        
        /* App Badges */
        .app-badge {
            display: inline-flex;
            align-items: center;
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin-right: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .app-badge:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }
        
        .app-badge img {
            height: 45px;
            margin-right: 15px;
        }
        
        /* Background Sections */
        .bg-gradient-app {
            background: var(--gradient-primary);
        }
        
        .bg-gradient-accent {
            background: var(--gradient-accent);
        }
        
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 5% 10%, rgba(67, 97, 238, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(247, 37, 133, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 50% 20%, rgba(76, 201, 240, 0.1) 0%, transparent 20%);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stat-number {
                font-size: 2.5rem;
            }
            
            .app-icon {
                width: 70px;
                height: 70px;
                font-size: 30px;
            }
            
            .curve-top::before,
            .curve-bottom::after {
                height: 30px;
                top: -30px;
                bottom: -30px;
            }
        }
    </style>

    <style>
        :root {
            --primary: #2D5BFF;
            --secondary: #6C63FF;
            --accent: #00D2FF;
            --success: #00C9A7;
            --warning: #FFC75F;
            --light: #F8F9FA;
            --dark: #212529;
            --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
            --gradient-accent: linear-gradient(135deg, var(--accent), #6C63FF);
            --gradient-success: linear-gradient(135deg, var(--success), #00D2FF);
            --gradient-warning: linear-gradient(135deg, var(--warning), #FF9671);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-accent);
            border-radius: 2px;
        }
        
        .section-subtitle {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        /* Card Styles */
        .feature-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
            background: white;
            position: relative;
            z-index: 1;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient-primary);
            z-index: 2;
        }
        
        .card-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 34px;
            color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-1 .card-icon { background: var(--gradient-primary); }
        .card-2 .card-icon { background: var(--gradient-accent); }
        .card-3 .card-icon { background: var(--gradient-success); }
        .card-4 .card-icon { background: var(--gradient-warning); }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        
        .feature-list li {
            padding: 10px 0;
            display: flex;
            align-items: flex-start;
        }
        
        .feature-list li i {
            margin-right: 12px;
            font-size: 16px;
            margin-top: 4px;
            flex-shrink: 0;
        }
        
        .card-1 .feature-list li i { color: var(--primary); }
        .card-2 .feature-list li i { color: var(--accent); }
        .card-3 .feature-list li i { color: var(--success); }
        .card-4 .feature-list li i { color: var(--warning); }
        
        /* Vision Mission Section */
        .vision-mission-section {
            background: var(--gradient-primary);
            color: white;
            border-radius: 30px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 40px rgba(45, 91, 255, 0.2);
        }
        
        .vision-mission-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.05)" d="M0,0 L1000,0 L1000,1000 L0,1000 Z M250,250 L750,250 L750,750 L250,750 Z"></path></svg>');
            background-size: cover;
        }
        
        .vision-box, .mission-box {
            padding: 40px;
            position: relative;
            z-index: 1;
        }
        
        .vision-box {
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .vision-icon, .mission-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        
        /* Learning System Section */
        .learning-system-section {
            background: white;
            border-radius: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .learning-item {
            padding: 25px;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .learning-item:hover {
            background: rgba(45, 91, 255, 0.05);
            transform: translateY(-5px);
        }
        
        .learning-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: white;
        }
        
        .learning-1 .learning-icon { background: var(--gradient-primary); }
        .learning-2 .learning-icon { background: var(--gradient-accent); }
        .learning-3 .learning-icon { background: var(--gradient-success); }
        .learning-4 .learning-icon { background: var(--gradient-warning); }
        
        /* App Features Section */
        .app-features-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 30px;
            overflow: hidden;
            position: relative;
        }
        
        .app-features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(108, 99, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 210, 255, 0.1) 0%, transparent 50%);
        }
        
        .app-feature-item {
            padding: 25px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            z-index: 1;
        }
        
        .app-feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .app-feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: white;
        }
        
        .app-feature-1 .app-feature-icon { background: var(--gradient-primary); }
        .app-feature-2 .app-feature-icon { background: var(--gradient-accent); }
        .app-feature-3 .app-feature-icon { background: var(--gradient-success); }
        .app-feature-4 .app-feature-icon { background: var(--gradient-warning); }
        
        /* Background Patterns */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 5% 10%, rgba(45, 91, 255, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(108, 99, 255, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 50% 20%, rgba(0, 210, 255, 0.05) 0%, transparent 20%);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .vision-box {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .feature-card, .app-feature-item, .learning-item {
                margin-bottom: 20px;
            }
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{url('login')}}">
                <i class="fas fa-graduation-cap me-2"></i>DARLI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang di Aplikasi Alumni Dar el-ilmi<span class="text-primary"> Pondok Pesantren Ma'had Dar el-ilmi Sumatera Barat</span></h1>
                    <p class="lead mb-4">Cerdas beragama, trampil berdunia </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{url('login')}}" class="btn btn-primary btn-lg">Aktivasi Alumni</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{asset('images/alumni3.jpg')}}" class="img-fluid rounded-3 shadow" alt="Alumni Pesantren">
                </div>
            </div>
        </div>
    </section>

    <!-- About Pondok Section -->
    <section class="py-5 bg-pattern" style="padding-top: 80px; padding-bottom: 80px;">
        <div class="container">
            <h2 class="section-title">Tentang Pondok Pesantren Dar el-ilmi</h2>
            <p class="section-subtitle">Pondok Pesantren yang menggabungkan antara Pendidikan Agama islam yang mumpuni dengan keilmuan duniawi yang terpadu dalam program Keahlian dan Kejuruan.</p>
            
            <!-- Keunggulan Pondok -->
            <div class="row mb-5">
                <div class="col-12 mb-4">
                    <h3 class="text-center mb-4 fw-bold" style="color: var(--primary);">Keunggulan Pondok Pesantren</h3>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card p-4 card-1">
                        <div class="card-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="text-center mb-3">Keunggulan Ma'had Dar El-Ilmi Sumatera Barat</h4>
                        <p>Pondok pesantren yang menggabungkan antara pendidikan agama islam yang mumpuni dengan keilmuan duniawi yang terpadu dalam program keahlian dan kejuruan.</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Aqidah ahlussunnah wal jama'ah dan manhaj salaf.</li>
                            <li><i class="fas fa-check"></i> Berbahasa arab aktif</li>
                            <li><i class="fas fa-check"></i> Pembentuka karekter yang mandiri, bertanggung jawab, disiplin, tangguh, dan terampil.</li>
                            <li><i class="fas fa-check"></i> Program keahlian dan kejuruan.</li>
                            <li><i class="fas fa-check"></i> Pendidikan dan pembinaan 24 jam.</li>
                            <li><i class="fas fa-check"></i> Pengawasan exstra(guru yang berkeluarga yang menetap di pondok dan pantauaan cctv).</li>
                            <li><i class="fas fa-check"></i> Metode akademik dan mulazamah kitab.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card p-4 card-2">
                        <div class="card-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h4 class="text-center mb-3">Materi Pembelajaran</h4>
                        <p>Memadukan antara pendidikan umum, kejuruan dan mulazamah kitab.</p>
                        <ul class="feature-list">
                            <p>Pelajaran Agama :</p>
                            <li><i class="fas fa-check"></i> Aqidah</li>
                            <li><i class="fas fa-check"></i> Bahasa arab</li>
                            <li><i class="fas fa-check"></i> Fiqih</li>
                            <li><i class="fas fa-check"></i> Siroh nabawiyah</li>
                            <li><i class="fas fa-check"></i> Adab</li>
                            <li><i class="fas fa-check"></i> Kaidah bahasa arab nahwu dan shorof</li>
                            <li><i class="fas fa-check"></i> Tafsir</li>
                            <li><i class="fas fa-check"></i> Balaghoh</li>
                            <li><i class="fas fa-check"></i> Dan lainnya.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card p-4 card-3">
                        <div class="card-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h4 class="text-center mb-3">Pengembangan Karakter & Ekstrakurikuler</h4>
                        <p>Pembentukan akhlak mulia dan karakter islami melalui pembiasaan dan keteladanan.</p>
                        <ul class="feature-list">
                            <p>Pengembangan karakter  :</p>
                            <li><i class="fas fa-check"></i> Pendidikan akhlak mulia</li>
                            <li><i class="fas fa-check"></i> Pembinaan kepemimpinan</li>
                            <li><i class="fas fa-check"></i> Kegiatan sosial kemasyarakatan</li>
                            <p>Ekstrakurikuler  :</p>
                            <li><i class="fas fa-check"></i> Jelajah alam</li>
                            <li><i class="fas fa-check"></i> Multimedia</li>
                            <li><i class="fas fa-check"></i> Dakwan pedalaman</li>
                            <li><i class="fas fa-check"></i> Pelatihan khutbah</li>
                            <li><i class="fas fa-check"></i> Organisasi santri</li>
                            <li><i class="fas fa-check"></i>  Tata boga</li>
                            <li><i class="fas fa-check"></i> Dan lainnya.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card p-4 card-4">
                        <div class="card-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4 class="text-center mb-3">Fasilitas yang di sediakan di pondok</h4>
                        <p>Fasilitas pendidikan lengkap dan modern untuk mendukung proses belajar mengajar.</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Ruang kelas</li>
                            <li><i class="fas fa-check"></i> Perpustakaan </li>
                            <li><i class="fas fa-check"></i> Asrama per kelas</li>
                            <li><i class="fas fa-check"></i> Masjid</li>
                            <li><i class="fas fa-check"></i> Dapur</li>
                            <li><i class="fas fa-check"></i> Lapangan olahraga</li>
                            <li><i class="fas fa-check"></i> Kantin</li>
                            <li><i class="fas fa-check"></i> Wifi gratis</li>
                            <li><i class="fas fa-check"></i> Dan lainnya.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Visi dan Misi -->
            <div class="vision-mission-section mb-5">
                <div class="row g-0">
                    <div class="col-lg-6 vision-box">
                        <div class="vision-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="mb-3">Visi Kami</h3>
                        <p class="mb-4">In sya Allah, melahirkan generasi muslim yang menguasai ilmu syar'i dam memiliki skill intelektual yang handal.</p>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-quote-left fa-2x opacity-50"></i>
                            </div>
                            <p class="mb-0 fst-italic">"Visi dan misi Ma'had TI Dar El-Ilmi Payakumbuh berfokus pada integrasi ilmu agama yang lurus dengan keahlian teknologi modern untuk kebutuhan dakwah di masa depan."</p>
                        </div>
                    </div>
                    <div class="col-lg-6 mission-box">
                        <div class="mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mb-3">Misi Kami</h3>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Pemurnian Akidah: Menanamkan pemahaman agama berdasarkan Manhaj Salaf (pemahaman Rasulullah dan para sahabat).</li>
                            <li><i class="fas fa-check"></i> Penguasaan Bahasa & Al-Qur'an: Menghasilkan lulusan yang lancar berbahasa Arab aktif dan memiliki hafalan Al-Qur'an yang kuat.</li>
                            <li><i class="fas fa-check"></i> Jihad Teknologi Informasi: Membekali santri dengan keahlian di bidang networking (sertifikasi MTCNA/CCNA) dan pemrograman (Android) untuk menyebarkan dakwah dan menangkal pemahaman sesat di dunia digital.</li>
                            <li><i class="fas fa-check"></i> Keseimbangan Ilmu: Menerapkan kurikulum terpadu dengan komposisi 70% ilmu syariat dan 30% keterampilan IT.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Sistem Pembelajaran -->
            <div class="learning-system-section p-4 p-md-5 mb-5">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold mb-3" style="color: var(--primary);">Sistem Pembelajaran Terpadu</h3>
                        <p class="text-muted">Sistem pembelajaran di Ma'had TI Dar El-Ilmi Payakumbuh menggunakan metode pendidikan terpadu yang mengombinasikan kurikulum pesantren tradisional (kitab) dengan standar kompetensi teknologi informasi modern.</p>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="learning-item learning-1">
                            <div class="learning-icon">
                                <i class="fas fa-quran"></i>
                            </div>
                            <h5 class="mb-3"> Pembagian Kurikulum (70:30)</h5>
                            <p class="mb-0">Pesantren menerapkan proporsi waktu belajar yang spesifik untuk menjaga keseimbangan antara bekal akhirat dan dunia:
70% Ilmu Syariat: Fokus pada penguasaan akidah sesuai Manhaj Salaf, bahasa Arab aktif, hafalan Al-Qur'an, dan kajian kitab-kitab fikih.
30% Keterampilan TI: Fokus pada penguasaan teknologi praktis sebagai alat dakwah dan kemandirian ekonomi santri. </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="learning-item learning-2">
                            <div class="learning-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h5 class="mb-3">Penjurusan Keahlian IT</h5>
                            <p class="mb-0">Mulai tingkat menengah atas, santri diarahkan untuk memilih salah satu dari dua fokus keahlian:
Jaringan Komputer (Networking): Berorientasi pada sertifikasi internasional seperti MTCNA (MikroTik) atau CCNA (Cisco).
Pemrograman (Programming): Berfokus pada pengembangan aplikasi Android.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="learning-item learning-3">
                            <div class="learning-icon">
                                <i class="fas fa-language"></i>
                            </div>
                            <h5 class="mb-3">Metode Pembelajaran & Fasilitas</h5>
                            <p class="mb-0">Praktik Langsung: Pembelajaran TI dilakukan di laboratorium untuk memastikan santri tidak hanya menguasai teori tetapi juga skill teknis (misal: membangun smart system).
Sertifikasi Kompetensi: Selain ijazah pondok, lulusan diproyeksikan memiliki sertifikat keahlian yang diakui industri.
Asrama (Boarding): Pembentukan karakter dan kedisiplinan dilakukan selama 24 jam di asrama dengan bahasa Arab sebagai bahasa pengantar harian. </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="learning-item learning-4">
                            <div class="learning-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h5 class="mb-3"> Tenaga Pengajar</h5>
                            <p class="mb-0">Sistem ini didukung oleh pengajar yang kompeten di bidangnya, mulai dari lulusan Universitas Islam Madinah dan LIPIA untuk ilmu agama, hingga lulusan universitas ternama seperti UGM, UNP, dan National Taiwan University untuk bidang teknologi. </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Keunggulan Aplikasi DARLI -->
            <div class="app-features-section p-4 p-md-5">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold mb-3" style="color: var(--primary);">Keunggulan Aplikasi DARLI</h3>
                        <p class="text-muted">Aplikasi alumni Dar el-ilmi yang menghubungkan seluruh keluarga besar pesantren</p>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="app-feature-item app-feature-1">
                            <div class="app-feature-icon">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <h5 class="mb-3">Jaringan Alumni</h5>
                            <p class="mb-0">Terhubung dengan ratusan alumni dari berbagai angkatan dan daerah untuk memperluas jejaring profesional.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="app-feature-item app-feature-2">
                            <div class="app-feature-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="mb-3">Info Kegiatan</h5>
                            <p class="mb-0">Akses informasi terbaru tentang kegiatan pondok, reuni, seminar, dan event lainnya.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="app-feature-item app-feature-3">
                            <div class="app-feature-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h5 class="mb-3">Peluang Karir</h5>
                            <p class="mb-0">Temukan lowongan kerja eksklusif dari perusahaan mitra dan alumni yang sukses dan peluang di pondok.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="app-feature-item app-feature-4">
                            <div class="app-feature-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h5 class="mb-3">Menjaga hubungan silaturahmi pihak pondok dengan alumni.</h5>
                            <p class="mb-0">Dapat berkonsultasi dengan para asatiz dalam permasalahan dan lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap & Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
    <!-- Testimonials Section -->
    <section class="py-5 bg-gradient-accent text-black">
        <div class="curve-top"></div>
        <div class="container py-5">
            <h2 class="text-center section-title mx-auto mb-5 text-white">Apa Kata Pengguna Aplikasi</h2>

            <div class="row g-4">
                @forelse ($testimonials as $t)
                    <div class="col-md-6">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $t->user->foto 
                                            ? asset('storage/'.$t->user->foto) 
                                            : 'https://randomuser.me/api/portraits/'.($loop->index % 2 == 0 ? 'men' : 'women').'/'.rand(1,99).'.jpg' }}" 
                                    class="testimonial-avatar me-3" 
                                    alt="{{ $t->user->username ?? 'Pengguna' }}">
                                <div>
                                    <h5 class="mb-0">{{ $t->user->username ?? 'Pengguna' }}</h5>
                                    <span class="text-muted">
                                        {{ $t->user->tahun_masuk && $t->user->tahun_tamat ? 'Alumni Tahun '.$t->user->tahun_masuk.' - '.$t->user->tahun_tamat : 'Alumni' }}
                                    </span>
                                </div>
                            </div>

                            <p class="mb-0">"{{ $t->content }}"</p>

                            @if($t->rating)
                                <div class="mt-2 text-warning">
                                    @for($i = 0; $i < $t->rating; $i++)
                                        ★
                                    @endfor
                                    @for($i = $t->rating; $i < 5; $i++)
                                        ☆
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-white">Belum ada testimoni saat ini.</p>
                @endforelse
            </div>
        </div>
        <div class="curve-bottom"></div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-pattern">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Download Aplikasi Alumni Sekarang</h2>
                    <p class="lead mb-4">Bergabunglah dengan ribuan alumni lainnya dan nikmati kemudahan tetap terhubung dengan keluarga besar pondok pesantren</p>
                    
                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="app-badge">
                            <i class="fab fa-google-play fa-2x me-2 text-primary"></i>
                            <div>
                                <small>Download di</small>
                                <h5 class="mb-0">Google Play</h5>
                            </div>
                        </div>
                        <div class="app-badge">
                            <i class="fab fa-apple fa-2x me-2 text-primary"></i>
                            <div>
                                <small>Download di</small>
                                <h5 class="mb-0">App Store</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="mb-4">DARLI</h4>
                    <p>Portal alumni pesantren yang memudahkan Anda terhubung dengan teman seangkatam, guru, dan berbagai kesempatan berkembang.</p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="mb-4">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Event</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Galeri</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Lowongan</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5 class="mb-4">Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Singa Harau No. 87, Balai Panjang, Payakumbuh Selatan, Kota Payakumbuh, Sumatera Barat</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (021) 1234-5678</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@alumniconnect.com</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5 class="mb-4">Newsletter</h5>
                    <p>Berlangganan newsletter kami untuk mendapatkan update terbaru.</p>
                    <form>
                        <div class="input-group">
                            <input type="email" class="form-control rounded-pill me-2" placeholder="Email Anda">
                            <button class="btn btn-light rounded-pill mt-2" type="submit">Berlangganan</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 DARLI - Portal Alumni Pesantren. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>