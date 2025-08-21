<?php
include 'connect.php';
header('Content-Type: application/json');

// Xóa theo favorite_id
$favorite_id = $_GET['id'] ?? ($_POST['id'] ?? null);

if (!$favorite_id) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu favorite_id']);
    exit;
}

$sql = "DELETE FROM mon_an_yeu_thich WHERE favorite_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $favorite_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Đã xoá khỏi danh sách yêu thích']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bản ghi để xoá']);
}

$conn->close();

