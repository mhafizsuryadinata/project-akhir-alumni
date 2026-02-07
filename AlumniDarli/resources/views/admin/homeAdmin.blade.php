@extends('admin-master')

@section('judul', 'Dashboard Admin')

@section('isi')
<div class="admin-dashboard">
    <!-- Hero Banner with Gradient & Floating Effect -->
    <div class="row g-4 mb-4">
        <div class="col-12 animate-box" data-animate="fadeInUp">
            <div class="card overflow-hidden border-0 admin-hero shadow-lg">
                <div class="card-body p-5 position-relative">
                    <div class="row align-items-center position-relative z-index-1">
                        <div class="col-md-9 text-white">
                            <h2 class="fw-800 mb-2 display-6">Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->username }}!</h2>
                            <p class="mb-0 opacity-80 fs-5 fw-300">Panel Administrator Alumni Pondok Pesantren Dar el-ilmi. Kelola ekosistem alumni Anda dengan presisi.</p>
                        </div>
                    </div>
                    <div class="position-absolute floating-icon" style="right: -50px; bottom: -50px; opacity: 0.12;">
                        <iconify-icon icon="solar:settings-bold-duotone" style="font-size: 280px; color: white;"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards with Trend & Sparklines -->
    <div class="row g-4 mb-4">
        @php
            $statConfigs = [
                ['label' => 'TOTAL ALUMNI', 'count' => $stats['total_alumni'], 'trend' => $trends['alumni'], 'icon' => 'solar:users-group-rounded-bold-duotone', 'color' => 'primary', 'chart' => 'alumni'],
                ['label' => 'KOMENTAR', 'count' => $stats['total_komentar'], 'trend' => $trends['komentar'], 'icon' => 'solar:chat-round-dots-bold-duotone', 'color' => 'warning', 'chart' => 'komentar'],
                ['label' => 'PESAN KONTAK', 'count' => $stats['total_pesan'], 'trend' => $trends['pesan'], 'icon' => 'solar:letter-bold-duotone', 'color' => 'info', 'chart' => 'pesan'],
                ['label' => 'TOTAL EVENT', 'count' => $stats['total_event'], 'trend' => $trends['event'], 'icon' => 'solar:calendar-bold-duotone', 'color' => 'success', 'chart' => null],
            ];
        @endphp

        @foreach($statConfigs as $index => $cfg)
        <div class="col-xl-3 col-md-6 animate-box" data-animate="fadeInUp" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
            <div class="card border-0 glass-card stat-card-admin h-100 overflow-hidden shadow-sm">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-light-{{ $cfg['color'] }} text-{{ $cfg['color'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <iconify-icon icon="{{ $cfg['icon'] }}" class="fs-6"></iconify-icon>
                        </div>
                        <div class="trend-badge {{ $cfg['trend'] >= 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $cfg['trend'] >= 0 ? 'up' : 'down' }} me-1"></i>{{ abs($cfg['trend']) }}%
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fw-600 text-uppercase small ls-1">{{ $cfg['label'] }}</h6>
                        <h3 class="mb-0 fw-800 counter-value">{{ number_format($cfg['count']) }}</h3>
                    </div>
                    @if($cfg['chart'])
                    <div class="sparkline-container position-absolute bottom-0 start-0 w-100" style="height: 50px; opacity: 0.3;">
                        <canvas id="sparkline-admin-{{ $cfg['chart'] }}"></canvas>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content: Charts & Actions -->
    <div class="row g-4">
        <!-- Left Column: Line Chart & Doughnut Chart -->
        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Line Chart Activity -->
                <div class="col-12 animate-box" data-animate="fadeInUp" style="animation-delay: 0.5s">
                    <div class="card border-0 glass-card chart-card-admin h-100 shadow">
                        <div class="card-header bg-transparent border-0 py-4 px-4">
                            <h5 class="mb-0 fw-700 text-dark"><iconify-icon icon="solar:graph-up-bold-duotone" class="me-2 text-primary"></iconify-icon> Aktivitas Ekosistem (7 Hari)</h5>
                            <small class="text-muted">Pendaftaran Alumni, Komentar, dan Pesan Kontak</small>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 350px; position: relative;">
                                <canvas id="adminLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doughnut Chart: Module Composition -->
                <div class="col-md-6 animate-box" data-animate="fadeInUp" style="animation-delay: 0.6s">
                    <div class="card border-0 glass-card h-100 shadow-sm">
                        <div class="card-header bg-transparent border-0 py-4 px-4">
                            <h6 class="mb-0 fw-700 text-dark"><iconify-icon icon="solar:pie-chart-2-bold-duotone" class="me-2 text-info"></iconify-icon> Komposisi Data</h6>
                        </div>
                        <div class="card-body p-4 d-flex align-items-center justify-content-center">
                            <div style="width: 100%; max-width: 230px;">
                                <canvas id="adminDoughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="col-md-6 animate-box" data-animate="fadeInUp" style="animation-delay: 0.7s">
                    <div class="row g-4 h-100">
                        <div class="col-6">
                            <div class="card border-0 neon-card neon-purple h-100">
                                <div class="card-body p-3 text-center text-white">
                                    <iconify-icon icon="solar:gallery-bold-duotone" class="fs-5 mb-2 opacity-70"></iconify-icon>
                                    <h4 class="fw-800 mb-0">{{ $stats['total_galeri'] }}</h4>
                                    <small class="opacity-70 tiny-text">Album Galeri</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 neon-card neon-orange h-100">
                                <div class="card-body p-3 text-center text-white">
                                    <iconify-icon icon="solar:case-minimalistic-bold-duotone" class="fs-5 mb-2 opacity-70"></iconify-icon>
                                    <h4 class="fw-800 mb-0">{{ $stats['total_lowongan'] }}</h4>
                                    <small class="opacity-70 tiny-text">Lowongan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 neon-card neon-cyan h-100">
                                <div class="card-body p-3 text-center text-white">
                                    <iconify-icon icon="solar:documents-bold-duotone" class="fs-5 mb-2 opacity-70"></iconify-icon>
                                    <h4 class="fw-800 mb-0">{{ $stats['total_info'] }}</h4>
                                    <small class="opacity-70 tiny-text">Info Pondok</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 neon-card neon-pink h-100">
                                <div class="card-body p-3 text-center text-white">
                                    <iconify-icon icon="solar:question-circle-bold-duotone" class="fs-5 mb-2 opacity-70"></iconify-icon>
                                    <h4 class="fw-800 mb-0">{{ $stats['total_faq'] }}</h4>
                                    <small class="opacity-70 tiny-text">FAQ</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Actions & Brand -->
        <div class="col-lg-4">
            <div class="row g-4">
                <!-- Quick Actions -->
                <div class="col-12 animate-box" data-animate="fadeInUp" style="animation-delay: 0.8s">
                    <div class="card border-0 glass-card shadow-sm h-100 overflow-hidden">
                        <div class="card-header bg-transparent border-0 py-4 px-4">
                            <h5 class="mb-0 fw-700"><iconify-icon icon="solar:bolt-circle-bold-duotone" class="me-2 text-warning"></iconify-icon> Navigasi Cepat</h5>
                        </div>
                        <div class="card-body px-4 pb-4 pt-0">
                            <div class="row g-3">
                                @php
                                    $actions = [
                                        ['route' => 'alumni/tampil', 'icon' => 'solar:users-group-rounded-bold-duotone', 'label' => 'Alumni', 'color' => 'primary'],
                                        ['route' => 'admin.event.index', 'icon' => 'solar:calendar-bold-duotone', 'label' => 'Event', 'color' => 'success'],
                                        ['route' => 'admin.galeri.index', 'icon' => 'solar:gallery-bold-duotone', 'label' => 'Galeri', 'color' => 'purple'],
                                        ['route' => 'admin.lowongan.index', 'icon' => 'solar:case-minimalistic-bold-duotone', 'label' => 'Lowongan', 'color' => 'danger'],
                                        ['route' => 'admin.info.index', 'icon' => 'solar:documents-bold-duotone', 'label' => 'Info', 'color' => 'info'],
                                        ['route' => 'admin.pesan.index', 'icon' => 'solar:letter-bold-duotone', 'label' => 'Pesan', 'color' => 'orange'],
                                    ];
                                @endphp
                                @foreach($actions as $action)
                                <div class="col-4">
                                    <a href="{{ str_contains($action['route'], '.') ? route($action['route']) : url($action['route']) }}" class="action-tile-admin p-3 rounded-3 text-center text-decoration-none d-block">
                                        <div class="action-icon bg-light-{{ $action['color'] }} text-{{ $action['color'] }} mb-2 mx-auto rounded-circle">
                                            <iconify-icon icon="{{ $action['icon'] }}" class="fs-7"></iconify-icon>
                                        </div>
                                        <span class="d-block tiny-text fw-600 text-dark">{{ $action['label'] }}</span>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brand Card -->
                <div class="col-12 animate-box" data-animate="fadeInUp" style="animation-delay: 0.9s">
                    <div class="card border-0 admin-brand-card overflow-hidden shadow-lg position-relative" style="min-height: 180px;">
                        <div class="card-body p-4 text-center text-white d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ url('images/logo_alumni.png') }}" alt="Logo" style="height: 50px; filter: brightness(0) invert(1);" class="mb-3">
                            <h5 class="fw-800 mb-1 ls-1">ADMINISTRATOR</h5>
                            <p class="opacity-70 small mb-0">Sistem Informasi Alumni Terpadu</p>
                            <div class="mt-3 glass-badge p-2 px-3 rounded-pill tiny-text">
                                <iconify-icon icon="solar:shield-keyhole-bold-duotone" class="me-1"></iconify-icon> Full Access Level
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Admin Theme */
    .fw-800 { font-weight: 800; }
    .fw-700 { font-weight: 700; }
    .fw-600 { font-weight: 600; }
    .fw-300 { font-weight: 300; }
    .ls-1 { letter-spacing: 1px; }
    .tiny-text { font-size: 0.7rem; }

    /* Hero Gradient */
    .admin-hero {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        box-shadow: 0 20px 40px rgba(15, 12, 41, 0.3);
    }

    /* Glass Cards */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }

    /* Neon Cards */
    .neon-card { border-radius: 12px; }
    .neon-purple { background: linear-gradient(135deg, #7c3aed, #9333ea); }
    .neon-orange { background: linear-gradient(135deg, #f97316, #fb923c); }
    .neon-cyan { background: linear-gradient(135deg, #06b6d4, #22d3ee); }
    .neon-pink { background: linear-gradient(135deg, #ec4899, #f472b6); }

    /* Admin Brand */
    .admin-brand-card { background: linear-gradient(135deg, #1e3a5f 0%, #0d4f8b 50%, #0891b2 100%); }

    /* Animations */
    .animate-box { opacity: 0; visibility: hidden; }
    .animate-box.fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); visibility: visible; } }
    .floating-icon { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-20px) rotate(5deg); } }

    /* Trend & Stat Cards */
    .trend-badge { padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; }
    .trend-badge.up { background: rgba(40, 167, 69, 0.15); color: #28a745; }
    .trend-badge.down { background: rgba(220, 53, 69, 0.15); color: #dc3545; }
    .bg-light-primary { background: rgba(26, 115, 232, 0.1); }
    .bg-light-success { background: rgba(40, 167, 69, 0.1); }
    .bg-light-info { background: rgba(6, 182, 212, 0.1); }
    .bg-light-warning { background: rgba(255, 193, 7, 0.1); }
    .bg-light-danger { background: rgba(220, 53, 69, 0.1); }
    .bg-light-purple { background: rgba(124, 58, 237, 0.1); }
    .bg-light-orange { background: rgba(249, 115, 22, 0.1); }
    .text-purple { color: #7c3aed; }
    .text-orange { color: #f97316; }

    /* Action Tiles */
    .action-tile-admin { background: #fff; border: 1px solid rgba(0,0,0,0.03); transition: all 0.3s ease; }
    .action-tile-admin:hover { transform: translateY(-6px); background: #fff; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .action-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }

    /* Glass Badge */
    .glass-badge { background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.2); }

    /* Chart Styling */
    .chart-card-admin { background: #fff; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Staggered Animations
    const animatedElements = document.querySelectorAll('.animate-box');
    animatedElements.forEach((el) => el.classList.add('fadeInUp'));

    // 2. Line Chart for Activity
    const lineCtx = document.getElementById('adminLineChart').getContext('2d');
    const gradient1 = lineCtx.createLinearGradient(0, 0, 0, 350);
    gradient1.addColorStop(0, 'rgba(124, 58, 237, 0.4)');
    gradient1.addColorStop(1, 'rgba(124, 58, 237, 0.02)');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                { label: 'Alumni', data: @json($chartData['alumni']), borderColor: '#7c3aed', backgroundColor: gradient1, fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#fff', pointBorderWidth: 2 },
                { label: 'Komentar', data: @json($chartData['komentar']), borderColor: '#ffc107', fill: false, tension: 0.4, pointRadius: 0, borderDash: [5, 5] },
                { label: 'Pesan', data: @json($chartData['pesan']), borderColor: '#06b6d4', fill: false, tension: 0.4, pointRadius: 0 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { weight: '600' } } } },
            scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } }, x: { grid: { display: false } } },
            interaction: { intersect: false, mode: 'index' }
        }
    });

    // 3. Doughnut Chart for Composition
    const doughnutCtx = document.getElementById('adminDoughnutChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Alumni', 'Event', 'Galeri', 'Lowongan', 'Info'],
            datasets: [{
                data: [{{ $stats['total_alumni'] }}, {{ $stats['total_event'] }}, {{ $stats['total_galeri'] }}, {{ $stats['total_lowongan'] }}, {{ $stats['total_info'] }}],
                backgroundColor: ['#7c3aed', '#28a745', '#06b6d4', '#f97316', '#ec4899'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            cutout: '70%',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 15 } } }
        }
    });

    // 4. Mini Sparklines
    const sparklineData = { alumni: @json($chartData['alumni']), komentar: @json($chartData['komentar']), pesan: @json($chartData['pesan']) };
    const sparkColors = { alumni: '#1a73e8', komentar: '#ffc107', pesan: '#06b6d4' };
    Object.keys(sparklineData).forEach(key => {
        const canvas = document.getElementById(`sparkline-admin-${key}`);
        if (canvas) {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, { type: 'line', data: { labels: sparklineData[key].map((_, i) => i), datasets: [{ data: sparklineData[key], borderColor: sparkColors[key], borderWidth: 2, fill: false, tension: 0.5, pointRadius: 0 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false } } } });
        }
    });
});
</script>
@endpush