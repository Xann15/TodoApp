<?php
require_once("config.php");
require_once("vendor/autoload.php");
$requestData = json_decode(file_get_contents('php://input'), true);
$userId = $requestData['userId'];
$todoId = $requestData['todoId'];
$notificationTime = $requestData['notificationTime'];

$query = $conn->query("SELECT * FROM users WHERE id = '$userId'");
$fetch = $query->fetch_assoc();
$subscription = $fetch['notification_endpoint'];
$fname = $fetch['full_name'];
$mail = $fetch['email'];

$query2 = $conn->query("SELECT * FROM todos WHERE id = '$todoId'");
$fetch2 = $query2->fetch_assoc();
$todo = $fetch2['todo'];

// if ($query) {
//     header('Location: query_' . $subscription . '.php');
// } else {
//     header('Location: else.php');
// }

use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

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
    '{"title":"Todo App" , "body":"Hi ' . $fname . ', jangan lupa ' . $todo . ' ya, di jam ' . $notificationTime . '" , "url":"./?message=123"}',
    ['TTL' => 1000]
);

print_r($report);
