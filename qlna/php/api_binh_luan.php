<?php
include 'connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $comment_id = $_GET['id'] ?? null;

    if (!$comment_id) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu comment_id']);
        exit;
    }

    $sql = "SELECT * FROM binh_luan WHERE comment_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bình luận']);
    }
}
$conn->close();



