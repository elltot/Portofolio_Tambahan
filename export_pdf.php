<?php
// export_pdf.php

// Include TCPDF library
require_once('tcpdf/tcpdf.php');
require 'config.php';

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('YourAppName');
$pdf->SetAuthor('YourName');
$pdf->SetTitle('Data Mahasiswa');

// Add a page
$pdf->AddPage();

// Fetch data from database
$sql = "SELECT mahasiswa.id, mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, fakultas.nama_fakultas 
        FROM mahasiswa INNER JOIN fakultas ON mahasiswa.id_fakultas = fakultas.id_fakultas 
        ORDER BY nim ASC";
$result = mysqli_query($conn, $sql);

$html = '<h1 style="text-align: center;">Data Mahasiswa</h1>';
$html .= '<table cellpadding="5" cellspacing="0" border="1">
            <thead style="background-color: #eee;">
                <tr>
                    <th style="padding: 8px; text-align: center; background-color: #ccc;">No</th>
                    <th style="padding: 8px; text-align: center; background-color: #ccc;">NIM</th>
                    <th style="padding: 8px; text-align: center; background-color: #ccc;">Nama</th>
                    <th style="padding: 8px; text-align: center; background-color: #ccc;">Alamat</th>
                    <th style="padding: 8px; text-align: center; background-color: #ccc;">Fakultas</th>
                </tr>
            </thead>
            <tbody>';

$counter = 1; // Inisialisasi nomor urut
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $counter++ . '</td>
                <td style="text-align: center;">' . $row['nim'] . '</td>
                <td style="text-align: center;">' . $row['nama'] . '</td>
                <td style="text-align: center;">' . $row['alamat'] . '</td>
                <td style="text-align: center;">' . $row['nama_fakultas'] . '</td>
            </tr>';
}
$html .= '</tbody></table>';

// Write HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF as a file (you can also use other output methods)
$pdf->Output('Data_Mahasiswa.pdf', 'D');
?>
