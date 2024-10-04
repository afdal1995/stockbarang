<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti jika perlu
$password = ""; // Ganti jika perlu
$dbname = "stockbarang"; // Ganti dengan nama database kamu

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel stockbarang
$sql = "SELECT no, date, document, partnumber, partnumberSIS, description, location, qty, MOno, POno, tipePO FROM partdo";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Mengubah nilai MOno dan POno jika 0
        $row['MOno'] = ($row['MOno'] == 0) ? '' : $row['MOno'];
        $row['POno'] = ($row['POno'] == 0) ? '' : $row['POno'];
        $data[] = $row;
    }
}

$conn->close();

// Kirim data dalam format JSON
echo json_encode(['success' => true, 'data' => $data]);
?>
