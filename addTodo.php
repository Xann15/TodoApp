<?php
require_once("config.php");

// Ambil data yang dikirimkan melalui metode POST
$inputText = $_POST['inputText'];
$userId = $_POST['userId'];

// Lakukan penambahan data ke dalam database
$query = "INSERT INTO todos (user_id, status, todo) VALUES ('$userId', 'false', '$inputText')";
$conn->query($query);


$getTodo = $conn->query("SELECT * FROM  todos WHERE user_id = '$userId' ORDER BY id DESC");
$fetch = $getTodo->fetch_assoc();

while ($fetch = $getTodos->fetch_assoc()) :
    $todoId = $fetch['id'];
    $status = $fetch['status'];
    $isChecked = $status == "true" ? 'checked' : '';
?>
    <div id="todo<?= $todoId ?>" class="todo col-12 col-md-10 rounded-3 d-flex align-items-center p-2 m-auto mb-2" style="height: 50px">
        <div class="checkbox-wrapper col-12 d-flex justify-content-between align-items-center">
            <input type="checkbox" id="cbx<?= $todoId ?>" class="inp-cbx d-none" data-todoid="<?= $todoId ?>" <?= $isChecked ?>>
            <label for="cbx<?= $todoId ?>" class="cbx">
                <span>
                    <svg viewBox="0 0 12 9" height="9px" width="12px">
                        <polyline points="1 5 4 8 11 1"></polyline>
                    </svg>
                </span>
                <span><?= $fetch['todo'] ?></span>
            </label>
            <div class="d-flex my-auto gap-3">
                <input type="time" id="notificationTime" class="form-control p-0 my-auto" style="height: 20px">
                <button type="button" onclick='scheduleNotification(<?= $fetch["id"] ?>)' class="btn p-0 border-0 todo px-2 m-auto">Set</button>
                <form action="" method="post">
                    <button type="submit" name="delete-todo" class="btn p-0 border-0">
                        <input type="hidden" name="todoId" value="<?= $fetch['id'] ?>">
                        <i class="bi bi-trash text-danger"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php
endwhile;
