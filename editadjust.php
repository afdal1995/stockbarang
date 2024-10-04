<?php
header('Content-Type: application/json');

// Ambil data POST
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data
$requiredFields = ['id', 'document', 'oldPartnumber', 'newPartnumber', 'oem', 'description', 'location', 'qty'];
$missingFields = array_filter($requiredFields, function($field) use ($data) {
    return !isset($data[$field]) || empty($data[$field]);
});

if (!empty($missingFields)) {
    // Tampilkan field yang hilang untuk debugging
    file_put_contents('log.txt', "Missing fields: " . print_r($missingFields, true) . "\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap', 'missingFields' => $missingFields]);
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockbarang";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Siapkan variabel dari data POST
$id = $conn->real_escape_string($data['id']);
$new_qty = $conn->real_escape_string($data['qty']);
$document = $conn->real_escape_string($data['document']);
$oldPartnumber = $conn->real_escape_string($data['oldPartnumber']);
$newPartnumber = $conn->real_escape_string($data['newPartnumber']);
$oem = $conn->real_escape_string($data['oem']);
$description = $conn->real_escape_string($data['description']);
$location = $conn->real_escape_string($data['location']);

// Mulai transaksi
$conn->begin_transaction();

try {
    // Ambil qty lama dari tabel adjust
    $sql_get_old_qty = "SELECT qty FROM adjust WHERE no='$id'";
    $result = $conn->query($sql_get_old_qty);
    if ($result === FALSE) {
        throw new Exception("Error fetching old qty: " . $conn->error);
    }

    if ($result->num_rows === 0) {
        throw new Exception("Record not found with ID: " . $id);
    }

    $row = $result->fetch_assoc();
    $old_qty = $row['qty'];

    // Update tabel adjust
    $sql_adjust = "UPDATE adjust SET
        document='$document',
        partnumber='$newPartnumber',
        oem='$oem',
        description='$description',
        location='$location',
        qty='$new_qty'
        WHERE no='$id'";

    if (!$conn->query($sql_adjust)) {
        throw new Exception("Error updating adjust: " . $conn->error);
    }

    // Cek apakah partnumber baru ada di tabel datastock
    $sql_check_new_partnumber = "SELECT COUNT(*) FROM datastock WHERE partnumber='$newPartnumber'";
    $result_check_new = $conn->query($sql_check_new_partnumber);
    if ($result_check_new === FALSE) {
        throw new Exception("Error checking new partnumber: " . $conn->error);
    }

    $row_check_new = $result_check_new->fetch_row();
    if ($row_check_new[0] == 0) {
        throw new Exception("Partnumber baru tidak ditemukan di tabel datastock.");
    }

    // Update tabel datastock
    if ($oldPartnumber !== $newPartnumber) {
        // Ambil qty lama dari tabel datastock untuk oldPartnumber
        $sql_get_old_datastock_qty = "SELECT qty FROM datastock WHERE partnumber='$oldPartnumber'";
        $result_old_datastock = $conn->query($sql_get_old_datastock_qty);
        if ($result_old_datastock === FALSE) {
            throw new Exception("Error fetching old datastock qty: " . $conn->error);
        }

        $row_old_datastock = $result_old_datastock->fetch_assoc();
        $old_datastock_qty = $row_old_datastock['qty'];

        // Update qty pada partnumber lama
        $sql_update_old_partnumber = "UPDATE datastock SET qty = qty - $old_qty WHERE partnumber='$oldPartnumber'";
        if (!$conn->query($sql_update_old_partnumber)) {
            throw new Exception("Error updating old partnumber qty: " . $conn->error);
        }

        // Update qty pada partnumber baru
        $sql_update_new_partnumber = "UPDATE datastock SET qty = qty + $new_qty WHERE partnumber='$newPartnumber'";
        if (!$conn->query($sql_update_new_partnumber)) {
            throw new Exception("Error updating new partnumber qty: " . $conn->error);
        }
    }

    // Commit transaksi
    $conn->commit();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Rollback transaksi jika ada kesalahan
    $conn->rollback();
    file_put_contents('log.txt', "Exception: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Tutup koneksi
$conn->close();
?>
