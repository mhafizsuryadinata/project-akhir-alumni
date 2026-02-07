<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Authentication Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 50px; background: #f5f5f5; }
        .test-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #17a2b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-box">
            <h2>🔍 Test Status Login & Akses Lowongan</h2>
            <hr>
            
            <h4>1. Status Authentication:</h4>
            @auth
                <div class="alert alert-success">
                    <strong>✅ ANDA SUDAH LOGIN</strong><br>
                    <ul class="mt-2 mb-0">
                        <li>User ID: <strong>{{ Auth::user()->id_user }}</strong></li>
                        <li>Username: <strong>{{ Auth::user()->username }}</strong></li>
                        <li>Nama: <strong>{{ Auth::user()->name }}</strong></li>
                        <li>Role: <strong>{{ Auth::user()->role }}</strong></li>
                        <li>Email: <strong>{{ Auth::user()->email }}</strong></li>
                    </ul>
                </div>
            @else
                <div class="alert alert-danger">
                    <strong>❌ ANDA BELUM LOGIN</strong><br>
                    <p class="mb-0 mt-2">Silakan login terlebih dahulu untuk mengakses fitur lowongan.</p>
                </div>
            @endauth
            
            <hr>
            
            <h4>2. Test Link Lowongan:</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">📋 Daftar Lowongan</h5>
                            <p class="card-text">Akses untuk semua user (public)</p>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-primary btn-sm" target="_blank">
                                Test Buka Lowongan
                            </a>
                            <span class="badge bg-success">Public</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">➕ Posting Lowongan</h5>
                            <p class="card-text">Perlu login (auth required)</p>
                            <a href="{{ route('lowongan.create') }}" class="btn btn-success btn-sm" target="_blank">
                                Test Posting Lowongan
                            </a>
                            <span class="badge bg-warning text-dark">Auth Required</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">📄 Lamaran Saya</h5>
                            <p class="card-text">Perlu login (auth required)</p>
                            <a href="{{ route('lowongan.myApplications') }}" class="btn btn-info btn-sm" target="_blank">
                                Test Lamaran Saya
                            </a>
                            <span class="badge bg-warning text-dark">Auth Required</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">👤 Halaman Akun</h5>
                            <p class="card-text">Perlu login (auth required)</p>
                            <a href="/akun" class="btn btn-secondary btn-sm" target="_blank">
                                Test Buka Akun
                            </a>
                            <span class="badge bg-warning text-dark">Auth Required</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <h4>3. Expected Result:</h4>
            <div class="alert alert-info">
                @auth
                    <strong>✅ Karena Anda SUDAH LOGIN:</strong>
                    <ul class="mt-2 mb-0">
                        <li>Klik "Test Posting Lowongan" → Harus tampil form posting</li>
                        <li>Klik "Test Lamaran Saya" → Harus tampil halaman lamaran</li>
                        <li>Klik "Test Buka Akun" → Harus tampil halaman akun</li>
                        <li><strong>TIDAK</strong> boleh redirect ke halaman login</li>
                    </ul>
                @else
                    <strong>❌ Karena Anda BELUM LOGIN:</strong>
                    <ul class="mt-2 mb-0">
                        <li>Klik "Test Posting Lowongan" → Akan redirect ke /login</li>
                        <li>Klik "Test Lamaran Saya" → Akan redirect ke /login</li>
                        <li>Klik "Test Buka Akun" → Akan redirect ke /login</li>
                        <li>Hanya "Test Buka Lowongan" yang bisa diakses</li>
                    </ul>
                @endauth
            </div>
            
            <hr>
            
            <h4>4. Action:</h4>
            <div class="d-flex gap-2">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        🔐 Login Sekarang
                    </a>
                @else
                    <a href="{{ route('logout') }}" class="btn btn-danger">
                        🚪 Logout
                    </a>
                    <a href="{{ route('lowongan.index') }}" class="btn btn-success">
                        📋 Ke Halaman Lowongan
                    </a>
                @endguest
                
                <a href="{{ url('/') }}" class="btn btn-secondary">
                    🏠 Ke Homepage
                </a>
            </div>
            
            <hr>
            
            <h4>5. Troubleshooting:</h4>
            <div class="alert alert-warning">
                <strong>Jika tombol di halaman lowongan tidak bisa diklik:</strong>
                <ol class="mb-0 mt-2">
                    <li>Pastikan Anda sudah login (cek status di atas)</li>
                    <li>Clear cache browser: <code>Ctrl + Shift + Del</code></li>
                    <li>Refresh halaman: <code>F5</code> atau <code>Ctrl + F5</code></li>
                    <li>Coba akses langsung dari test link di atas</li>
                    <li>Jika masih error, logout lalu login ulang</li>
                </ol>
            </div>
            
            <div class="alert alert-light border">
                <strong>📝 Catatan:</strong>
                <p class="mb-0 mt-2">
                    Halaman ini adalah halaman test untuk debugging. 
                    Gunakan link-link di atas untuk test apakah setiap fitur bisa diakses atau tidak.
                    Jika ada yang redirect ke login padahal sudah login, berarti ada masalah dengan session.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
