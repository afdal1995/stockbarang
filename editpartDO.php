<?php
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

    // Menyiapkan dan mengeksekusi query
    $stmt = $conn->prepare("SELECT COUNT(*) FROM datastock WHERE partnumber = ?");
    $stmt->bind_param("s", $partnumber);
    $stmt->execute();
    
    // Mengambil hasil
    $stmt->bind_result($count);
    $stmt->fetch();
    
    // Mengecek hasil
    if ($count > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    
    // Menutup statement
    $stmt->close();
}

$conn->close();
?>
