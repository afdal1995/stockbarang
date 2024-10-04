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
    // Mulai transaksi
    $mysqli->begin_transaction();

    try {
        // Menyiapkan statement SQL untuk mengambil data dari partkeluar
        $stmt = $mysqli->prepare('SELECT partnumber, qty FROM partkeluar WHERE no = ?');
        
        if ($stmt) {
            $stmt->bind_param('i', $no);
            $stmt->execute();
            $stmt->bind_result($partnumber, $qty);
            $stmt->fetch();
            $stmt->close();

            if ($partnumber) {
                // Hapus data dari partkeluar
                $stmtDelete = $mysqli->prepare('DELETE FROM partkeluar WHERE no = ?');
                if ($stmtDelete) {
                    $stmtDelete->bind_param('i', $no);
                    $stmtDelete->execute();
                    $stmtDelete->close();
                    
                    // Tambahkan kembali kuantitas ke datastock
                    $stmtUpdate = $mysqli->prepare('UPDATE datastock SET qty = qty + ? WHERE partnumber = ?');
                    if ($stmtUpdate) {
                        $stmtUpdate->bind_param('is', $qty, $partnumber);
                        $stmtUpdate->execute();
                        
                        if ($stmtUpdate->affected_rows > 0) {
                            // Commit transaksi
                            $mysqli->commit();
                            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus dan qty diperbarui.']);
                        } else {
                            throw new Exception('Data tidak ditemukan di datastock untuk mengupdate qty.');
                        }
                        $stmtUpdate->close();
                    } else {
                        throw new Exception('Gagal menyiapkan statement update.');
                    }
                } else {
                    throw new Exception('Gagal menyiapkan statement delete.');
                }
            } else {
                throw new Exception('Data tidak ditemukan di partkeluar.');
            }
        } else {
            throw new Exception('Gagal menyiapkan statement select.');
        }
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $mysqli->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No tidak valid.']);
}

// Menutup koneksi database
$mysqli->close();
?>
