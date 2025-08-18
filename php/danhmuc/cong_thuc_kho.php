<?php
session_start();
require_once '../connect.php';

$category_id = 5; // ID của danh mục "Kho"

$category_name = "Tất cả công thức";
$recipes = [];

$stmt_cat = $conn->prepare("SELECT name FROM danh_muc_mon_an WHERE category_id = ?");
$stmt_cat->bind_param("i", $category_id);
$stmt_cat->execute();
$stmt_cat->bind_result($name);
if ($stmt_cat->fetch()) {
    $category_name = $name;
}
$stmt_cat->close();

$sql = "SELECT cong_thuc_nau_an.recipe_id, cong_thuc_nau_an.title, cong_thuc_nau_an.image_url, thong_tin_nguoi_dung.username
FROM cong_thuc_nau_an
LEFT JOIN thong_tin_nguoi_dung ON cong_thuc_nau_an.author_id = thong_tin_nguoi_dung.user_id
WHERE cong_thuc_nau_an.category_id = ?
ORDER BY cong_thuc_nau_an.created_at DESC";

$stmt_recipes = $conn->prepare($sql);
$stmt_recipes->bind_param("i", $category_id);
$stmt_recipes->execute();
$result = $stmt_recipes->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}
$stmt_recipes->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Công thức món <?php echo htmlspecialchars($category_name); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #E67E22;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo-link {
            height: 60px;
            display: flex;
            align-items: center;
        }
        .header .logo-image {
            height: 100%;
            width: auto;
        }
        .header .search-form {
            flex-grow: 1;
            margin: 0 30px;
            max-width: 800px;
        }
        .header .search-input {
            width: 100%;
            padding: 10px 20px;
            border: 1px solid #dddfe2;
            border-radius: 20px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .header .back-btn {
            background-color: #FFE0B2;
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .header .back-btn:hover {
            background-color: #FFC080;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #FFE0B2;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .recipe-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }
        .recipe-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .recipe-card .card-body {
            padding: 20px;
        }
        .recipe-card h3 {
            margin-top: 0;
            font-size: 20px;
            color: #1c1e21;
        }
        .recipe-card p {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../trangchu.php" class="logo-link">
            <img src="../../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        <form class="search-form" action="../trangchu.php" method="get">
            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm món ăn...">
        </form>
        <a href="../trangchu.php" class="back-btn">
            ← Quay lại
        </a>
    </div>
    <div class="container">
        <h1>Công thức món <?php echo htmlspecialchars($category_name); ?></h1>
        <div class="recipe-list">
            <?php if (!empty($recipes)): ?>
                <?php foreach ($recipes as $recipe): ?>
                                         <a href="../chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>" class="recipe-card">
                        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <div class="card-body">
                            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <p>Tác giả: <?php echo htmlspecialchars($recipe['username']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có công thức nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>