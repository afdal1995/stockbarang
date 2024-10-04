<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partnumber'])) {
    $partnumber = $_POST['partnumber'];
    $oem = $_POST['oem'];
    $pnsis = $_POST['pnsis'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $qty = $_POST['qty'];
    $tipeitem = $_POST['tipeitem'];

    // Debugging: Cek input data
    error_log("Partnumber: " . $partnumber);
    
    $sqlCheck = "SELECT partnumber FROM datastock WHERE partnumber = ?";
    $stmt = mysqli_prepare($conn, $sqlCheck);
    mysqli_stmt_bind_param($stmt, "s", $partnumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Debugging: Cek apakah ada duplikasi
        error_log("Duplicate partnumber detected");
        echo json_encode(['success' => false, 'message' => 'Part number already exists']);
    } else {
        $sqlInsert = "INSERT INTO datastock (partnumber, oem, pnsis, description, location, qty, tipeitem) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param($stmt, "sssssis", $partnumber, $oem, $pnsis, $description, $location, $qty, $tipeitem);
        if (mysqli_stmt_execute($stmt)) {
            error_log("Item added successfully");
            echo json_encode(['success' => true, 'message' => 'Item added successfully']);
        } else {
            error_log("Failed to add item");
            echo json_encode(['success' => false, 'message' => 'Failed to add item']);
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
