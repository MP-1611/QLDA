<?php
require_once 'connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Thong_tin_nguoi_dung (username, email, password_hash, role, status, created_at, last_login) VALUES (?, ?, ?, 'user', 'active', NOW(), NOW())");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        $message = "<p class='success-message'>Đăng ký thành công. Bạn có thể <a href='dangnhap.php'>đăng nhập</a> ngay bây giờ.</p>";
    } else {
        $message = "<p class='error-message'>Lỗi: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Ký Tài Khoản</h2>
        <?php echo $message; ?>
        <form action="dangky.php" method="post">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <input type="submit" class="submit-btn" value="Đăng Ký">
        </form>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #dddfe2;">
        <a class="link link-create-account" href="dangnhap.php">Đã có tài khoản? Đăng nhập</a>
    </div>
</body>
</html>