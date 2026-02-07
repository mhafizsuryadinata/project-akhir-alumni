@extends('mudir-master')

@section('content')
<div class="dashboard-container">
    <!-- Hero Banner -->
    <div class="row g-4 mb-4">
        <div class="col-12 animate-box" data-animate="fadeInUp">
            <div class="card overflow-hidden border-0 hero-card shadow-lg">
                <div class="card-body p-5 position-relative">
                    <div class="row align-items-center position-relative z-index-1">
                        <div class="col-md-9 text-white">
                            <h2 class="fw-800 mb-2 display-6">Selamat Datang Kembali, {{ Auth::user()->nama }}!</h2>
                            <p class="mb-0 opacity-80 fs-5 fw-300">Panel Pimpinan Pondok Pesantren Dar el-ilmi. Pantau ekosistem alumni dengan wawasan data real-time.</p>
                        </div>
                    </div>
                    <!-- Background decoration with floating animation -->
                    <div class="position-absolute floating-icon" style="right: -40px; bottom: -40px; opacity: 0.15;">
                        <iconify-icon icon="solar:globus-bold-duotone" style="font-size: 240px; color: white;"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards Section -->
    <div class="row g-4 mb-4">
        @php
            $statConfigs = [
                ['label' => 'TOTAL ALUMNI', 'count' => $stats['total_alumni'], 'trend' => $trends['alumni'], 'icon' => 'solar:users-group-rounded-bold-duotone', 'color' => 'primary', 'chart' => 'alumni'],
                ['label' => 'KOMENTAR', 'count' => $stats['total_komentar'], 'trend' => $trends['komentar'], 'icon' => 'solar:chat-round-dots-bold-duotone', 'color' => 'warning', 'chart' => 'komentar'],
                ['label' => 'TOTAL EVENT', 'count' => $stats['total_event'], 'trend' => $trends['event'], 'icon' => 'solar:calendar-bold-duotone', 'color' => 'success', 'chart' => 'event'],
                ['label' => 'TOTAL LOWONGAN', 'count' => $stats['total_lowongan'], 'trend' => $trends['lowongan'], 'icon' => 'solar:case-minimalistic-bold-duotone', 'color' => 'danger', 'chart' => 'lowongan'],
            ];
        @endphp

        @foreach($statConfigs as $index => $cfg)
        <div class="col-xl-3 col-md-6 animate-box" data-animate="fadeInUp" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
            <div class="card border-0 glass-card stat-card h-100 overflow-hidden shadow-sm">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-light-{{ $cfg['color'] }} text-{{ $cfg['color'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <iconify-icon icon="{{ $cfg['icon'] }}" class="fs-6"></iconify-icon>
                        </div>
                        <div class="trend-badge {{ $cfg['trend'] >= 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $cfg['trend'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($cfg['trend']) }}%
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 fw-600 text-uppercase small ls-1">{{ $cfg['label'] }}</h6>
                        <h3 class="mb-0 fw-800 counter-value">{{ number_format($cfg['count']) }}</h3>
                    </div>
                    <!-- Mini Sparkline for crypto feel -->
                    <div class="sparkline-container position-absolute bottom-0 start-0 w-100" style="height: 50px; opacity: 0.3;">
                        <canvas id="sparkline-{{ $cfg['chart'] }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content & Trends -->
    <div class="row g-4">
        <!-- Main Line Chart (Crypto Style) -->
        <div class="col-lg-8 animate-box" data-animate="fadeInUp" style="animation-delay: 0.5s">
            <div class="card border-0 glass-card chart-card h-100 shadow">
                <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-700 text-dark"><iconify-icon icon="solar:chart-square-bold-duotone" class="me-2 text-primary"></iconify-icon> Performa Ekosistem Alumni</h5>
                        <small class="text-muted">Aktivitas platform dalam 7 hari terakhir</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px; position: relative;">
                        <canvas id="mainCryptoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Quick Actions & Brand -->
        <div class="col-lg-4">
            <div class="row g-4">
                <!-- Quick Actions Glass Card -->
                <div class="col-12 animate-box" data-animate="fadeInUp" style="animation-delay: 0.6s">
                    <div class="card border-0 glass-card shadow-sm h-100 overflow-hidden">
                        <div class="card-header bg-transparent border-0 py-4 px-4">
                            <h5 class="mb-0 fw-700"><iconify-icon icon="solar:bolt-circle-bold-duotone" class="me-2 text-primary"></iconify-icon> Navigasi Cepat</h5>
                        </div>
                        <div class="card-body px-4 pb-4 pt-0">
                            <div class="row g-3">
                                @php
                                    $actions = [
                                        ['route' => 'mudir.komentar.index', 'icon' => 'solar:chat-round-dots-bold-duotone', 'label' => 'Komentar', 'color' => 'warning'],
                                        ['route' => 'mudir.lowongan.index', 'icon' => 'solar:case-minimalistic-bold-duotone', 'label' => 'Lowongan', 'color' => 'danger'],
                                        ['route' => 'mudir.galeri.index', 'icon' => 'solar:gallery-bold-duotone', 'label' => 'Galeri', 'color' => 'info'],
                                        ['route' => 'mudir.event.index', 'icon' => 'solar:calendar-bold-duotone', 'label' => 'Event', 'color' => 'success'],
                                    ];
                                @endphp
                                @foreach($actions as $action)
                                <div class="col-6">
                                    <a href="{{ route($action['route']) }}" class="action-tile p-3 rounded-4 text-center text-decoration-none d-block">
                                        <div class="action-icon bg-light-{{ $action['color'] }} text-{{ $action['color'] }} mb-2 mx-auto rounded-3">
                                            <iconify-icon icon="{{ $action['icon'] }}" class="fs-7"></iconify-icon>
                                        </div>
                                        <span class="d-block small fw-600 text-dark">{{ $action['label'] }}</span>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brand Card -->
                <div class="col-12 animate-box" data-animate="fadeInUp" style="animation-delay: 0.7s">
                    <div class="card border-0 brand-card overflow-hidden shadow-lg position-relative" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); min-height: 200px;">
                        <div class="card-body p-4 text-center text-white d-flex flex-column justify-content-center align-items-center">
                            <div class="brand-glow position-absolute"></div>
                            <div class="bg-white p-3 rounded-circle shadow-lg mb-3">
                                <iconify-icon icon="solar:shield-star-bold-duotone" class="fs-8 text-primary"></iconify-icon>
                            </div>
                            <h5 class="fw-800 mb-1 ls-1">DAR EL-ILMI</h5>
                            <p class="opacity-70 small mb-0">System Authority Level: Mudir</p>
                            <div class="mt-4 glass-badge p-2 px-3 rounded-pill small">
                                <iconify-icon icon="solar:map-point-bold-duotone" class="me-1"></iconify-icon> Payakumbuh, Indonesia
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Root Styles */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    /* Advanced Typography */
    .fw-800 { font-weight: 800; }
    .fw-700 { font-weight: 700; }
    .fw-600 { font-weight: 600; }
    .fw-300 { font-weight: 300; }
    .ls-1 { letter-spacing: 1px; }

    /* Glassmorphism Components */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border) !important;
    }

    .hero-card {
        background: linear-gradient(135deg, #1a73e8 0%, #1557b0 100%);
        box-shadow: 0 15px 35px rgba(26, 115, 232, 0.2);
    }

    /* Animations */
    .animate-box {
        opacity: 0;
        visibility: hidden;
    }
    .animate-box.fadeInUp {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); visibility: hidden; }
        to { opacity: 1; transform: translateY(0); visibility: visible; }
    }

    .floating-icon {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    /* Stat Card Specifics */
    .trend-badge {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .trend-badge.up { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .trend-badge.down { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

    .bg-light-primary { background: rgba(26, 115, 232, 0.1); }
    .bg-light-success { background: rgba(40, 167, 69, 0.1); }
    .bg-light-info { background: rgba(23, 162, 184, 0.1); }
    .bg-light-warning { background: rgba(255, 193, 7, 0.1); }
    .bg-light-danger { background: rgba(220, 53, 69, 0.1); }

    /* Action Tiles */
    .action-tile {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .action-tile:hover {
        transform: translateY(-8px);
        background: #fff;
        box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        border-color: var(--primary-blue);
    }
    .action-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Brand Glow */
    .brand-glow {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
    }
    .glass-badge {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    /* Chart Soft Shadow */
    .chart-card {
        background: #fff;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Staggered Animations
    const animatedElements = document.querySelectorAll('.animate-box');
    animatedElements.forEach((el) => {
        el.classList.add('fadeInUp');
    });

    // 2. Helper for Chart Gradients
    const createGradient = (ctx, colorStart, colorEnd) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    };

    // 3. Main Modern Line Chart
    const mainCtx = document.getElementById('mainCryptoChart').getContext('2d');
    const mainGradient = createGradient(mainCtx, 'rgba(26, 115, 232, 0.4)', 'rgba(26, 115, 232, 0.05)');

    new Chart(mainCtx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Alumni',
                    data: @json($chartData['alumni']),
                    borderColor: '#1a73e8',
                    backgroundColor: mainGradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#1a73e8',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Komentar',
                    data: @json($chartData['komentar']),
                    borderColor: '#ffc107',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { weight: '600' } } },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    padding: 15,
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    usePointStyle: true
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false }, ticks: { font: { weight: '500' } } },
                x: { grid: { display: false }, ticks: { font: { weight: '500' } } }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            }
        }
    });

    // 4. Mini Sparklines for Stats
    const sparklineData = {
        alumni: @json($chartData['alumni']),
        komentar: @json($chartData['komentar']),
        event: @json($chartData['event']),
        lowongan: @json($chartData['lowongan'])
    };

    const sparkColors = {
        alumni: '#1a73e8',
        komentar: '#ffc107',
        event: '#28a745',
        lowongan: '#dc3545'
    };

    Object.keys(sparklineData).forEach(key => {
        const ctx = document.getElementById(`sparkline-${key}`).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: sparklineData[key].map((_, i) => i),
                datasets: [{
                    data: sparklineData[key],
                    borderColor: sparkColors[key],
                    borderWidth: 2,
                    fill: false,
                    tension: 0.5,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    });
});
</script>
@endpush
