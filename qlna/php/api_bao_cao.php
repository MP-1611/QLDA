<?php
include 'connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $report_id = $_GET['id'] ?? null;

    if (!$report_id) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu report_id']);
        exit;
    }

    $sql = "SELECT * FROM bao_cao WHERE report_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy báo cáo']);
    }
}
$conn->close();

