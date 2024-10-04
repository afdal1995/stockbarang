<?php
// Definisikan konstanta untuk koneksi database
define('DB_SERVER', 'localhost'); // Ganti dengan alamat server database Anda
define('DB_USER', 'root'); // Ganti dengan username database Anda
define('DB_PASS', ''); // Ganti dengan password database Anda
define('DB_NAME', 'stockbarang'); // Ganti dengan nama database Anda

// Ambil parameter term dari query string
$term = isset($_GET['term']) ? $_GET['term'] : '';

// Koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mencari partnumber yang sesuai
$query = $conn->prepare("SELECT partnumber, oem, description, location FROM datastock WHERE partnumber LIKE CONCAT('%', ?, '%') LIMIT 10");
$query->bind_param("s", $term);
$query->execute();
$result = $query->get_result();

$results = array();
while ($row = $result->fetch_assoc()) {
    $results[] = array(
        'partnumber' => $row['partnumber'],
        'oem' => $row['oem'],
        'description' => $row['description'],
        'location' => $row['location']
    );
}

// Kembalikan data dalam format JSON
echo json_encode($results);

$query->close();
$conn->close();
?>
