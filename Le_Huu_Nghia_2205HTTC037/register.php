<?php
session_start();
require "db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users(username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $msg = "Tên đăng nhập hoặc email đã tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5" style="max-width: 450px;">
    <div class="card shadow-lg p-4">

        <h3 class="text-center mb-4">Tạo tài khoản</h3>

        <?php if ($msg): ?>
            <div class="alert alert-danger"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email (tùy chọn)</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Đăng ký</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">Đã có tài khoản? Đăng nhập</a>
        </div>

    </div>
</div>
</body>
</html>
