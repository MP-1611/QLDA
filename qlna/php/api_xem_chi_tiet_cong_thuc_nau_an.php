<?php
include 'connect.php';
header('Content-Type: application/json');

$recipe_id = $_GET['id'] ?? null;

if (!$recipe_id) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu recipe_id']);
    exit;
}

// Lấy thông tin công thức
$sql = "SELECT * FROM cong_thuc_nau_an WHERE recipe_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();

if (!$recipe) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy công thức']);
    exit;
}

// Nguyên liệu
$sql = "SELECT ingredient_name, quantity FROM nguyen_lieu WHERE recipe_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe['ingredients'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Các bước
$sql = "SELECT step_number, description, image_url FROM cac_buoc_nau_an WHERE recipe_id=? ORDER BY step_number";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe['steps'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode(['status' => 'success', 'data' => $recipe]);

$conn->close();
