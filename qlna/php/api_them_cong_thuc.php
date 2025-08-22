<?php
include 'connect.php'; // kết nối CSDL

header('Content-Type: application/json');

// Kiểm tra method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Chỉ hỗ trợ phương thức GET.'
    ]);
    exit;
}

// Lấy tham số từ URL
$title = $_GET['title'] ?? null;
$description = $_GET['description'] ?? '';
$cook_time = $_GET['cook_time'] ?? 0;
$servings = $_GET['servings'] ?? 0;
$difficulty = $_GET['difficulty'] ?? 'easy';
$category_id = $_GET['category_id'] ?? null;
$author_id = $_GET['author_id'] ?? null;
$image_url = $_GET['image_url'] ?? '';
$video_url = $_GET['video_url'] ?? '';
$created_at = date('Y-m-d H:i:s');

// Kiểm tra tham số bắt buộc
if (!$title || !$author_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu tham số bắt buộc: title hoặc author_id.'
    ]);
    exit;
}

// Tạo câu lệnh SQL
$sql = "INSERT INTO cong_thuc_nau_an 
        (title, description, cook_time, servings, difficulty, category_id, author_id, image_url, video_url, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiisissss",
    $title, $description, $cook_time, $servings, $difficulty, $category_id, $author_id, $image_url, $video_url, $created_at
);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Thêm công thức thành công!',
        'recipe_id' => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thêm thất bại: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>