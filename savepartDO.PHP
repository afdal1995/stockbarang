<?php
header('Content-Type: application/json');

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'stockbarang';

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Koneksi database gagal: ' . $conn->connect_error]));
}

// Memastikan semua data yang diperlukan tersedia
if (!isset($_POST['no'], $_POST['partnumber'], $_POST['qty'], $_POST['moNumber'], $_POST['partnumberSIS'], $_POST['description'], $_POST['location'])) {
    die(json_encode(['success' => false, 'error' => 'Data tidak lengkap.']));
}

$no = $_POST['no'];
$partnumber = $_POST['partnumber'];
$qty = $_POST['qty'];
$moNumber = $_POST['moNumber'];

// Jika moNumber kosong, set ke NULL untuk database
$moNumber = empty($moNumber) ? null : $moNumber;

$partnumberSIS = $_POST['partnumberSIS'];
$description = $_POST['description'];
$location = $_POST['location'];

// Log data yang diterima untuk debugging
error_log("Data received: No=$no, Partnumber=$partnumber, QTY=$qty, MONumber=$moNumber, PartNumberSIS=$partnumberSIS, Description=$description, Location=$location");

// Cek apakah kolom SIS, Description, atau Location kosong
if (empty($partnumberSIS) || empty($description) || empty($location)) {
    return json_encode(['success' => false, 'error' => 'Kolom PartNumberSIS, Description, atau Location tidak boleh kosong.']);
}

// Query untuk update
$sql = "UPDATE partdo SET partnumber = ?, qty = ?, MOno = ?, partnumberSIS = ?, description = ?, location = ? WHERE no = ?";
$stmt = $conn->prepare($sql);

// Cek jika pernyataan SQL ada kesalahan
if ($stmt === false) {
    die(json_encode(['success' => false, 'error' => 'Kesalahan pada pernyataan SQL: ' . $conn->error]));
}

// Mengikat parameter (s = string, i = integer)
$stmt->bind_param("siisssi", $partnumber, $qty, $moNumber, $partnumberSIS, $description, $location, $no);

// Eksekusi query dan cek hasilnya
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    // Tambahkan error detail
    $error = $stmt->error;
    error_log("SQL Error: " . $error); // Logging error SQL
    echo json_encode(['success' => false, 'error' => 'Gagal memperbarui data: ' . $error]);
}

$stmt->close();
$conn->close();
?>
