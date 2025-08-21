<?php
include 'connect.php';
header('Content-Type: application/json');
// Thông tin cấu hình kết nối
// Câu truy vấn SQL
$sql = "SELECT user_id, username, email, avatar_url, role, status, created_at, last_login FROM Thong_tin_nguoi_dung";

$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode([]);
}

// Đóng kết nối
$conn->close();
?>