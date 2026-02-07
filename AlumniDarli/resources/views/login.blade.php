<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Alumni Dar el-ilmi</title>
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
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            z-index: 10;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: scale(1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .login-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            padding: 35px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
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
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }
        
        .logo i {
            font-size: 40px;
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .login-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .login-header p {
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 14px 20px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.3rem rgba(52, 152, 219, 0.2);
            transform: translateY(-2px);
        }
        
        .input-group-text {
            background: transparent;
            border-radius: 12px 0 0 12px;
            border-right: none;
        }
        
        .form-control:focus + .input-group-text {
            border-color: var(--primary);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary), #1a73e8);
            border: none;
            border-radius: 50px;
            padding: 14px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
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
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1a73e8, var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            position: relative;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider span {
            padding: 0 15px;
            color: #6c757d;
            font-size: 14px;
            background: white;
            z-index: 1;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 255, 255, 0.2), transparent);
            transform: translateY(100%);
            transition: transform 0.3s;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .social-btn:hover::before {
            transform: translateY(0);
        }
        
        .fb-btn {
            background: #3b5998;
        }
        
        .google-btn {
            background: #dd4b39;
        }
        
        .twitter-btn {
            background: #1da1f2;
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
        }
        
        .login-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        
        .login-footer a:hover {
            color: #1a73e8;
        }
        
        .login-footer a:hover::after {
            width: 100%;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .toggle-password {
            cursor: pointer;
            background: transparent;
            border: none;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #6c757d;
            transition: color 0.3s;
        }
        
        .toggle-password:hover {
            color: var(--primary);
        }
        
        .password-container {
            position: relative;
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 20px;
        }
        
        .floating-label label {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #6c757d;
            transition: all 0.3s;
            pointer-events: none;
        }
        
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            background: white;
            padding: 0 8px;
            color: var(--primary);
        }
        
        /* Animasi untuk elemen form */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-body > * {
            animation: fadeIn 0.6s forwards;
        }
        
        .login-body > *:nth-child(1) { animation-delay: 0.1s; }
        .login-body > *:nth-child(2) { animation-delay: 0.2s; }
        .login-body > *:nth-child(3) { animation-delay: 0.3s; }
        .login-body > *:nth-child(4) { animation-delay: 0.4s; }
        .login-body > *:nth-child(5) { animation-delay: 0.5s; }
        .login-body > *:nth-child(6) { animation-delay: 0.6s; }
        .login-body > *:nth-child(7) { animation-delay: 0.7s; }
    </style>
</head>
<body>
    <!-- Particle Effect Container -->
    <div id="particles-js"></div>
    
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2>DARLI</h2>
            <p>Portal Alumni Pondok Pesantren Ma'had Dar el-ilmi Sumatera Barat</p>
        </div>
        
        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form method="POST" action="{{ url('actionlogin') }}">
                @csrf

                 <div class="floating-label">
                    <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                    <label for="username"><i class="fas fa-user me-1"></i> Nama Pengguna</label>
                </div>

                <div class="floating-label">
                    <input type="password" class="form-control" id="nomor_nia" name="nomor_nia" placeholder=" " required>
                    <label for="nomor_nia"><i class="fas fa-id-card"></i> Nomor NIA / Kode</label>
                </div>
                <button type="submit" class="btn btn-login">Masuk</button>
                
                <div class="divider">
                    <span>Atau masuk dengan</span>
                </div>
                
                <div class="social-login">
                    <a href="#" class="social-btn fb-btn">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn google-btn">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-btn twitter-btn">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                <div class="text-center">
                    <p>Belum punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#registerInfoModal">Daftar</a></p>
                </div>
            </form>
        </div>
        
        <div class="login-footer">
            <p>&copy; 2025 Alumni Dar el-ilmi. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Informasi Pendaftaran -->
    <div class="modal fade" id="registerInfoModal" tabindex="-1" aria-labelledby="registerInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header bg-primary text-white p-4">
                    <h5 class="modal-title fw-bold" id="registerInfoModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Pendaftaran Akun
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-info-circle text-primary" style="font-size: 60px; opacity: 0.2;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Ingin mendaftar sebagai alumni?</h5>
                    <p class="text-muted mb-4">
                        Untuk menjaga validitas data alumni, pendaftaran akun dilakukan secara manual oleh Administrator. Silakan hubungi admin di bawah ini untuk dibuatkan akun baru.
                    </p>
                    
                    <div class="d-grid gap-3 mb-4">
                        @if($admin)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $admin->no_hp) }}?text=Halo%20Admin,%20saya%20alumni%20ingin%20mendaftar%20akun%20di%20portal%20AlumniDarli" target="_blank" class="btn btn-outline-success p-3 rounded-pill d-flex align-items-center justify-content-center">
                            <i class="fab fa-whatsapp me-2 fs-4"></i>
                            <div class="text-start">
                                <div class="fw-bold">{{ $admin->nama }}</div>
                                <div class="small">{{ $admin->no_hp }}</div>
                            </div>
                        </a>
                        @else
                        <p class="text-danger">Data admin tidak ditemukan.</p>
                        @endif
                    </div>
                    
                    <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Particle.js Library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- Bootstrap & Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
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
        
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
        
        // Function untuk menampilkan notifikasi
        function showNotification(message, type) {
            // Hapus notifikasi sebelumnya jika ada
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            // Buat elemen notifikasi
            const notification = document.createElement('div');
            notification.className = `notification alert alert-${type === 'error' ? 'danger' : 'success'}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                animation: slideIn 0.5s forwards;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Hapus notifikasi setelah 3 detik
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.5s forwards';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }
        
        // Tambahkan style untuk animasi notifikasi
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>


</body>
</html>