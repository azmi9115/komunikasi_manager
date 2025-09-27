<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'radtel') {
    header("Location: login.php");
    exit();
}

include "db.php";
date_default_timezone_set("Asia/Jakarta");
$today = date('Y-m-d');
$result = $conn->query("SELECT * FROM kendala WHERE DATE(waktu) = '$today' AND unit='SRSJ' ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard System Recording Switching dan Jaringan - Komunikasi Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fancyBlink {
        0%, 100% {
            background-color: rgba(255, 223, 0, 0.3);
            box-shadow: 0 0 5px rgba(255, 223, 0, 0.5);
            transform: scale(1);
            opacity: 1;
        }
        50% {
            background-color: rgba(255, 223, 0, 0.7);
            box-shadow: 0 0 20px rgba(255, 223, 0, 1);
            transform: scale(1.03);
            opacity: 0.85;
        }
        }

        .blinking {
        animation: fancyBlink 1.2s ease-in-out infinite;
        transition: background-color 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            font-family: 'Inter', 'Arial', sans-serif;
            min-height: 100vh;
            padding: 0;
        }

        /* Header Section */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #FFDC00;
            text-shadow: 0 2px 10px rgba(255, 220, 0, 0.3);
        }

        .header-title .icon {
            font-size: 32px;
            color: #FFDC00;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Main Content */
        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Action Buttons */
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .action-btn {
            background: linear-gradient(135deg, #FFDC00, #FFB800);
            color: #1a1a1a;
            border: none;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(255, 220, 0, 0.3);
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 220, 0, 0.4);
            background: linear-gradient(135deg, #FFE55C, #FFDC00);
        }

        .action-btn i {
            font-size: 16px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #FFDC00;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .table-title {
            font-size: 22px;
            font-weight: 600;
            color: #FFDC00;
        }

        .refresh-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            opacity: 0.7;
        }

        .refresh-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* Table Styling */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
        }

        /* Tabel dengan layout auto agar kolom menyesuaikan isi */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        /* Kolom Deskripsi (3) dan Keterangan (7) */
        td:nth-child(3),
        th:nth-child(3),
        td:nth-child(6),
        th:nth-child(6) {
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
            text-align: left;
        }

        /* Kolom 4 (Monitor Status) */
        th:nth-child(4),
        td:nth-child(4) {
            width: 170px;
            max-width: 170px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        /* Kolom 5 (Status Respon Teknik) */
        th:nth-child(5),
        td:nth-child(5) {
            width: 210px;
            max-width: 210px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        /* Kolom lain rata tengah */
        td:not(:nth-child(3)):not(:nth-child(4)):not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7)),
        th:not(:nth-child(3)):not(:nth-child(4)):not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7)) {
            text-align: center;
        }

        /* Padding, border, dan vertical align */
        td, th {
            padding: 14px;
            border: 1px solid #333;
            vertical-align: top;
        }


        th, td {
            padding: 16px 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }

        th {
            background: linear-gradient(135deg, #0055A4, #003d7a);
            color: #FFDC00;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: scale(1.01);
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .status-belum {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .status-sedang {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .status-ditindak {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        /* Form Elements */
        select, button {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: black;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        select:focus, button:focus {
            outline: none;
            border-color: #FFDC00;
            box-shadow: 0 0 0 2px rgba(255, 220, 0, 0.2);
        }

        button {
            background: linear-gradient(135deg, #4ade80, #16a34a);
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 500;
        }

        button:hover {
            background: linear-gradient(135deg, #22c55e, #15803d);
            transform: translateY(-1px);
        }

        .edit-btn {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #a78bfa, #8b5cf6);
            transform: translateY(-1px);
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
        }

        .modal-content {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            margin: 5% auto;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 90%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content h3 {
            color: #FFDC00;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-content textarea {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-family: inherit;
            font-size: 14px;
            min-height: 120px;
            resize: vertical;
        }

        .modal-content textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-actions button {
            flex: 1;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Logout Link */
        .logout-section {
            position: fixed;
            bottom: 30px;
            right: 30px;
        }

        .logout-link {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logout-link:hover {
            background: rgba(220, 38, 38, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .header-title h1 {
                font-size: 24px;
            }

            .main-content {
                padding: 20px 15px;
            }

            .top-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-container {
                padding: 20px 15px;
            }

            th, td {
                padding: 12px 8px;
                font-size: 12px;
            }

            .logout-section {
                position: static;
                margin: 30px;
                text-align: center;
            }
        }
    </style>

    <audio id="notifikasiSound" src="notifikasi.mp3" preload="auto"></audio>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tablesort/5.2.1/tablesort.min.js"></script>
    <script>
        let lastCount = 0;
        let autoRefresh = true;
        const audio = document.getElementById("notifikasiSound");

        function playSoundRepeated(times) {
            let count = 0;
            const play = () => {
                if (count < times) {
                    audio.currentTime = 0;
                    audio.play().then(() => {
                        count++;
                        setTimeout(play, 1500);
                    }).catch(e => {
                        console.error("Gagal putar suara:", e);
                    });
                }
            };
            play();
        }

        function blinkRow(duration) {
            const row = $("#tabel-kendala tr:first");
            row.addClass("blinking");

            setTimeout(() => {
                row.removeClass("blinking");
            }, duration);
        }


        function openModal(id, tanggapan = '') {
            autoRefresh = false;
            $('#modalId').val(id);
            $('#modalTanggapan').val(tanggapan);
            $('#tanggapanModal').show();
        }

        function closeModal() {
            autoRefresh = true;
            $('#tanggapanModal').hide();
        }

        function loadKendala() {
            if (!autoRefresh) return;

            $.get("fetch_kendala_radtel.php", function(data) {
                $("#tabel-kendala").html(data);

                const currentCount = $("#tabel-kendala tr").length;
                if (lastCount !== 0 && currentCount > lastCount) {
                    playSoundRepeated(5);
                    blinkRow(7000);
                }
                lastCount = currentCount;

                // Refresh tabel sort ulang
                new Tablesort(document.getElementById('mainTable'));

                // 🔄 Panggil updateStats() setelah tabel benar-benar diupdate
                setTimeout(updateStats, 100);
            });
        }



        $(document).ready(function() {
            loadKendala();
            setInterval(loadKendala, 5000);

            updateStats();
            setInterval(updateStats, 5000);

            // Hentikan auto refresh saat user interaksi di dropdown
            $(document).on("focus", "select[name='status']", function() {
                autoRefresh = false;
            });
            $(document).on("blur", "select[name='status']", function() {
                autoRefresh = true;
            });
            
            // PAUSE auto-refresh saat user interaksi di dropdown unit
            $(document).on("focus", "select[name='unit']", function() {
                autoRefresh = false;
                console.log("⏸ Pause refresh - user ubah unit");
            });
            $(document).on("blur", "select[name='unit']", function() {
                autoRefresh = true;
                console.log("▶ Resume refresh");
            });
        });
    </script>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-satellite-dish icon"></i>
                <h1>Dashboard System Recording Switching dan Jaringan</h1>
            </div>
            <div class="header-actions">
                <div class="refresh-indicator">
                    <div class="refresh-dot"></div>
                    <span>Auto Refresh Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Actions -->
        <div class="top-actions">
            <button class="action-btn" onclick="document.getElementById('notifikasiSound').play()">
                <i class="fas fa-volume-up"></i>
                Tes Suara
            </button>
            <a href="riwayat_kendala radtel.php" class="action-btn">
                <i class="fas fa-history"></i>
                Lihat Riwayat Kendala
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number" id="totalKendala">0</div>
                <div class="stat-label">Total Kendala Hari Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="belumDitangani">0</div>
                <div class="stat-label">Laporan Masuk</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="dalamPerbaikan">0</div>
                <div class="stat-label">Dalam Perbaikan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="selesai">0</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">Daftar Kendala Teknik</h2>
                <div class="refresh-indicator">
                    <i class="fas fa-sync-alt" style="animation: spin 2s linear infinite;"></i>
                    <span>Memperbarui setiap 5 detik</span>
                </div>
            </div>

            <div class="table-wrapper">
                <table id="mainTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-clock"></i> Waktu</th>
                            <th><i class="fas fa-exclamation-triangle"></i> Gangguan</th>
                            <th><i class="fas fa-file-alt"></i> Deskripsi</th>
                            <th><i class="fas fa-chart-line"></i> Monitor Status</th>
                            <th><i class="fas fa-tools"></i> Status Respon Teknik</th>
                        
                            <th><i class="fas fa-comment"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-kendala">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                            $monitorClass = '';
                            switch ($row['status']) {
                                case 'Laporan Masuk': $monitorClass = 'status-belum'; break;
                                case 'Dalam Perbaikan': $monitorClass = 'status-sedang'; break;
                                case 'Pending': $monitorClass = 'status-pending'; break;
                                case 'Sudah Diperbaiki': $monitorClass = 'status-ditindak'; break;
                            }
                            ?>
                            <tr>
                                <td><?= date('H:i', strtotime($row['waktu'])) ?></td>
                                <td><?= $row['sumber'] ?></td>
                                <td><?= $row['pesan'] ?></td>
                                <td><span class="status-badge <?= $monitorClass ?>"><?= $row['status'] ?></span></td>
                                <td>
                                    <form method="GET" action="update_status.php" style="display: flex; gap: 5px; align-items: center;">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <select name="status">
                                            <option value="Laporan Masuk" <?= $row['status'] == 'Laporan Masuk' ? 'selected' : '' ?>>Laporan Masuk</option>
                                            <option value="Dalam Perbaikan" <?= $row['status'] == 'Dalam Perbaikan' ? 'selected' : '' ?>>Dalam Perbaikan</option>
                                            <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Sudah Diperbaiki" <?= $row['status'] == 'Sudah Diperbaiki' ? 'selected' : '' ?>>Sudah Diperbaiki</option>
                                        </select>
                                        <button type="submit">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <button class="edit-btn" onclick="openModal('<?= $row['id'] ?>', '<?= htmlspecialchars($row['tanggapan_teknik'] ?? '', ENT_QUOTES) ?>')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="tanggapanModal" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-comment-dots"></i> Edit Tanggapan Teknik</h3>
            <form method="POST" action="tambah_tanggapan radtel.php">
                <input type="hidden" name="id" id="modalId">
                <textarea name="tanggapan_teknik" id="modalTanggapan" placeholder="Tulis tanggapan teknik..." required></textarea>
                <div class="modal-actions">
                    <button type="submit">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" onclick="closeModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logout Section -->
    <div class="logout-section">
        <a href="logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

    <script>
        // Update stats
        function updateStats() {
            const rows = document.querySelectorAll('#tabel-kendala tr');
            let total = rows.length;
            let belum = 0, dalam = 0, selesai = 0;
            
            rows.forEach(row => {
                const statusCell = row.querySelector('.status-badge');
                if (statusCell) {
                    const status = statusCell.textContent.trim();
                    if (status === 'Laporan Masuk') belum++;
                    else if (status === 'Dalam Perbaikan') dalam++;
                    else if (status === 'Sudah Diperbaiki') selesai++;
                }
            });
            
            document.getElementById('totalKendala').textContent = total;
            document.getElementById('belumDitangani').textContent = belum;
            document.getElementById('dalamPerbaikan').textContent = dalam;
            document.getElementById('selesai').textContent = selesai;
        }
        
        // Update stats on page load and refresh
        $(document).ready(function() {
            updateStats();
            setInterval(updateStats, 5000);
        });
    </script>
</body>
</html>