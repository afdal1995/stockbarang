<?php
header('Content-Type: application/json');

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockbarang";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

// Query untuk mengambil data dan memformat tanggal serta menambahkan nomor urut
$sql = "SELECT no, date, document, partnumber, oem, description, location, qty FROM partkeluar";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data dari setiap baris
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Tutup koneksi
$conn->close();

// Mengirimkan data dalam format JSON
echo json_encode($data);
?>
