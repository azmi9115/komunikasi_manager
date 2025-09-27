<?php
include 'db.php';
date_default_timezone_set("Asia/Jakarta");
$today = date('Y-m-d');

// Ambil data kendala khusus unit navigasi
$result = $conn->query("SELECT * FROM kendala WHERE DATE(waktu) = '$today' AND unit='navigasi' ORDER BY waktu DESC");

while ($row = $result->fetch_assoc()) {
    // Tentukan class warna status
    $monitorClass = '';
    switch ($row['status']) {
        case 'Laporan Masuk': 
            $monitorClass = 'status-belum'; 
            break;
        case 'Dalam Perbaikan': 
            $monitorClass = 'status-sedang'; 
            break;
        case 'Pending': 
            $monitorClass = 'status-pending'; 
            break;
        case 'Sudah Diperbaiki': 
            $monitorClass = 'status-ditindak'; 
            break;
    }

    echo "<tr>";
    echo "<td>";
    echo $row['waktu']; // waktu laporan masuk
    if ($row['status'] === 'Sudah Diperbaiki' && !empty($row['waktu_selesai'])) {
        echo "<br><small style='color:black; font-weight:600;'>Selesai: {$row['waktu_selesai']}</small>";
    }
    echo "</td>";
    echo "<td>{$row['sumber']}</td>";
    echo "<td>{$row['pesan']}</td>";

    // Kolom Status (Penting: tambahkan span + class 'status-badge')
    echo "<td><span class='status-badge {$monitorClass}'>{$row['status']}</span></td>";

    // Dropdown untuk ubah status
    echo "<td>
        <form method='GET' action='update_status_navigasi.php'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <select name='status'>
                <option value='Laporan Masuk' " . ($row['status'] == 'Laporan Masuk' ? 'selected' : '') . ">Laporan Masuk</option>
                <option value='Dalam Perbaikan' " . ($row['status'] == 'Dalam Perbaikan' ? 'selected' : '') . ">Dalam Perbaikan</option>
                <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                <option value='Sudah Diperbaiki' " . ($row['status'] == 'Sudah Diperbaiki' ? 'selected' : '') . ">Sudah Diperbaiki</option>
            </select>
            <button type='submit'>Kirim</button>
        </form>
    </td>";

    // Kolom tanggapan teknik + tombol edit
    $escapedTanggapan = htmlspecialchars($row['tanggapan_teknik'] ?? '', ENT_QUOTES);
    echo "<td>
        <div style='margin-bottom:5px;'>" . ($escapedTanggapan ?: "<i>Belum ada tanggapan</i>") . "</div>
        <button onclick=\"openModal('{$row['id']}', '{$escapedTanggapan}')\">Edit</button>
    </td>";

    echo "</tr>";
}
?>
