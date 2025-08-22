<?php
include 'connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $favorite_id = $_GET['id'] ?? null;

    if (!$favorite_id) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu favorite_id']);
        exit;
    }

    $sql = "SELECT f.favorite_id, f.user_id, f.recipe_id, f.saved_at,
                   r.title, r.image_url, u.username
            FROM mon_an_yeu_thich f
            JOIN cong_thuc_nau_an r ON f.recipe_id = r.recipe_id
            JOIN thong_tin_nguoi_dung u ON f.user_id = u.user_id
            WHERE f.favorite_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $favorite_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bản ghi yêu thích']);
    }
}
$conn->close();

