<?php
// Ambil data dari permintaan POST
$isChecked = isset($_POST['isChecked']) ? $_POST['isChecked'] : false;
$todoId = isset($_POST['todoId']) ? $_POST['todoId'] : null;

// Lakukan update status todo berdasarkan nilai checkbox dan ID pengguna
require_once "config.php"; // Sesuaikan dengan file konfigurasi database Anda

// Lakukan query update status todo di database
$query = $conn->query("UPDATE todos SET status = '$isChecked' WHERE id = '$todoId'");

// Periksa apakah query berhasil atau tidak
if ($query) {
    $response = array('success' => true, 'message' => 'Todo status updated successfully');
} else {
    $response = array('success' => false, 'message' => 'Failed to update todo status');
}

// Mengirim respons ke klien
header('Content-Type: application/json');
echo json_encode($response);
