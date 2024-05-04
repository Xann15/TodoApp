<?php
require_once 'config.php';

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];

  // checking if user is already exists in database
  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user is exists
    $userinfo = mysqli_fetch_assoc($result);
    $token = $userinfo['token'];
  } else {
    // user is not exists
    $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $token = $userinfo['token'];
    } else {
      echo "User is not created";
      die();
    }
  }

  // save user data into session
  $_SESSION['user_token'] = $token;
  echo "<script>enableNotif()</script>";
  header("Location: welcome.php");
} else {
  if (!isset($_SESSION['user_token'])) {
    header("Location: index.php");
    die();
  }

  // checking if user is already exists in database
  $sql = "SELECT * FROM users WHERE token ='{$_SESSION['user_token']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user is exists
    $userinfo = mysqli_fetch_assoc($result);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <title>Welcome</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- <img src="<?= $userinfo['picture'] ?>" alt="" width="90px" height="90px">
  <ul>
    <li>Full Name: <?= $userinfo['full_name'] ?></li>
    <li>Email Address: <?= $userinfo['email'] ?></li>
    <li>Gender: <?= $userinfo['gender'] ?></li>
  </ul> -->

  <input type="hidden" name="uid" id="uid" value="<?= $userinfo['id'] ?>">

  <div class="navbar fixed-bottom col-11 col-md-8 col-lg-7 col-xl-6 mx-auto m-3 p-0" style="height: 50px;">
    <div class="col-10 todo">
      <input type="text" id="textInput" placeholder="Tambahkan data...">
    </div>
    <div class="col-2 todo">
      <button type="button" onclick="addTodo()">Tambah</button>
    </div>
  </div>

  <div class="container mb-5 pb-4">
    <div class="title cursor mt-5 gap-2 d-flex justify-content-center">
      <div class="d-flex gap-1 align-items-center">
        <div class="icon">
          <svg width="35" height="35" viewBox="0 -5 20 30">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
          </svg>
        </div>
        <h1 class="text-center">Todo App</h1>
      </div>
      <div onclick="confirmLogout()" class="d-flex cursor align-items-center gap-2 todo p-1" style="height: 45px;">
        <img src="<?= $userinfo['picture'] ?>" alt="" width="35px" height="35px" class="rounded-circle border d-flex m-auto">
        <p class="mb-0 fw-bold"><?= $userinfo['email'] ?></p>
      </div>
      <button onclick="enableNotif()" class="btn rounded-circle todo d-flex justify-content-center border" style="height: 35px;width: 35px">
        <i class="bi bi-bell"></i>
      </button>
      <button onclick="sendNotification()" class="btn rounded-circle todo d-flex justify-content-center border" style="height: 35px;width: 35px">
        <i class="bi bi-bell"></i>
      </button>
    </div>
    <form class="rounded-3 p-3">

      <?php

      $getTodos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
      while ($fetch = $getTodos->fetch_assoc()) :
      ?>
        <div class="todo col-12 col-md-10 rounded-3 p-3 m-auto mb-2">
          <div class="checkbox-wrapper d-flex justify-content-between align-items-center">
            <input style="display: none;" type="checkbox" id="cbx" class="inp-cbx" />
            <label for="cbx" class="cbx">
              <span>
                <svg viewBox="0 0 12 9" height="9px" width="12px">
                  <polyline points="1 5 4 8 11 1"></polyline>
                </svg>
              </span>
              <span><?= $fetch['todo'] ?></span>
            </label>
            <div class="d-flex gap-3">
              <input type="time" id="notificationTime">
              <button type="button" onclick='scheduleNotification(<?= $fetch["id"] ?>)' class="btn p-0 border-0 todo px-2">Set Timer</button>
              <button type="button" id="delete-todo" class="btn p-0 border-0">
                <i class="bi bi-trash text-danger"></i>
              </button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

    </form>
  </div>

  <script>
    function addTodo() {
      var inputText = $("#textInput").val();
      var userId = $('#uid').val();
      // Kirim AJAX request
      $.ajax({
        type: "POST",
        url: "addTodo.php",
        data: {
          inputText: inputText,
          userId: userId

        },
        success: function(response) {

          $("#textInput").val("");
        },
        error: function(xhr, status, error) {
          console.error("Gagal menambahkan data:", error);
        }
      });
    }

    // todos check
    $('#cbx').change(function() {
      var isChecked = $(this).is(':checked');
      var userId = $('#uid').val(); // Anda perlu mengimplementasikan fungsi ini untuk mendapatkan ID pengguna

      // Kirim permintaan AJAX ke server PHP
      $.ajax({
        url: 'update-todo-status.php',
        method: 'POST',
        data: {
          isChecked: isChecked,
          todoId: todoId
        },
        success: function(response) {
          console.log(this.data);
          console.log(response);
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    function confirmLogout() {
      var confirmLogout = confirm("Halo <?= $userinfo['full_name'] ?>, apakah anda ingin logout?");
      if (confirmLogout) {
        window.location.href = "logout.php";
      } else {
        // Tombol cancel ditekan, tidak melakukan apa-apa
      }
    }

    // notification
    navigator.serviceWorker.register("sw.js");

    function enableNotif() {
      Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
          // get service worker
          navigator.serviceWorker.ready.then((sw) => {
            // subscribe
            sw.pushManager.subscribe({
              userVisibleOnly: true,
              applicationServerKey: "BLWKe9pIQa2mHgqh2eI4b_a-XgZFbFyvLqRA3-eUtKehdXtRGuqjIVKfkBmhm8ZtcMF_q0oEPKBVjZyqF9KzTdg"
            }).then((subscription) => {
              console.log(JSON.stringify(subscription));
              sendSubscriptionToServer(subscription, $('#uid').val());
            });
          });
        }
      });
    }

    function sendSubscriptionToServer(subscription, userId) {
      // Combine subscription data and user ID into one object
      var subscriptionData = {
        subscription: subscription,
        userId: userId
      };

      console.log(subscriptionData);

      // Convert combined data to JSON
      var subscriptionJson = JSON.stringify(subscriptionData);

      // Send subscription data to server using AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'save-subscription.php', true);
      xhr.setRequestHeader('Content-type', 'application/json');
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log('Subscription data sent successfully');
        } else {
          console.error('Failed to send subscription data. Status:', xhr.status);
        }
      };
      xhr.onerror = function() {
        console.error('Error sending subscription data');
      };
      xhr.send(subscriptionJson);
    }

    // send notification
    function scheduleNotification(todoId) {
      var notificationTime = $('#notificationTime').val(); // Mengambil nilai waktu dari input
      var userId = $('#uid').val(); // Mengambil nilai user ID dari input lainnya

      // Membuat objek data untuk dikirim ke server
      var data = {
        userId: userId,
        notificationTime: notificationTime,
        todoId: todoId
      };

      console.log(data);

      // Mengirim permintaan ke server
      fetch('notif.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to schedule notification');
          }
          alert('Notification scheduled successfully at ' + notificationTime);
        })
        .catch(error => {
          console.error('Error scheduling notification:', error);
        });
    }
  </script>

</body>

</html>