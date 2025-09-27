<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'operasional') {
    header("Location: login.php");
    exit();
}

include "db.php";
date_default_timezone_set("Asia/Jakarta");
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operasional - Sistem Monitoring</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0a0e27;
            --secondary-dark: #1a1f3a;
            --accent-blue: #2563eb;
            --accent-gold: #f59e0b;
            --success-green: #10b981;
            --warning-yellow: #f59e0b;
            --danger-red: #ef4444;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --card-bg: rgba(30, 41, 59, 0.8);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px 30px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-gold), #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-icon {
            font-size: 32px;
            color: var(--accent-gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .nav-link:hover {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .form-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 600;
            color: var(--accent-gold);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--accent-blue), #3b82f6);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .table-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .table-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
            color: var(--accent-gold);
        }

        .search-container {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-input {
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            width: 250px;
            backdrop-filter: blur(10px);
        }

        .filter-btn {
            padding: 10px 15px;
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 15px;
            border: 1px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.02);
        }

        th {
            background: linear-gradient(135deg, var(--secondary-dark), var(--primary-dark));
            color: var(--accent-gold);
            padding: 18px 15px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--accent-gold);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        td:nth-child(3),
        td:nth-child(5) {
            max-width: 300px;
            text-align: left;
            word-wrap: break-word;
        }

        td:not(:nth-child(3)):not(:nth-child(5)) {
            text-align: center;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }

        tbody tr:hover {
            background: rgba(37, 99, 235, 0.1);
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-belum {
            background: linear-gradient(135deg, var(--accent-blue), #3b82f6);
            color: white;
        }

        .status-sedang {
            background: linear-gradient(135deg, var(--danger-red), #f87171);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, var(--warning-yellow), #fbbf24);
            color: var(--primary-dark);
        }

        .status-ditindak {
            background: linear-gradient(135deg, var(--success-green), #34d399);
            color: white;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            border-top-color: var(--accent-blue);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            box-shadow: var(--shadow-lg);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            border-left: 4px solid var(--success-green);
        }

        .toast.error {
            border-left: 4px solid var(--danger-red);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .search-container {
                flex-direction: column;
                gap: 10px;
            }

            .search-input {
                width: 100%;
            }

            .header-title h1 {
                font-size: 24px;
            }

            .form-card,
            .table-card {
                padding: 20px;
            }
        }

        .refresh-indicator {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 25px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-primary);
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .refresh-indicator.show {
            opacity: 1;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tablesort/5.2.1/tablesort.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-title">
                <i class="fas fa-tachometer-alt header-icon"></i>
                <h1>Dashboard Operasional</h1>
            </div>
            <nav class="nav-links">
                <a href="riwayat_kendala_ops.php" class="nav-link">
                    <i class="fas fa-history"></i>
                    Riwayat Kendala
                </a>
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--danger-red);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number" style="color: var(--danger-red);" id="total-gangguan">0</div>
                <div class="stat-label">Total Gangguan Hari Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--warning-yellow);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number" style="color: var(--warning-yellow);" id="pending-gangguan">0</div>
                <div class="stat-label">Menunggu Tindakan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--success-green);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number" style="color: var(--success-green);" id="selesai-gangguan">0</div>
                <div class="stat-label">Sudah Ditindak</div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-title">
                <i class="fas fa-paper-plane"></i>
                Kirim Gangguan ke Manager Teknik
            </div>
            <form method="POST" action="send.php" id="gangguan-form">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-exclamation-circle"></i>
                        Jenis Gangguan:
                    </label>
                    <input type="text" name="sumber" class="form-input" placeholder="Contoh: Listrik, AC, Jaringan, dll..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-edit"></i>
                        Deskripsi Gangguan:
                    </label>
                    <textarea name="pesan" class="form-textarea" placeholder="Jelaskan detail gangguan yang terjadi..." required></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Laporan
                </button>
            </form>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-list-alt"></i>
                    Daftar Gangguan Fasilitas
                </div>
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Cari gangguan..." id="search-table">
                    <button class="filter-btn" onclick="toggleFilter()">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <button class="filter-btn" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="mainTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-clock"></i> Waktu</th>
                            <th><i class="fas fa-exclamation-triangle"></i> Gangguan</th>
                            <th><i class="fas fa-info-circle"></i> Deskripsi Gangguan</th>
                            <th><i class="fas fa-eye"></i> Monitor Status</th>
                            <th><i class="fas fa-comment"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-kendala-ops">
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px;">
                                <div class="loading-spinner"></div>
                                <div style="margin-top: 15px;">Memuat data...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="refresh-indicator" id="refresh-indicator">
        <div class="loading-spinner"></div>
        <span>Memperbarui data...</span>
    </div>

    <script>
        let refreshInterval;
        let isRefreshing = false;

        function showToast(message, type = 'success') {
            const toast = $(`
                <div class="toast ${type}">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    ${message}
                </div>
            `);
            
            $('body').append(toast);
            setTimeout(() => toast.addClass('show'), 100);
            setTimeout(() => {
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function showRefreshIndicator() {
            $('#refresh-indicator').addClass('show');
        }

        function hideRefreshIndicator() {
            $('#refresh-indicator').removeClass('show');
        }

        function loadKendalaOps() {
            if (isRefreshing) return;
            
            isRefreshing = true;
            showRefreshIndicator();
            
            $.get("fetch_kendala_ops.php")
                .done(function(data) {
                    $("#tabel-kendala-ops").html(data);
                    updateStats();
                    applySearchFilter();
                })
                .fail(function() {
                    showToast('Gagal memuat data. Silakan coba lagi.', 'error');
                })
                .always(function() {
                    isRefreshing = false;
                    hideRefreshIndicator();
                });
        }

        function updateStats() {
            const rows = $('#tabel-kendala-ops tr');
            let total = 0, pending = 0, selesai = 0;
            
            rows.each(function() {
                const status = $(this).find('.status-badge').text().toLowerCase();
                total++;
                
                if (status.includes('pending') || status.includes('belum')) {
                    pending++;
                } else if (status.includes('ditindak') || status.includes('selesai') || status.includes('diperbaiki')) {
                    selesai++;
                }
            });
            
            $('#total-gangguan').text(total);
            $('#pending-gangguan').text(pending);
            $('#selesai-gangguan').text(selesai);
        }

        function refreshData() {
            loadKendalaOps();
            showToast('Data berhasil diperbarui');
        }

        function applySearchFilter() {
            const searchTerm = $('#search-table').val().toLowerCase();
            
            $('#tabel-kendala-ops tr').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(searchTerm));
            });
        }

        function toggleFilter() {
            // Implementasi filter berdasarkan status
            showToast('Fitur filter akan segera tersedia');
        }

        $(document).ready(function() {
            // Load data pertama kali
            loadKendalaOps();
            
            // Auto refresh setiap 5 detik
            refreshInterval = setInterval(loadKendalaOps, 5000);
            
            // Search functionality
            $('#search-table').on('input', applySearchFilter);
            
            // Form submission dengan feedback
            $('#gangguan-form').on('submit', function(e) {
                const btn = $(this).find('.submit-btn');
                const originalText = btn.html();
                
                btn.html('<div class="loading-spinner"></div> Mengirim...');
                btn.prop('disabled', true);
                
                // Reset setelah 2 detik (simulasi)
                setTimeout(() => {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                    showToast('Laporan berhasil dikirim!');
                }, 2000);
            });
            
            // Pause auto-refresh saat user sedang mengetik
            $('#search-table').on('focus', function() {
                clearInterval(refreshInterval);
            }).on('blur', function() {
                refreshInterval = setInterval(loadKendalaOps, 5000);
            });
        });

        // Cleanup saat halaman ditutup
        $(window).on('beforeunload', function() {
            clearInterval(refreshInterval);
        });
    </script>
</body>
</html>