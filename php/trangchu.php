<?php
// Bắt đầu session và nhúng file kết nối database
session_start();
require_once 'connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
$is_logged_in = isset($_SESSION['user_id']);
$username = '';

if ($is_logged_in) {
    // Nếu đã đăng nhập, lấy tên người dùng từ database
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username FROM thong_tin_nguoi_dung WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
}

// Lấy danh sách các danh mục món ăn từ database
$categories = [];
$sql_categories = "SELECT category_id, name FROM danh_muc_mon_an";
$result_categories = $conn->query($sql_categories);
if ($result_categories && $result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Xử lý tìm kiếm và lọc theo danh mục
$search_query = "";
$category_id = null;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = trim($_GET['search']);
}

if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

// Lấy danh sách các công thức nấu ăn
$recipes = [];
$sql = "SELECT cong_thuc_nau_an.recipe_id, cong_thuc_nau_an.title, cong_thuc_nau_an.image_url, thong_tin_nguoi_dung.username
        FROM cong_thuc_nau_an
        LEFT JOIN thong_tin_nguoi_dung ON cong_thuc_nau_an.author_id = thong_tin_nguoi_dung.user_id";

$conditions = [];
$params = [];
$param_types = "";

if (!empty($search_query)) {
    // Tách key thành token; dùng REGEXP với ranh giới là khoảng trắng hoặc dấu câu (tránh match trong "Singapore")
    $tokens = preg_split('/\s+/', $search_query);
    foreach ($tokens as $tk) {
        $tk = trim($tk);
        if ($tk === '') { continue; }
        // Escape ký tự regex trong token
        $escaped = preg_quote($tk, '/');
        $pattern = "(^|[[:space:][:punct:]])" . $escaped . "([[:space:][:punct:]]|$)";
        $conditions[] = "(cong_thuc_nau_an.title COLLATE utf8mb4_unicode_ci REGEXP ? OR EXISTS (SELECT 1 FROM nguyen_lieu nl WHERE nl.recipe_id = cong_thuc_nau_an.recipe_id AND nl.ingredient_name COLLATE utf8mb4_unicode_ci REGEXP ?))";
        $params[] = $pattern;
        $params[] = $pattern;
        $param_types .= "ss";
    }
}

if (!empty($category_id)) {
    $conditions[] = "cong_thuc_nau_an.category_id = ?";
    $params[] = $category_id;
    $param_types .= "i";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY cong_thuc_nau_an.created_at DESC LIMIT 24";

$stmt_recipes = $conn->prepare($sql);
if (!empty($params)) {
    $stmt_recipes->bind_param($param_types, ...$params);
}

$stmt_recipes->execute();
$result = $stmt_recipes->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}
$stmt_recipes->close();
$conn->close();

// Ánh xạ theo category_id sang file để tránh lệ thuộc tên hiển thị trong DB
$category_file_map = [
    1 => 'danhmuc/cong_thuc_lau.php',
    2 => 'danhmuc/cong_thuc_nuong.php',
    3 => 'danhmuc/cong_thuc_chien.php',
    4 => 'danhmuc/cong_thuc_xao.php',
    5 => 'danhmuc/cong_thuc_kho.php',
    6 => 'danhmuc/cong_thuc_hap.php',
    7 => 'danhmuc/cong_thuc_chay.php',
    8 => 'danhmuc/cong_thuc_trangmieng.php'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang Chủ</title>
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
            padding: 24px 80px; /* tăng chiều cao navbar */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo-link {
            height: 72px; /* logo lớn hơn một chút */
            display: flex;
            align-items: center;
        }

        .header .logo-image {
            height: 100%;
            width: auto;
        }

        .search-form {
            flex-grow: 1;
            margin: 0; /* center within search-section */
            max-width: 720px; /* keep tight center width */
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-input {
            width: 100%;
            padding: 12px 22px;
            border: 1px solid #dddfe2;
            border-radius: 26px;
            font-size: 18px; /* chữ lớn hơn */
            box-sizing: border-box;
        }

        .search-btn {
            background-color: #1877f2;
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 26px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-btn:hover { background-color: #166fe5; }

        .search-section {
            padding: 16px 0; /* ngay dưới navbar */
            display: flex;
            justify-content: center; /* giữa trang */
        }

        .header .user-actions {
            display: flex;
            align-items: center;
        }
        
        .user-menu-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .username {
            font-weight: bold;
            padding: 8px;
            transition: color 0.3s;
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
            border-radius: 5px;
        }

        .user-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-weight: normal;
        }

        .user-dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        
        .user-dropdown-content.show {
            display: block;
        }

        .header .user-actions .login-btn {
            background-color: #1877f2;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .header .user-actions .login-btn:hover {
            background-color: #166fe5;
        }

        .main-content {
            padding: 40px 50px;
        }

        h1 {
            text-align: center;
        }

        /* CSS đã chỉnh sửa cho danh mục */
        .category-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            padding: 30px 50px;
            background-color: #FFE0B2; /* Màu cam nhạt */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            margin: 20px 50px;
            text-align: center;
        }

        .category-box {
            text-decoration: none;
            color: #333;
            background-color: #FFF5E0; /* Màu cam rất nhạt, gần trắng */
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.2s ease, background-color 0.2s ease;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            aspect-ratio: 1 / 1; /* đảm bảo hình vuông, đồng nhất chiều dài & rộng */
        }

        .category-box:hover {
            transform: translateY(-3px);
            background-color: #f0f0f0;
        }
        
        .recipe-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .recipe-card {
            background: #FFE0B2; /* Màu cam nhạt */
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

        /* Responsive để luôn cân đối 8 ô */
        @media (max-width: 992px) {
            .category-container { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 680px) {
            .category-container { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="trangchu.php" class="logo-link">
            <img src="../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        
        

        <div class="user-actions">
            <?php if ($is_logged_in): ?>
                <div class="user-menu-container">
                    <span class="username" onclick="toggleUserMenu()">
                        Tôi, <?php echo htmlspecialchars($username); ?>!
                    </span>
                    <div id="user-dropdown" class="user-dropdown-content">
                        <a href="ho_so_nguoi_dung.php">Hồ sơ người dùng</a> <a href="logout.php">Đăng xuất</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="dangnhap.php" class="login-btn">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="search-section">
        <form class="search-form" action="trangchu.php" method="get">
            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm món ăn..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit" class="search-btn">Tìm kiếm</button>
        </form>
    </div>
    
    <!-- Recipe List Section moved up -->
    <div class="main-content">
        <h1>Công thức nấu ăn mới nhất</h1>
        <div class="recipe-list">
            <?php if (!empty($recipes)): ?>
                <?php foreach ($recipes as $recipe): ?>
                    <a href="danhmuc/chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>" class="recipe-card">
                        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <div class="card-body">
                            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <p>Tác giả: <?php echo htmlspecialchars($recipe['username']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; font-size: 18px; color: #666;">
                    Không có công thức nào được tìm thấy.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="category-container">
        <?php foreach ($categories as $category): ?>
            <?php
                $category_id_map_key = (int)$category['category_id'];
                $category_name = htmlspecialchars($category['name']);
                $file_name = isset($category_file_map[$category_id_map_key]) ? $category_file_map[$category_id_map_key] : 'trangchu.php';
            ?>
            <a href="<?php echo $file_name; ?>?category_id=<?php echo $category['category_id']; ?>" class="category-box">
                <?php echo $category_name; ?>
            </a>
        <?php endforeach; ?>
    </div>

    

    <script>
        function toggleUserMenu() {
            document.getElementById("user-dropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.username')) {
                const dropdowns = document.getElementsByClassName("user-dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>