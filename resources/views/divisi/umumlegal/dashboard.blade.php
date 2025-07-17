@extends('layouts.divisi')

@section('content')
<style>
    :root {
        --primary: #2c3e50;
        --primary-light: #3d566e;
        --secondary: #3498db;
        --success: #27ae60;
        --warning: #f39c12;
        --danger: #e74c3c;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --border: #dee2e6;
    }

    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 25px;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Header Section */
    .dashboard-header {
        background: var(--primary);
        color: white;
        padding: 25px 30px;
        grid-column: 1 / -1;
        border-bottom: 4px solid var(--secondary);
    }

    .dashboard-header h1 {
        font-size: 2.2rem;
        margin-bottom: 5px;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    .dashboard-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border: 1px solid var(--border);
        transition: all 0.2s ease;
        height: 150px;
        display: flex;
        flex-direction: column;
    }

    .stat-card:hover {
        border-color: var(--secondary);
    }

    .stat-card.wide {
        grid-column: span 2;
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
    }

    .stat-icon.pending {
        background: var(--warning);
    }

    .stat-icon.approved {
        background: var(--success);
    }

    .stat-icon.rejected {
        background: var(--danger);
    }

    .stat-icon.info {
        background: var(--secondary);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 600;
        color: var(--dark);
        line-height: 1;
        margin: auto 0 5px 0;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
        font-weight: 500;
    }

    .stat-change {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 3px 8px;
    }

    .stat-change.positive {
        color: var(--success);
        background: rgba(39, 174, 96, 0.1);
    }

    .stat-change.negative {
        color: var(--danger);
        background: rgba(231, 76, 60, 0.1);
    }

    /* Activity Section */
    .activity-section {
        background: white;
        padding: 20px;
        border: 1px solid var(--border);
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .activity-item {
        display: flex;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid var(--light-gray);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        color: white;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 500;
        color: var(--dark);
        margin-bottom: 3px;
        font-size: 0.95rem;
    }

    .activity-time {
        font-size: 0.8rem;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        padding: 20px;
        border: 1px solid var(--border);
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .action-btn {
        background: white;
        border: 1px solid var(--border);
        padding: 15px;
        text-decoration: none;
        color: var(--dark);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
        text-align: center;
        height: 100%;
    }

    .action-btn:hover {
        border-color: var(--secondary);
        background: var(--light);
    }

    .action-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        border-radius: 4px;
    }

    .action-text {
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Charts Section */
    .charts-section {
        background: white;
        padding: 20px;
        border: 1px solid var(--border);
        height: 100%;
    }

    .chart-placeholder {
        background: var(--light);
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        font-size: 0.9rem;
        margin-top: 15px;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card.wide {
            grid-column: span 1;
        }
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>DASHBOARD {{ strtoupper($divisi ?? 'divisi') }}</h1>
        <p>Selamat datang kembali. Terakhir login: 05 Jun 2024, 08:45</p>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +12%
                    </div>
                </div>
                <div class="stat-number">15</div>
                <div class="stat-label">MENUNGGU</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon approved">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +8%
                    </div>
                </div>
                <div class="stat-number">42</div>
                <div class="stat-label">DISETUJUI</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon rejected">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i> -3%
                    </div>
                </div>
                <div class="stat-number">5</div>
                <div class="stat-label">DITOLAK</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon info">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +5%
                    </div>
                </div>
                <div class="stat-number">28</div>
                <div class="stat-label">PENGAJUAN</div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="activity-section">
            <h2 class="section-title">
                <i class="fas fa-list" style="color: var(--secondary);"></i>
                AKTIVITAS TERAKHIR
            </h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--success);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Memo #2024-015 (Pengajuan dana proyek Q2) telah disetujui</div>
                        <div class="activity-time"><i class="far fa-clock"></i> 12:45 - 05 Jun 2024</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--warning);">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Memo #2024-016 (Pembelian peralatan kantor) membutuhkan review Anda</div>
                        <div class="activity-time"><i class="far fa-clock"></i> 10:30 - 05 Jun 2024</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--danger);">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Memo #2024-014 (Perjalanan dinas ke Bandung) ditolak - Melebihi budget</div>
                        <div class="activity-time"><i class="far fa-clock"></i> 09:15 - 05 Jun 2024</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--secondary);">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Anda menugaskan review memo #2024-017 kepada Budi Santoso</div>
                        <div class="activity-time"><i class="far fa-clock"></i> 08:45 - 05 Jun 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">
                <i class="fas fa-bolt" style="color: var(--secondary);"></i>
                AKSI CEPAT
            </h2>
            <div class="actions-grid">
                <a href="#" class="action-btn">
                    <div class="action-icon" style="background: var(--warning);">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="action-text">Review Memo</div>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-icon" style="background: var(--success);">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="action-text">Buat Baru</div>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-icon" style="background: var(--primary);">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="action-text">Laporan</div>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-icon" style="background: var(--secondary);">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="action-text">Cari Memo</div>
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <h2 class="section-title">
                <i class="fas fa-chart-line" style="color: var(--secondary);"></i>
                STATISTIK
            </h2>
            <div class="chart-placeholder">
                Grafik Statistik Memo Bulan Ini
            </div>
        </div>
    </div>
</div>
@endsection