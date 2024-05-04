<?php
require_once("config.php");
require_once("vendor/autoload.php");

// Ambil data dari permintaan POST
$requestData = json_decode(file_get_contents('php://input'), true);
$userId = $requestData['userId'];
$notificationTime = $requestData['notificationTime'];
$todoId = $requestData['todoId'];

// Lakukan validasi data
if (!empty($userId) && !empty($notificationTime)) {

    $cek = $conn->query("SELECT * FROM scheduled_notifications WHERE user_id = '$userId' AND  todo_id = '$todoId'");

    if ($cek->num_rows > 0) {
        $conn->query("UPDATE scheduled_notifications SET notification_time = '$notificationTime'");
    } else {
        $sql = "INSERT INTO scheduled_notifications (user_id, notification_time, todo_id) VALUES ('$userId', '$notificationTime', '$todoId')";
        $result = $conn->query($sql);
    }

    // Lakukan penyimpanan waktu notifikasi ke database atau penyimpanan lainnya
    // Misalnya, simpan waktu notifikasi ke dalam tabel scheduled_notifications

    // Berhasil
    $response = array('success' => true, 'message' => 'Notifikasi berhasil dijadwalkan');
} else {
    // Gagal
    $response = array('success' => false, 'message' => 'Data tidak lengkap');
}

// Mengirim respons ke klien
header('Content-Type: application/json');
echo json_encode($response);
