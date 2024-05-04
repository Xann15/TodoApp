<?php
// Sambungkan ke database
include 'config.php';

// Ambil data todos dari database
$getTodos = $conn->query("SELECT * FROM todos WHERE user_id = '$userId' ORDER BY id DESC");

// Jika ada todos, kirim HTML kembali
if ($getTodos->num_rows > 0) {
    $html = '';
    while ($fetch = $getTodos->fetch_assoc()) {
        $todoId = $fetch['id'];
        $status = $fetch['status'];
        $isChecked = $status == "true" ? 'checked' : '';

        $html .= '<div id="todo' . $todoId . '" class="todo col-12 col-md-10 rounded-3 d-flex align-items-center p-2 m-auto mb-2" style="height: 50px">';
        $html .= '<div class="checkbox-wrapper col-12 d-flex justify-content-between align-items-center">';
        $html .= '<input type="checkbox" id="cbx' . $todoId . '" class="inp-cbx d-none" data-todoid="' . $todoId . '" ' . $isChecked . '>';
        $html .= '<label for="cbx' . $todoId . '" class="cbx">';
        $html .= '<span>';
        $html .= '<svg viewBox="0 0 12 9" height="9px" width="12px"><polyline points="1 5 4 8 11 1"></polyline></svg>';
        $html .= '</span>';
        $html .= '<span>' . $fetch['todo'] . '</span>';
        $html .= '</label>';
        $html .= '<div class="d-flex my-auto gap-3">';
        $html .= '<input type="time" id="notificationTime" class="form-control p-0 my-auto" style="height: 20px">';
        $html .= '<button type="button" onclick=\'scheduleNotification(' . $fetch["id"] . ')\' class="btn p-0 border-0 todo px-2 m-auto">Set</button>';
        $html .= '<button type="button" id="delete-todo" class="btn p-0 border-0"><i class="bi bi-trash text-danger"></i></button>';
        $html .= '</div></div></div>';
    }
    echo $html;
} else {
    // Jika tidak ada todos, kirim pesan kosong
    echo '<div class="todo mx-auto d-flex py-1 cursor select-none px-5" style="width: fit-content;"><p class="text-center m-auto">No todo items yet.</p></div>';
}
