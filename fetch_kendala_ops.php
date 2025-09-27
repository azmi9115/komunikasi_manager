<?php
include "db.php";
date_default_timezone_set("Asia/Jakarta");
$today = date('Y-m-d');
$result = $conn->query("SELECT * FROM kendala WHERE DATE(waktu) = '$today' ORDER BY waktu DESC");

while ($row = $result->fetch_assoc()):
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
?>
<tr>
    <td>
        <?= htmlspecialchars($row['waktu']) ?>
        <?php if ($row['status'] === 'Sudah Diperbaiki' && !empty($row['waktu_selesai'])): ?>
            <br>
            <small style="color: #10b981; font-weight:600;">
                <?= htmlspecialchars($row['waktu_selesai']) ?> - Waktu Selesai
            </small>
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($row['sumber']) ?></td>
    <td><?= htmlspecialchars($row['pesan']) ?></td>
    <td>
        <span class="status-badge <?= $monitorClass ?>">
            <?= htmlspecialchars($row['status']) ?>
        </span>
    </td>
    <td>
        <?= isset($row['tanggapan_teknik']) && $row['tanggapan_teknik'] !== '' 
            ? htmlspecialchars($row['tanggapan_teknik']) 
            : '-' ?>
    </td>
</tr>

<?php endwhile; ?>
