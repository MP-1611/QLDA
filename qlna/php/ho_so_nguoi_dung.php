<?php
session_start();
require_once 'connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = '';
$username = '';
$password_message = '';
$username_message = '';

// Lấy thông tin người dùng từ database
$stmt = $conn->prepare("SELECT username, email FROM Thong_tin_nguoi_dung WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Xử lý khi người dùng gửi form đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Lấy mật khẩu đã băm từ database
    $stmt = $conn->prepare("SELECT password FROM Thong_tin_nguoi_dung WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Xác thực mật khẩu cũ
    if (password_verify($current_password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            // Cập nhật mật khẩu mới (đã được băm)
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE Thong_tin_nguoi_dung SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $new_hashed_password, $user_id);
            if ($stmt->execute()) {
                $password_message = "Đổi mật khẩu thành công!";
            } else {
                $password_message = "Có lỗi xảy ra, vui lòng thử lại.";
            }
            $stmt->close();
        } else {
            $password_message = "Mật khẩu mới và mật khẩu xác nhận không khớp.";
        }
    } else {
        $password_message = "Mật khẩu hiện tại không đúng.";
    }
}

// Xử lý khi người dùng gửi form đổi tên người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_username'])) {
    $new_username = $_POST['new_username'];

    if (!empty($new_username)) {
        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $stmt_check = $conn->prepare("SELECT user_id FROM Thong_tin_nguoi_dung WHERE username = ? AND user_id != ?");
        $stmt_check->bind_param("si", $new_username, $user_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $username_message = "Tên người dùng này đã tồn tại, vui lòng chọn tên khác.";
        } else {
            // Cập nhật tên người dùng mới
            $stmt_update = $conn->prepare("UPDATE Thong_tin_nguoi_dung SET username = ? WHERE user_id = ?");
            $stmt_update->bind_param("si", $new_username, $user_id);
            if ($stmt_update->execute()) {
                $username_message = "Đổi tên người dùng thành công!";
                // Cập nhật lại biến $username để hiển thị trên trang
                $username = $new_username;
            } else {
                $username_message = "Có lỗi xảy ra, vui lòng thử lại.";
            }
            $stmt_update->close();
        }
        $stmt_check->close();
    } else {
        $username_message = "Tên người dùng không được để trống.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hồ sơ người dùng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            position: relative; /* Thêm position relative để đặt nút */
        }
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #1877f2;
            font-weight: bold;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: color 0.3s;
        }
        .back-btn:hover {
            color: #166fe5;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .user-info p {
            font-size: 18px;
            margin: 10px 0;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #166fe5;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <a href="trangchu.php" class="back-btn">← Quay về Trang chủ</a>
        
        <h2>Hồ sơ người dùng</h2>
        <div class="user-info">
            <p><strong>Tên người dùng:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>
        
        <hr>

        <h2>Đổi tên người dùng</h2>
        <form method="POST" action="ho_so_nguoi_dung.php">
            <div class="form-group">
                <label for="new_username">Tên người dùng mới</label>
                <input type="text" id="new_username" name="new_username" required>
            </div>
            <button type="submit" name="change_username" class="btn">Đổi tên</button>
        </form>
        <?php if (!empty($username_message)): ?>
            <p class="message"><?php echo htmlspecialchars($username_message); ?></p>
        <?php endif; ?>

        <hr>

        <h2>Đổi mật khẩu</h2>
        <form method="POST" action="ho_so_nguoi_dung.php">
            <div class="form-group">
                <label for="current_password">Mật khẩu hiện tại</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu mới</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn">Đổi mật khẩu</button>
        </form>
        <?php if (!empty($password_message)): ?>
            <p class="message"><?php echo htmlspecialchars($password_message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>