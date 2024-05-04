<?php

require_once "config.php";

$requestData = json_decode(file_get_contents('php://input'), true);
$subscriptionData = json_encode($requestData['subscription']); // Ubah array menjadi string JSON
$userId = $requestData['userId'];

$conn->query("UPDATE users SET notification_endpoint = '$subscriptionData' WHERE id = '$userId'");

$response = array('success' => true, 'message' => 'Subscription data saved successfully');

// Mengirim respons ke klien
header('Content-Type: application/json');
echo json_encode($response);
