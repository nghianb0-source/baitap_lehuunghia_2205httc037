<?php
session_start();
require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION["user_id"]]);
$task = $stmt->fetch();

if (!$task) die("Không tìm thấy công việc!");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $due = $_POST["due_date"];
    $status = $_POST["status"];

    $stmt = $pdo->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=?");
    $stmt->execute([$title, $desc, $due, $status, $id]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sửa công việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h3 class="mb-3">Sửa công việc</h3>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" value="<?= $task['title'] ?>" required class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control"><?= $task['description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Hạn</label>
                <input type="date" name="due_date" value="<?= $task['due_date'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="pending" <?= $task['status']=="pending"?"selected":"" ?>>Pending</option>
                    <option value="in_progress" <?= $task['status']=="in_progress"?"selected":"" ?>>In Progress</option>
                    <option value="completed" <?= $task['status']=="completed"?"selected":"" ?>>Completed</option>
                </select>
            </div>

            <button class="btn btn-warning">Cập nhật</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>

        </form>

    </div>
</div>

</body>
</html>
