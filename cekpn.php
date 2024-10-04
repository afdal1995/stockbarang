<?php
require 'dbstock.php'; // Ganti dengan path ke file koneksi database Anda

if (isset($_POST['partnumber'])) {
    $partnumber = $conn->real_escape_string($_POST['partnumber']);

    // Query untuk memeriksa apakah partnumber ada di database
    $sql = "SELECT COUNT(*) AS count FROM datastock WHERE partnumber = '$partnumber'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $response = array('exists' => $row['count'] > 0);
    echo json_encode($response);
}

$conn->close();
?>
