<?php
header('Content-Type: application/json');

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockbarang";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

// Mendapatkan data dari request
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['data']) || empty($input['document'])) {
    echo json_encode(['success' => false, 'error' => 'Data atau document tidak boleh kosong.']);
    exit;
}

$document = $conn->real_escape_string($input['document']);

// Cek apakah document sudah ada di tabel partdo
$checkDocumentQuery = "SELECT COUNT(*) as count FROM partdo WHERE document = '$document'";
$result = $conn->query($checkDocumentQuery);
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'error' => 'Document sudah ada. Proses dibatalkan.']);
    exit;
}

$data = $input['data'];

// Menyimpan data ke database
foreach ($data as $item) {
    $partnumber = $conn->real_escape_string($item['partnumber']);
    $description = $conn->real_escape_string($item['description']);
    $location = $conn->real_escape_string($item['location']);
    $qty = intval($item['qty']); // Pastikan qty adalah integer

    // Ambil data pnsis dan qty dari datastock jika partnumber ada
    $pnsisQuery = "SELECT pnsis, qty FROM datastock WHERE partnumber = '$partnumber'";
    $pnsisResult = $conn->query($pnsisQuery);
    
    if ($pnsisResult->num_rows > 0) {
        $pnsisRow = $pnsisResult->fetch_assoc();
        $partnumberSIS = $conn->real_escape_string($pnsisRow['pnsis']);
        $currentQty = intval($pnsisRow['qty']); // Ambil qty saat ini dari datastock

         // Log current qty sebelum pengurangan
         error_log("Current Qty for $partnumber: $currentQty");
         error_log("Qty to reduce: $qty");
        
        // Cek apakah stok cukup
        if ($currentQty < $qty) {
            echo json_encode(['success' => false, 'error' => 'Stok tidak cukup untuk partnumber: ' . $partnumber]);
            exit;
        }

        // Kurangi qty di datastock
        $newQty = $currentQty - $qty;
        $updateStockQuery = "UPDATE datastock SET qty = $newQty WHERE partnumber = '$partnumber'";
        
        if (!$conn->query($updateStockQuery)) {
            echo json_encode(['success' => false, 'error' => $conn->error]);
            exit;
        }
    } else {
        $partnumberSIS = ''; // Atau bisa disesuaikan jika partnumber tidak ditemukan
    }

    // Insert data ke tabel partdo
    $sql = "INSERT INTO partdo (partnumber, description, location, qty, document, partnumberSIS) VALUES ('$partnumber', '$description', '$location', $qty, '$document', '$partnumberSIS')";

    if (!$conn->query($sql)) {
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan.']);
$conn->close();
?>
