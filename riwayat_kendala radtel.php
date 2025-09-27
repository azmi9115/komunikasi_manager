<?php
session_start();
include 'db.php';
date_default_timezone_set("Asia/Jakarta");

// Izinkan role teknik dan operasional
// if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['teknik', 'operasional'])) {
//     header("Location: login.php");
//     exit();
// }

// Ambil kendala sebelum hari ini
$today = date('Y-m-d');
$result = $conn->query("SELECT * FROM kendala WHERE DATE(waktu) < '$today' AND unit='SRSJ' ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kendala</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            color: #ecf0f1;
            font-family: 'Roboto', sans-serif;
            padding: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #FFDC00;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: rgba(44, 62, 80, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .button {
            background-color: #FFDC00;
            color: #001f3f;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .button:hover {
            background-color: #ffd700;
            transform: scale(1.05);
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .date-picker-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            max-width: 200px;
            margin: 0 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        /* Kolom Deskripsi (3) dan Keterangan (7) */
        td:nth-child(4),
        th:nth-child(4),
        td:nth-child(6),
        th:nth-child(6) {
            max-width: 300px; /* Atur sesuai kebutuhan */
            white-space: normal; /* Membungkus teks */
            word-wrap: break-word;
            text-align: left;
        }

        /* Kolom lain rata tengah */
        td:not(:nth-child(3)):not(:nth-child(7)),
        th:not(:nth-child(3)):not(:nth-child(7)) {
            text-align: center;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 16px;
            border-bottom: 1px solid #666;
            transition: background-color 0.3s;
        }

        th {
            background-color: #2980b9;
            color: #ecf0f1;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background-color: rgba(255, 220, 0, 0.2);
        }

        .status-belum    { background-color: #3498db; color: white; font-weight: bold; padding: 5px; border-radius: 5px; }
        .status-sedang   { background-color: #e74c3c; color: white; font-weight: bold; padding: 5px; border-radius: 5px; }
        .status-pending  { background-color: #f1c40f; color: black; font-weight: bold; padding: 5px; border-radius: 5px; }
        .status-ditindak { background-color: #2ecc71; color: white; font-weight: bold; padding: 5px; border-radius: 5px; }

        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.8); /* Gelap untuk latar belakang */
            padding-top: 60px;
            animation: fadeIn 0.5s; 
        }

        .modal-content {
            background-color: #ffffff; /* Latar belakang putih untuk konten modal */
            margin: 5% auto; 
            padding: 20px;
            border: 2px solid #2980b9; /* Border berwarna biru */
            border-radius: 10px;
            width: 80%; 
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .modal-content h2 {
            margin-top: 0;
            color: #2980b9; /* Warna judul */
        }

        .modal-input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #2980b9; /* Border berwarna biru */
            border-radius: 5px;
        }

        .modal-button {
            background-color: #2980b9; /* Warna tombol */
            color: white; /* Warna font tombol */
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .modal-button:hover {
            background-color: #1a6f9a; /* Warna tombol saat hover */
        }

        .close {
            color: #2980b9; /* Warna close button */
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #1a6f9a; /* Warna saat hover */
        }

        /* Warna font untuk label di modal */
        .modal-label {
            color: black; /* Warna hitam */
            font-weight: bold; /* Bold */
        }

        /* Animasi untuk modal */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <!-- Library Sort -->
    <script src="https://unpkg.com/tablesort@5.3.0/dist/tablesort.min.js"></script>
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('riwayat-tabel');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function openModal() {
            document.getElementById('dateModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('dateModal').style.display = "none";
        }

        function exportData() {
            const startDate = document.getElementById('startDate').value;

            if (startDate) {
                window.open(`export_excel_radtel.php?start=${startDate}`, '_blank');
                closeModal(); // Close modal after exporting
            } else {
                alert('Silakan pilih tanggal mulai.');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>📁 Riwayat Kendala (Sebelum Hari Ini)</h2>
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" onkeyup="filterTable()" placeholder="Cari di tabel...">
        </div>

        <div class="date-picker-container">
            <button class="button" onclick="openModal()">📥 Ekspor ke PDF</button>
        </div>

        <?php if ($_SESSION['role'] == 'teknik'): ?>
            <a href="dashboard_SRSJ.php" class="button">⬅️ Kembali ke Dashboard</a>
        <?php else: ?>
            <a href="dashboard_SRSJ.php" class="button">⬅️ Kembali ke Dashboard</a>
        <?php endif; ?>

        <table id="riwayat-tabel">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Sumber</th>
                    <th>Deskripsi Gangguan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $statusClass = '';
                        switch ($row['status']) {
                            case 'Laporan Masuk': $statusClass = 'status-belum'; break;
                            case 'Dalam Perbaikan': $statusClass = 'status-sedang'; break;
                            case 'Pending': $statusClass = 'status-pending'; break;
                            case 'Sudah Diperbaiki': $statusClass = 'status-ditindak'; break;
                        }
                    ?>
                    <tr>
                        <td>
                            <?= $row['waktu'] ?>
                            <?php if ($row['status'] === 'Sudah Diperbaiki' && !empty($row['waktu_selesai'])): ?>
                                <br><small style="color: #2ecc71; font-weight: bold;">
                                    Selesai: <?= $row['waktu_selesai'] ?>
                                </small>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['sumber'] ?></td>
                        <td><?= $row['pesan'] ?></td>
                        <td class="<?= $statusClass ?>"><?= $row['status'] ?></td>
                        <td><?= $row['tanggapan_teknik'] ?? '-' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Memilih Tanggal -->
    <div id="dateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Pilih Tanggal untuk Ekspor</h2>
            <label for="startDate" class="modal-label">Tanggal Mulai:</label>
            <input type="date" id="startDate" class="modal-input">
            <button class="modal-button" onclick="exportData()">Ekspor</button>
        </div>
    </div>

    <script>
        new Tablesort(document.getElementById('riwayat-tabel'));
    </script>
</body>
</html>
