<?php
// database.php
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root";        // Ganti dengan nama pengguna database Anda
$password = "";            // Ganti dengan kata sandi database Anda
$dbname = "stockbarang"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
