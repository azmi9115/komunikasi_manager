<?php
require('fpdf/fpdf.php');
include 'db.php';

date_default_timezone_set("Asia/Jakarta");

class PDF extends FPDF {
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb-1] == "\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) { if ($i == $j) $i++; }
                else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }

    function Row($data, $widths, $lineHeight = 5) {
        $nb = 0;
        for ($i=0; $i<count($data); $i++) {
            $nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
        }
        $h = $lineHeight * $nb;
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);

        for ($i=0; $i<count($data); $i++) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $lineHeight, $data[$i], 0, 'L');
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }
}

// Ambil tanggal dari parameter GET atau POST
$tanggal = $_GET['start'] ?? $_POST['start'] ?? date('Y-m-d');

// Ambil data dari database
$conn->set_charset("utf8");
$result = $conn->query("
    SELECT * FROM kendala 
    WHERE DATE(waktu) = '$tanggal' 
    AND unit = 'listrik'
    ORDER BY waktu ASC
");

// Buat PDF dalam orientasi portrait
$pdf = new PDF('P','mm','A4'); 
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"LAPORAN HARIAN LISTRIK",0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,"Tanggal: ".date("d-m-Y", strtotime($tanggal)),0,1,'C');
$pdf->Ln(5);

// Header tabel (tanpa kolom Unit)
$pdf->SetFont('Arial','B',9);
$widths = [25, 70, 35, 60]; 
$headers = ['Waktu','Gangguan','Status','Keterangan'];
$pdf->Row($headers, $widths, 6);

// Isi tabel
$pdf->SetFont('Arial','',8);
while ($row = $result->fetch_assoc()) {
    $timeUTC    = date('H:i', strtotime($row['waktu']));
    $gangguan   = $row['pesan'] ?? '-';
    $status     = $row['status'] ?? '-';
    $keterangan = $row['tanggapan_teknik'] ?? '-';

    $pdf->Row([$timeUTC, $gangguan, $status, $keterangan], $widths, 5);
}

// Tanda tangan
$pdf->Ln(15);
$pdf->Cell(63,10,'',0,0,'C');
$pdf->Cell(63,10,'',0,0,'C');
$pdf->Cell(63,10,'Supervisor On Duty',0,1,'C');
$pdf->Ln(20);
$pdf->Cell(63,10,'',0,0,'C');
$pdf->Cell(63,10,'',0,0,'C');
$pdf->Cell(63,10,'Nama Supervisor On Duty',0,1,'C');

// Nama file dinamis
$filename = "Laporan_harian_teknik_" . date("d-m-Y", strtotime($tanggal)) . ".pdf";
$pdf->Output("I", $filename);
?>
