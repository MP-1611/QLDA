<?php
// Bắt đầu session
session_start();

// Nhúng file kết nối database
require_once 'connect.php';

$error_message = "";

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Chuẩn bị và thực thi truy vấn SQL để lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT user_id, password_hash FROM Thong_tin_nguoi_dung WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash);
        $stmt->fetch();

        // Kiểm tra mật khẩu
        if (password_verify($password, $password_hash)) {
            // Mật khẩu đúng, lưu user_id vào session và chuyển hướng
            $_SESSION['user_id'] = $user_id;
            
            // Cập nhật thời gian đăng nhập cuối cùng
            $update_stmt = $conn->prepare("UPDATE Thong_tin_nguoi_dung SET last_login = NOW() WHERE user_id = ?");
            $update_stmt->bind_param("i", $user_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Chuyển hướng đến trang chủ
            header("Location: trangchu.php");
            exit();
        } else {
            $error_message = "Mật khẩu không đúng.";
        }
    } else {
        $error_message = "Email không tồn tại.";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Nhập</h2>
        <?php if (!empty($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form action="dangnhap.php" method="post">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <input type="submit" class="submit-btn" value="Đăng Nhập">
        </form>
        <a class="link" href="#">Quên mật khẩu?</a>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #dddfe2;">
        <a class="link link-create-account" href="dangky.php">Tạo tài khoản mới</a>
    </div>
</body>
</html>