<?php
require_once("config.php");

// Ambil data yang dikirimkan melalui metode POST
$inputText = $_POST['inputText'];
$userId = $_POST['userId'];

// Lakukan penambahan data ke dalam database
$query = "INSERT INTO todos (user_id, status, todo) VALUES ('$userId', 'false', '$inputText')";
if ($conn->query($query) === TRUE) {
    // Tampilkan data yang ditambahkan
    echo "<p>" . htmlspecialchars($inputText) . "</p>";
} else {
    echo "Gagal menambahkan data: " . $conn->error;
}

// Tutup koneksi
$conn->close();
