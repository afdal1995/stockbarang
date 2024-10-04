<?php
session_start();
header('Content-Type: application/json'); // Pastikan header ini ada

$correctPassword = '27102020'; // Password yang benar

$response = [
    'status' => ($_POST['password'] === $correctPassword) ? 'success' : 'error',
    'message' => ($_POST['password'] === $correctPassword) ? '' : 'Password salah!'
];

echo json_encode($response);
?>
