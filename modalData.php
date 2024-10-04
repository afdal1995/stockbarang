<?php
header('Content-Type: text/html; charset=utf-8');

// Koneksi ke database
$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root";        // Ganti dengan nama pengguna database Anda
$password = "";            // Ganti dengan kata sandi database Anda
$dbname = "stockbarang"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Menyusun query SQL dengan pencarian
$sql = "SELECT partnumber, OEM, description, location, quantity FROM items";
if (!empty($search)) {
    $search = $conn->real_escape_string($search); // Melindungi terhadap injeksi SQL
    $sql .= " WHERE partnumber LIKE '%$search%' OR OEM LIKE '%$search%' OR description LIKE '%$search%' OR location LIKE '%$search%'";
}

$result = $conn->query($sql);

// Membuat output HTML untuk tabel
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['partnumber']) . "</td>";
        echo "<td>" . htmlspecialchars($row['OEM']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['QTY']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found.</td></tr>";
}

// Menutup koneksi
$conn->close();
?>
