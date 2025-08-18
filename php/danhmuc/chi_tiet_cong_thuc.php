<?php
session_start();
// Đường dẫn đã được sửa để truy cập file connect.php từ thư mục gốc
require_once '../connect.php';

// Kiểm tra xem recipe_id có được truyền qua URL không
if (!isset($_GET['recipe_id']) || !is_numeric($_GET['recipe_id'])) {
    header("Location: ../trangchu.php");
    exit();
}

$recipe_id = $_GET['recipe_id'];

// Lấy thông tin chi tiết của công thức
$recipe_details = [];
$sql_recipe = "SELECT c.title, c.description, c.image_url, u.username, c.created_at
               FROM cong_thuc_nau_an c
               JOIN thong_tin_nguoi_dung u ON c.author_id = u.user_id
               WHERE c.recipe_id = ?";
$stmt_recipe = $conn->prepare($sql_recipe);
$stmt_recipe->bind_param("i", $recipe_id);
$stmt_recipe->execute();
$result_recipe = $stmt_recipe->get_result();
if ($result_recipe->num_rows > 0) {
    $recipe_details = $result_recipe->fetch_assoc();
} else {
    // Không tìm thấy công thức, chuyển hướng về trang chủ
    header("Location: ../trangchu.php");
    exit();
}
$stmt_recipe->close();

// Lấy danh sách nguyên liệu
$ingredients = [];
$sql_ingredients = "SELECT ingredient_name FROM nguyen_lieu WHERE recipe_id = ?";
$stmt_ingredients = $conn->prepare($sql_ingredients);
$stmt_ingredients->bind_param("i", $recipe_id);
$stmt_ingredients->execute();
$result_ingredients = $stmt_ingredients->get_result();
if ($result_ingredients->num_rows > 0) {
    while ($row = $result_ingredients->fetch_assoc()) {
        $ingredients[] = $row['ingredient_name'];
    }
}
$stmt_ingredients->close();

// Lấy các bước nấu ăn
$instructions = [];
$sql_instructions = "SELECT step_number, description FROM cac_buoc_nau_an WHERE recipe_id = ? ORDER BY step_number ASC";
$stmt_instructions = $conn->prepare($sql_instructions);
$stmt_instructions->bind_param("i", $recipe_id);
$stmt_instructions->execute();
$result_instructions = $stmt_instructions->get_result();
if ($result_instructions->num_rows > 0) {
    while ($row = $result_instructions->fetch_assoc()) {
        $instructions[] = $row;
    }
}
$stmt_instructions->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($recipe_details['title']); ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; margin: 0; padding: 0; color: #333; }
        .header { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px 80px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo-link { height: 60px; display: flex; align-items: center; }
        .header .logo-image { height: 100%; width: auto; }
        .user-actions { font-weight: bold; }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; background-color: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .recipe-title { text-align: center; color: #333; margin-bottom: 20px; }
        .recipe-meta { text-align: center; color: #555; margin-bottom: 20px; }
        .recipe-image { width: 100%; height: auto; border-radius: 10px; margin-bottom: 20px; }
        .section-title { font-size: 24px; border-bottom: 2px solid #555; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; }
        .recipe-content p, .recipe-content ul, .recipe-content ol { line-height: 1.6; }
        .recipe-content ul, .recipe-content ol { padding-left: 20px; }
        .back-link { display: block; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <a href="../trangchu.php" class="logo-link">
            <img src="../../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        <div class="user-actions">
            <a href="../trangchu.php">Quay lại</a>
        </div>
    </div>
    <div class="container">
        <h1 class="recipe-title"><?php echo htmlspecialchars($recipe_details['title']); ?></h1>
        <div class="recipe-meta">
            Đăng bởi: <?php echo htmlspecialchars($recipe_details['username']); ?> vào ngày <?php echo htmlspecialchars(date("d/m/Y", strtotime($recipe_details['created_at']))); ?>
        </div>
        <img src="<?php echo htmlspecialchars($recipe_details['image_url']); ?>" alt="<?php echo htmlspecialchars($recipe_details['title']); ?>" class="recipe-image">
        <div class="recipe-content">
            <h2 class="section-title">Mô tả</h2>
            <p><?php echo nl2br(htmlspecialchars($recipe_details['description'])); ?></p>
            <h2 class="section-title">Nguyên liệu</h2>
            <ul>
                <?php foreach ($ingredients as $ingredient): ?>
                    <li><?php echo htmlspecialchars($ingredient); ?></li>
                <?php endforeach; ?>
            </ul>
            <h2 class="section-title">Các bước nấu ăn</h2>
            <ol>
                <?php foreach ($instructions as $instruction): ?>
                    <li><?php echo htmlspecialchars($instruction['description']); ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <div class="back-link">
            <a href="../trangchu.php">Quay lại Trang chủ</a>
        </div>
    </div>
</body>
</html>