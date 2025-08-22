<?php
session_start();
require_once '../connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = '';
$recipes = [];

// Lấy thông tin người dùng từ database
$stmt_user = $conn->prepare("SELECT username FROM Thong_tin_nguoi_dung WHERE user_id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($username);
$stmt_user->fetch();
$stmt_user->close();

// Lấy danh sách công thức yêu thích của người dùng
$sql_favorites = "SELECT c.recipe_id, c.title, c.image_url, u.username AS author_name 
                  FROM Mon_an_yeu_thich mf
                  JOIN Cong_thuc_nau_an c ON mf.recipe_id = c.recipe_id
                  JOIN Thong_tin_nguoi_dung u ON c.author_id = u.user_id
                  WHERE mf.user_id = ?";
$stmt_favorites = $conn->prepare($sql_favorites);
$stmt_favorites->bind_param("i", $user_id);
$stmt_favorites->execute();
$result_favorites = $stmt_favorites->get_result();
if ($result_favorites->num_rows > 0) {
    while ($row = $result_favorites->fetch_assoc()) {
        $recipes[] = $row;
    }
}
$stmt_favorites->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Công Thức Yêu Thích</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .header { background-color: #E67E22; color: white; padding: 20px; text-align: center; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .recipe-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .recipe-card { background: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; text-decoration: none; color: inherit; transition: transform 0.3s ease; }
        .recipe-card:hover { transform: translateY(-5px); }
        .recipe-card img { width: 100%; height: 200px; object-fit: cover; }
        .recipe-card .card-body { padding: 15px; }
        .recipe-card h3 { margin: 0 0 10px; font-size: 18px; }
        .recipe-card p { margin: 0; font-size: 14px; color: #555; }
        /* CSS mới cho nút Quay lại */
        .back-button-container {
            text-align: right; /* Đẩy nút về phía bên phải */
            margin-bottom: 20px; /* Tạo khoảng trống phía dưới */
        }
        .back-button-container a {
            text-decoration: none;
            background-color: #E67E22;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-button-container a:hover {
            background-color: #d35400;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Công Thức Yêu Thích Của <?php echo htmlspecialchars($username); ?></h1>
</div>

<div class="container">
    <div class="back-button-container">
        <a href="../trangchu.php">Quay lại Trang chủ</a>
    </div>
    
    <div class="recipe-list">
        <?php if (!empty($recipes)): ?>
            <?php foreach ($recipes as $recipe): ?>
                <a href="chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>" class="recipe-card">
                    <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                        <p>Tác giả: <?php echo htmlspecialchars($recipe['author_name']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Bạn chưa thêm công thức nào vào danh sách yêu thích.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>