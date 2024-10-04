<?php
header('Content-Type: application/json');
$pdo = new PDO('mysql:host=localhost;dbname=stockbarang', 'root', '');

// Debugging: Log untuk memeriksa data yang diterima
error_log("Received POST data: " . print_r($_POST, true));

// Periksa apakah 'partnumber' ada di POST
if (isset($_POST['partnumber']) && !empty($_POST['partnumber'])) {
    $partnumber = $_POST['partnumber'];

    // Debugging: Log untuk memeriksa nilai partnumber
    error_log("Partnumber received: " . $partnumber);

    try {
        // Query untuk mendapatkan data berdasarkan partnumber
        $query = $pdo->prepare("SELECT oem, description, location FROM datastock WHERE partnumber = ?");
        $query->execute([$partnumber]);

        // Ambil hasil query
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['status' => 'success', 'data' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    } catch (Exception $e) {
        // Log exception jika terjadi kesalahan
        error_log("Database query error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memproses permintaan.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Partnumber tidak diberikan']);
}
?>
