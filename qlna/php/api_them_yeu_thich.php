<?php
include 'connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ JSON body hoặc form-data
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id   = $data['user_id'] ?? ($_POST['user_id'] ?? null);
    $recipe_id = $data['recipe_id'] ?? ($_POST['recipe_id'] ?? null);

    if (!$user_id || !$recipe_id) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu user_id hoặc recipe_id']);
        exit;
    }

    // Kiểm tra trùng (user đã lưu rồi thì không cho thêm)
    $sql = "SELECT * FROM mon_an_yeu_thich WHERE user_id=? AND recipe_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $recipe_id);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Món này đã có trong danh sách yêu thích']);
        exit;
    }

    // Thêm mới
    $sql = "INSERT INTO mon_an_yeu_thich (user_id, recipe_id, saved_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $recipe_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào danh sách yêu thích']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi thêm vào danh sách yêu thích']);
    }
}

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
