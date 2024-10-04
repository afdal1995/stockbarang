<?php
header('Content-Type: application/json');

// Konfigurasi koneksi database
$host = 'localhost';
$dbname = 'stockbarang';
$username = 'root';
$password = '';

// Membuat koneksi ke database
$mysqli = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($mysqli->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal: ' . $mysqli->connect_error]);
    exit;
}

// Mengambil No dari permintaan POST
$no = isset($_POST['no']) ? $_POST['no'] : '';

// Log No untuk debugging
error_log('Received No: ' . $no);

if (!empty($no)) {
    // Menyiapkan statement SQL untuk mengambil data dari adjust
    $stmt = $mysqli->prepare('SELECT partnumber, qty FROM adjust WHERE no = ?');
    
    if ($stmt) {
        $stmt->bind_param('i', $no);
        $stmt->execute();
        $stmt->bind_result($partnumber, $qty);
        $stmt->fetch();
        $stmt->close();

        if ($partnumber) {
            $stmtDelete = $mysqli->prepare('DELETE FROM adjust WHERE no = ?');
            if ($stmtDelete) {
                $stmtDelete->bind_param('i', $no);
                $stmtDelete->execute();
                $stmtDelete->close();
                
                $stmtUpdate = $mysqli->prepare('UPDATE datastock SET qty = qty - ? WHERE partnumber = ?');
                if ($stmtUpdate) {
                    $stmtUpdate->bind_param('is', $qty, $partnumber);
                    $stmtUpdate->execute();
                    
                    if ($stmtUpdate->affected_rows > 0) {
                        echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus dan qty diperbarui.']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan di datastock untuk mengupdate qty.']);
                    }
                    $stmtUpdate->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement update.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement delete.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan di adjust.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement select.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No tidak valid.']);
}

// Menutup koneksi database
$mysqli->close();
?>
