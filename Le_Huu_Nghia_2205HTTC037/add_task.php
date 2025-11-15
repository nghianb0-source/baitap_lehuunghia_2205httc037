<?php
session_start();
require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $due = $_POST["due_date"];
    $user_id = $_SESSION["user_id"];

    $stmt = $pdo->prepare("INSERT INTO tasks(user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $desc, $due]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm công việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4" style="max-width: 700px;">

    <div class="card shadow p-4">
        <h3 class="mb-3">Thêm công việc</h3>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" required class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Hạn</label>
                <input type="date" name="due_date" class="form-control">
            </div>

            <button class="btn btn-success">Lưu</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>

        </form>
    </div>

</div>
</body>
</html>
