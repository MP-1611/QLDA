<?php
session_start();
require_once '../connect.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

$message = '';
$categories = [];

// Lấy danh sách danh mục
$sql_categories = "SELECT category_id, name FROM danh_muc_mon_an";
$result_categories = $conn->query($sql_categories);
if ($result_categories && $result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients_input = $_POST['ingredients'];
    $instructions_input = $_POST['instructions'];
    $image_url = $_POST['image_url'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];

    // 1. Chèn dữ liệu vào bảng cong_thuc_nau_an
    $sql_recipe = "INSERT INTO cong_thuc_nau_an (title, description, image_url, category_id, author_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt_recipe = $conn->prepare($sql_recipe);
    $stmt_recipe->bind_param("ssssi", $title, $description, $image_url, $category_id, $author_id);
    
    if ($stmt_recipe->execute()) {
        $new_recipe_id = $conn->insert_id; // Lấy ID của công thức vừa được tạo

        // 2. Chèn từng nguyên liệu vào bảng nguyen_lieu
        $ingredients_array = explode("\n", $ingredients_input);
        
        $sql_ingredient = "INSERT INTO nguyen_lieu (recipe_id, ingredient_name) VALUES (?, ?)";
        $stmt_ingredient = $conn->prepare($sql_ingredient);
        
        foreach ($ingredients_array as $ingredient) {
            $ingredient = trim($ingredient);
            if (!empty($ingredient)) {
                $stmt_ingredient->bind_param("is", $new_recipe_id, $ingredient);
                $stmt_ingredient->execute();
            }
        }
        $stmt_ingredient->close();
        
        // 3. Chèn từng bước vào bảng cac_buoc_nau_an
        $instructions_array = explode("\n", $instructions_input);
        $sql_step = "INSERT INTO cac_buoc_nau_an (recipe_id, step_number, description) VALUES (?, ?, ?)";
        $stmt_step = $conn->prepare($sql_step);
        
        $step_number = 1;
        foreach ($instructions_array as $instruction) {
            $instruction = trim($instruction);
            if (!empty($instruction)) {
                $stmt_step->bind_param("iis", $new_recipe_id, $step_number, $instruction);
                $stmt_step->execute();
                $step_number++;
            }
        }
        $stmt_step->close();

        $message = "Đã đăng công thức thành công!";
    } else {
        $message = "Lỗi: " . $stmt_recipe->error;
    }
    $stmt_recipe->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng công thức mới</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; margin: 0; padding: 0; color: #333; }
        .header { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px 80px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo-link { height: 60px; display: flex; align-items: center; }
        .header .logo-image { height: 100%; width: auto; }
        .user-actions { font-weight: bold; }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; background-color: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"], .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .form-group textarea { height: 150px; }
        .submit-btn { width: 100%; padding: 15px; background-color: #1877f2; color: white; border: none; border-radius: 5px; font-size: 18px; font-weight: bold; cursor: pointer; transition: background-color 0.3s; }
        .submit-btn:hover { background-color: #166fe5; }
        .message { margin-top: 15px; text-align: center; font-weight: bold; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <a href="../trangchu.php" class="logo-link">
            <img src="../../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        <div class="user-actions">
            <a href="admin_dashboard.php">Bảng điều khiển</a>
            <a href="../logout.php">Đăng xuất</a>
        </div>
    </div>

    <div class="container">
        <h1>Đăng công thức mới</h1>
        <?php if ($message): ?>
            <p class="message <?php echo strpos($message, 'Lỗi') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>
        <form action="upload_recipe.php" method="POST">
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['category_id']); ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image_url">URL hình ảnh</label>
                <input type="text" id="image_url" name="image_url" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="ingredients">Nguyên liệu</label>
                <textarea id="ingredients" name="ingredients" placeholder="Mỗi nguyên liệu một dòng." required></textarea>
            </div>
            <div class="form-group">
                <label for="instructions">Hướng dẫn</label>
                <textarea id="instructions" name="instructions" placeholder="Mỗi bước một dòng." required></textarea>
            </div>
            <button type="submit" class="submit-btn">Đăng công thức</button>
        </form>
    </div>
</body>
</html>