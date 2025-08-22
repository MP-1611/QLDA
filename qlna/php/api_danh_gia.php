<?php
include 'connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $rating_id = $_GET['id'] ?? null;

    if (!$rating_id) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu rating_id']);
        exit;
    }

    $sql = "SELECT * FROM danh_gia WHERE rating_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rating_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy đánh giá']);
    }
}
$conn->close();


