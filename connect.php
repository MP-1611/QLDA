<?php
include 'config.php';
header('Content-Type: application/json');
// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "✅ Kết nối MySQL thành công!";
}

// Đừng quên đóng kết nối khi không cần nữa:
// $conn->close();
?>
