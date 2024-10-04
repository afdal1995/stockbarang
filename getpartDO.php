<?php
header('Content-Type: application/json');
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "stockbarang"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah partnumber dikirimkan melalui POST
if (isset($_POST['partnumber'])) {
    $partnumber = trim($_POST['partnumber']); // Menghilangkan spasi di awal dan akhir

    // Menyiapkan dan mengeksekusi query untuk mendapatkan detail
    $stmt = $conn->prepare("SELECT pnsis, Description, Location FROM datastock WHERE partnumber = ?");
    $stmt->bind_param("s", $partnumber);
    $stmt->execute();
    
    // Mengambil hasil
    $stmt->bind_result($pnsis, $description, $location);
    $stmt->fetch();
    
    // Mengecek hasil dan menyiapkan response
    if ($pnsis || $description || $location) {
        echo json_encode([
            'exists' => true,
            'pnsis' => $pnsis,
            'description' => $description,
            'location' => $location
        ]);
    } else {
        echo json_encode(['exists' => false]);
    }
    
    // Menutup statement
    $stmt->close();
}

$conn->close();
?>
