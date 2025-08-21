<?php
session_start();
require_once '../connect.php';

// Kiểm tra xem người dùng đã đăng nhập và có quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM thong_tin_nguoi_dung WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bảng điều khiển Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; margin: 0; padding: 0; color: #333; }
        .header { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px 80px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo-link { height: 60px; display: flex; align-items: center; }
        .header .logo-image { height: 100%; width: auto; }
        .user-actions { font-weight: bold; }
        .container { max-width: 1100px; margin: 40px auto; padding: 20px; background-color: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        .action-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 30px; }
        .action-list a { background-color: #1877f2; color: white; padding: 18px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px; text-align: center; transition: background-color 0.3s ease; }
        .action-list a:hover { background-color: #166fe5; }
    </style>
</head>
<body>
    <div class="header">
        <a href="../trangchu.php" class="logo-link">
            <img src="../../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        <div class="user-actions">
            Xin chào, Admin <?php echo htmlspecialchars($username); ?>!
            <a href="../logout.php">Đăng xuất</a>
        </div>
    </div>
    <div class="container">
        <h1>Bảng điều khiển Admin</h1>
        <div class="action-list">
            <a href="upload_recipe.php">Đăng công thức mới</a>
            <a href="manage_recipes.php">Quản lý công thức</a>
            <a href="manage_categories.php">Quản lý danh mục</a>
            <a href="#">Quản lý người dùng</a>
        </div>
    </div>
</body>
</html>