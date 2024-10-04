<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockbarang";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]);
    exit();
}

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

// Periksa apakah data ada
if (!is_array($data) || empty($data)) {
    echo json_encode(["status" => "error", "message" => "No data provided"]);
    exit();
}

// Mulai transaksi
$conn->begin_transaction();

try {
    $all_data_valid = true;
    $error_message = '';

    // Validasi data
    foreach ($data as $item) {

        if (empty($item['document']) || empty($item['partnumber']) || empty($item['oem']) || empty($item['description']) || empty($item['location']) || !is_numeric($item['qty'])) {
            $all_data_valid = false;
            $error_message = 'Data tidak valid. Pastikan semua field terisi dengan benar.';
            break;
        }

        // Validasi partnumber
        $partnumber = $item['partnumber'];
        $sql_check = $conn->prepare("SELECT COUNT(*) FROM datastock WHERE partnumber = ?");
        $sql_check->bind_param("s", $partnumber);
        $sql_check->execute();
        $sql_check->bind_result($count);
        $sql_check->fetch();
        $sql_check->close();

        if ($count == 0) {
            $all_data_valid = false;
            $error_message = 'Partnumber ' . $partnumber . ' tidak ditemukan di database.';
            break;
        }
    }

    if (!$all_data_valid) {
        throw new Exception($error_message);
    }

    // Menyiapkan statement untuk memasukkan data ke tabel adjust
    $stmt = $conn->prepare("INSERT INTO adjust (document, partnumber, oem, description, location, qty) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }

    $inserted_ids = [];
    
    foreach ($data as $item) {
        $stmt->bind_param("sssssi", $item['document'], $item['partnumber'], $item['oem'], $item['description'], $item['location'], $item['qty']);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        // Ambil nomor urut (ID) dari entri yang baru ditambahkan
        $inserted_id = $stmt->insert_id;
        $inserted_ids[] = $item['partnumber']; // Simpan partnumber bukan ID
        
        // Menambahkan kuantitas di tabel stock_barang
        $partnumber = $item['partnumber'];
        $qty = $item['qty'];
        
        // Menyiapkan statement untuk menambah kuantitas
        $stmt_update = $conn->prepare("UPDATE datastock SET qty = qty + ? WHERE partnumber = ?");
        if ($stmt_update === false) {
            throw new Exception("Update statement preparation failed: " . $conn->error);
        }
        $stmt_update->bind_param("is", $qty, $partnumber);
        if (!$stmt_update->execute()) {
            throw new Exception("Update execute failed: " . $stmt_update->error);
        }
        $stmt_update->close();
    }

    $stmt->close();

    // Commit transaksi
    $conn->commit();
    
    // Mengambil semua data yang baru saja ditambahkan untuk dikembalikan ke frontend
    $partnumber_placeholders = implode(',', array_fill(0, count($inserted_ids), '?'));
    $stmt_select = $conn->prepare("SELECT * FROM adjust WHERE partnumber IN ($partnumber_placeholders)");
    $stmt_select->bind_param(str_repeat('s', count($inserted_ids)), ...$inserted_ids);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $data_inserted = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode(["status" => "success", "data" => $data_inserted]);
} catch (Exception $e) {
    // Rollback transaksi jika ada kesalahan
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
