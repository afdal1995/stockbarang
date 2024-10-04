<?php
header('Content-Type: application/json');

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockbarang"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Mendapatkan parameter partnumber
$partnumber = $_GET['partnumber'] ?? '';

if (empty($partnumber)) {
    echo json_encode(['error' => 'Partnumber tidak diberikan']);
    exit;
}

// Sanitasi input
$partnumber = $conn->real_escape_string($partnumber);

// Mencari data partnumber
$sql = $conn->prepare("SELECT oem, description, location FROM datastock WHERE partnumber = ?");
$sql->bind_param("s", $partnumber);
$sql->execute();
$result = $sql->get_result();

// Menyiapkan data default
$data = [
    'oem' => 'No Data',
    'description' => 'No Data',
    'location' => 'No Data'
];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Mengupdate data dengan hasil query jika ditemukan
    $data['oem'] = $row['oem'];
    $data['description'] = $row['description'];
    $data['location'] = $row['location'];
}

// Mengirimkan data sebagai JSON
echo json_encode($data);

$sql->close();
$conn->close();
?>
