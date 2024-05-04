<?php
require_once("config.php");
require_once("vendor/autoload.php");

// Ambil daftar notifikasi yang harus dikirim pada waktu sekarang
$currentDateTime = date('Y-m-d H:i:s');
$query = $conn->query("SELECT * FROM scheduled_notifications WHERE notification_time <= '$currentDateTime'");
while ($notification = $query->fetch_assoc()) {
    $userId = $notification['user_id'];

    // Ambil informasi pengguna
    $userQuery = $conn->query("SELECT * FROM users WHERE id = '$userId'");
    $user = $userQuery->fetch_assoc();
    $subscription = $user['notification_endpoint'];
    $fname = $user['full_name'];
    $mail = $user['email'];

    // Kirim notifikasi
    $auth = [
        'VAPID' => [
            'subject' => 'mailto:me@website.com', // can be a mailto: or your website address
            'publicKey' => 'BLWKe9pIQa2mHgqh2eI4b_a-XgZFbFyvLqRA3-eUtKehdXtRGuqjIVKfkBmhm8ZtcMF_q0oEPKBVjZyqF9KzTdg', // (recommended) uncompressed public key P-256 encoded in Base64-URL
            'privateKey' => 'M0GqiHBWLHB12TwSnoVVTxFqo621Z_J1hHSNr7KbcGs', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL 
        ],
    ];

    $webPush = new WebPush($auth);

    $report = $webPush->sendOneNotification(
        Subscription::create(json_decode($subscription, true)),
        '{"title":"Hi ' . $fname . ' " , "body":"your email: ' . $mail . '" , "url":"./?message=123"}',
        ['TTL' => 1000]
    );

    print_r($report);

    // Hapus notifikasi yang sudah dikirim dari database
    $conn->query("DELETE FROM scheduled_notifications WHERE user_id = '$userId'");
}
