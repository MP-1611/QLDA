<?php
// Kết nối cơ sở dữ liệu
include 'connect.php'; // File này nên chứa $conn = new mysqli(...);

header('Content-Type: application/json');

// Câu truy vấn SQL để lấy danh sách công thức
$sql = "SELECT 
            recipe_id, 
            title, 
            description, 
            cook_time, 
            servings, 
            difficulty, 
            category_id, 
            author_id, 
            image_url, 
            video_url, 
            created_at 
        FROM Cong_thuc_nau_an";

$result = $conn->query($sql);

$recipes = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $recipes
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Không tìm thấy công thức nào.'
    ]);
}

$conn->close();
?>
