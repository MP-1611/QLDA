<?php
session_start();
require_once '../connect.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Lấy thông tin từ bảng thong_tin_nguoi_dung và kiểm tra vai trò admin
    $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM thong_tin_nguoi_dung WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash, $role);
        $stmt->fetch();

        if (password_verify($password, $password_hash) && $role === 'admin') {
            // Đăng nhập thành công, lưu thông tin vào session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Email hoặc mật khẩu không đúng, hoặc bạn không có quyền quản trị.";
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
    <title>Đăng nhập Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #FFE0B2; padding: 40px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 350px; text-align: center; }
        h2 { color: #333; margin-bottom: 20px; }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .login-btn { width: 100%; padding: 12px; background-color: #1877f2; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.3s; }
        .login-btn:hover { background-color: #166fe5; }
        .error-message { color: red; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập Admin</h2>
        <form action="login_admin.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Đăng nhập</button>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>