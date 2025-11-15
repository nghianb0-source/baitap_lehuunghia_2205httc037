<?php
session_start();
require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Xin chào, <?= $_SESSION["username"] ?></span>
        <a href="logout.php" class="btn btn-light">Đăng xuất</a>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Danh sách công việc</h3>
        <a href="add_task.php" class="btn btn-success">+ Thêm công việc</a>
    </div>

    <?php foreach ($tasks as $task): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <h5 class="card-title"><?= $task["title"] ?></h5>
                <p class="text-muted">Hạn: <?= $task["due_date"] ?></p>

                <p><?= nl2br($task["description"]) ?></p>

                <span class="badge bg-secondary"><?= $task["status"] ?></span>

                <div class="mt-3">
                    <a href="edit_task.php?id=<?= $task["id"] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" 
                       href="delete_task.php?id=<?= $task["id"] ?>" 
                       class="btn btn-danger btn-sm">Xóa</a>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

</div>

</body>
</html>
