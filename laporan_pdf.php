<?php
session_start();
require 'koneksi.php';
require 'fpdf/fpdf.php';

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    die("Akses ditolak");
}

$user_id = $_SESSION['id'];

/* ===== AMBIL DATA USER ===== */
$user = $conn->prepare("SELECT nama, kelas FROM users WHERE id = ?");
$user->bind_param("i", $user_id);
$user->execute();
$userData = $user->get_result()->fetch_assoc();

/* ===== AMBIL DATA JURNAL ===== */
$jurnal = $conn->prepare("
    SELECT 
        journal_date,
        mood,
        experience,
        feelings,
        response,
        affirmation,
        learned
    FROM journals
    WHERE user_id = ?
    ORDER BY journal_date DESC
");
$jurnal->bind_param("i", $user_id);
$jurnal->execute();
$jurnalData = $jurnal->get_result();


/* ===== AMBIL DATA SELF CONTROL ===== */
$self = $conn->prepare("
    SELECT control_date, skala1, skala2, skala3, skala4, skala5, evaluasi
    FROM self_controls
    WHERE user_id = ?
    ORDER BY control_date DESC
");
$self->bind_param("i", $user_id);
$self->execute();
$selfData = $self->get_result();

/* ===== BUAT PDF ===== */
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

/* ===== HEADER ===== */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'LAPORAN JURNAL & SELF CONTROL',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Nama  : '.$userData['nama'],0,1);
$pdf->Cell(0,8,'Kelas : '.$userData['kelas'],0,1);
$pdf->Ln(5);

/* ===== LAPORAN JURNAL ===== */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'LAPORAN JURNAL',0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'Tanggal',1);
$pdf->Cell(40,8,'Mood',1);
$pdf->Cell(110,8,'experience',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
while ($row = $jurnalData->fetch_assoc()) {
    $pdf->Cell(40,8,$row['journal_date'],1);
    $pdf->Cell(40,8,$row['mood'],1);
    $pdf->MultiCell(110,8,$row['experience'],1);
}

/* ===== HALAMAN BARU ===== */
$pdf->AddPage();

/* ===== LAPORAN SELF CONTROL ===== */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'LAPORAN SELF CONTROL',0,1);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,8,'Tanggal',1);
$pdf->Cell(15,8,'S1',1);
$pdf->Cell(15,8,'S2',1);
$pdf->Cell(15,8,'S3',1);
$pdf->Cell(15,8,'S4',1);
$pdf->Cell(15,8,'S5',1);
$pdf->Cell(75,8,'Evaluasi',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);
while ($row = $selfData->fetch_assoc()) {
    $pdf->Cell(30,8,$row['control_date'],1);
    $pdf->Cell(15,8,$row['skala1'],1);
    $pdf->Cell(15,8,$row['skala2'],1);
    $pdf->Cell(15,8,$row['skala3'],1);
    $pdf->Cell(15,8,$row['skala4'],1);
    $pdf->Cell(15,8,$row['skala5'],1);
    $pdf->MultiCell(75,8,$row['evaluasi'],1);
}

/* ===== FORCE DOWNLOAD ===== */
$filename = "Laporan_".$userData['nama'].".pdf";
$pdf->Output('D', $filename);
exit;
