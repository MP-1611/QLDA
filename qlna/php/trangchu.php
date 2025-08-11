<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: dangnhap.php");
    exit();
}

// User is logged in, you can now fetch user data from the database if needed
// For example:
// require_once 'connect.php';
// $user_id = $_SESSION['user_id'];
// $stmt = $conn->prepare("SELECT username FROM Thong_tin_nguoi_dung WHERE user_id = ?");
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $stmt->bind_result($username);
// $stmt->fetch();
// $stmt->close();
// $conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .homepage-container {
            text-align: center;
        }
        .homepage-container a {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container homepage-container">
        <h2>Chào mừng bạn!</h2>
        <p>Bạn đã đăng nhập thành công.</p>
        <a class="link" href="logout.php">Đăng Xuất</a>
    </div>
</body>
</html>