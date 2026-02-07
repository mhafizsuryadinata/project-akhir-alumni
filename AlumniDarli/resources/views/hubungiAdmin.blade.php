<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Login - Alumni Dar el-ilmi</title>
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #2575fc);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            padding: 20px;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Particle Effect */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }
        
        .error-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 700px;
            min-height: 400px;
            z-index: 10;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
        }
        
        .error-header {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            padding: 25px 30px;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .error-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.2),
                rgba(255, 255, 255, 0)
            );
            transform: rotate(30deg);
            animation: shine 5s infinite linear;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(30deg); }
            100% { transform: translateX(100%) rotate(30deg); }
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }
        
        .logo i {
            font-size: 30px;
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header-text {
            position: relative;
            z-index: 2;
        }
        
        .header-text h2 {
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 24px;
        }
        
        .header-text p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .error-body {
            padding: 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .error-content {
            display: flex;
            gap: 30px;
            align-items: center;
            flex-grow: 1;
        }
        
        .error-icon {
            flex-shrink: 0;
            text-align: center;
        }
        
        .error-icon i {
            font-size: 80px;
            color: #e74c3c;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.2));
        }
        
        .error-details {
            flex-grow: 1;
        }
        
        .error-title {
            color: #e74c3c;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .error-message {
            background-color: #fff9f9;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .error-message p {
            color: #555;
            line-height: 1.5;
            margin: 0;
            font-size: 15px;
        }
        
        .contact-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .contact-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .contact-section h3 i {
            color: var(--primary);
        }
        
        .admin-numbers {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .admin-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            flex: 1;
            min-width: 200px;
            border-left: 4px solid var(--primary);
        }
        
        .admin-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 15px;
        }
        
        .admin-number {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #25D366;
            font-weight: 500;
            font-size: 16px;
        }
        
        .admin-number i {
            font-size: 18px;
        }
        
        .whatsapp-button {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .whatsapp-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }
        
        .whatsapp-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(37, 211, 102, 0.4);
            color: white;
        }
        
        .whatsapp-button:hover::before {
            left: 100%;
        }
        
        .whatsapp-button i {
            margin-right: 8px;
            font-size: 18px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: auto;
        }
        
        .btn-back {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }
        
        .btn-back::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #1a73e8, var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-back:hover::before {
            left: 100%;
        }
        
        .btn-back i {
            margin-right: 8px;
        }
        
        .btn-retry {
            background: linear-gradient(135deg, var(--secondary), #27ae60);
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }
        
        .btn-retry::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }
        
        .btn-retry:hover {
            background: linear-gradient(135deg, #27ae60, var(--secondary));
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .btn-retry:hover::before {
            left: 100%;
        }
        
        .btn-retry i {
            margin-right: 8px;
        }
        
        .error-footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        .error-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 13px;
        }
        
        /* Animasi untuk elemen error */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .error-body > * {
            animation: fadeIn 0.6s forwards;
        }
        
        @media (max-width: 768px) {
            .error-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .admin-numbers {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .error-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .error-container {
                max-width: 100%;
            }
            
            .error-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Particle Effect Container -->
    <div id="particles-js"></div>
    
    <div class="error-container">
        <div class="error-header">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="header-text">
                <h2>DARLI</h2>
                <p>Portal Alumni Pondok Pesantren Ma'had Dar el-ilmi Sumatera Barat</p>
            </div>
        </div>
        
        <div class="error-body">
            <div class="error-content">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                
                <div class="error-details">
                    <h3 class="error-title">Terjadi Kesalahan Login</h3>
                    
                    <div class="error-message">
                        <p>Silakan hubungi admin, nomor NIA dan username Anda salah.</p>
                    </div>
                    
                    <div class="contact-section">
                        <h3><i class="fas fa-headset"></i> Hubungi Admin</h3>
                        
                        <div class="admin-numbers">
                            <div class="admin-card">
                                <div class="admin-name">Admin Utama</div>
                                <div class="admin-number">
                                    <i class="fab fa-whatsapp"></i>
                                    +62 812-3456-7890
                                </div>
                            </div>
                            
                            <div class="admin-card">
                                <div class="admin-name">Admin Pendamping</div>
                                <div class="admin-number">
                                    <i class="fab fa-whatsapp"></i>
                                    +62 823-4567-8901
                                </div>
                            </div>
                        </div>
                        
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20mengalami%20masalah%20dengan%20login%20NIA%20dan%20username" class="whatsapp-button" target="_blank">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                        
                        <div class="admin-info mt-3">
                            <p><i class="far fa-clock"></i> Jam Kerja: 08.00 - 16.00 WIB (Senin - Jumat)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-back" onclick="goBack()">
                    <i class="fas fa-redo"></i></i> Coba Lagi
                </button>
                <button class="btn btn-retry" onclick="retryLogin()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>
        </div>
        
        <div class="error-footer">
            <p>&copy; 2025 Alumni Dar el-ilmi. All rights reserved.</p>
        </div>
    </div>

    <!-- Particle.js Library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <script>
        // Initialize particles.js
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { 
                    type: "circle", 
                    stroke: { width: 0, color: "#000000" },
                    polygon: { nb_sides: 5 }
                },
                opacity: {
                    value: 0.5,
                    random: true,
                    anim: { enable: true, speed: 1, opacity_min: 0.1, sync: false }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: { enable: true, speed: 2, size_min: 0.1, sync: false }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ffffff",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                    attract: { enable: false, rotateX: 600, rotateY: 1200 }
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "grab" },
                    onclick: { enable: true, mode: "push" },
                    resize: true
                },
                modes: {
                    grab: { distance: 140, line_linked: { opacity: 1 } },
                    push: { particles_nb: 4 }
                }
            },
            retina_detect: true
        });
        
        // Fungsi untuk kembali ke halaman sebelumnya
        function goBack() {
            window.history.back();
        }
        
        // Fungsi untuk mencoba login kembali
        function retryLogin() {
            window.location.href = '/'; // Ganti dengan URL halaman login Anda
        }
        
        // Fungsi untuk menyalin nomor admin
        function copyNumber(number) {
            navigator.clipboard.writeText(number).then(function() {
                alert('Nomor admin berhasil disalin: ' + number);
            }, function(err) {
                console.error('Gagal menyalin nomor: ', err);
            });
        }
    </script>
</body>
</html>