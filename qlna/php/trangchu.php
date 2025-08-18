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
    $stmt = $conn->prepare("SELECT username FROM Thong_tin_nguoi_dung WHERE user_id = ?");
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
    $search_query = $_GET['search'];
}

if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

// Lấy danh sách các công thức nấu ăn
$recipes = [];
$sql = "SELECT Cong_thuc_nau_an.recipe_id, Cong_thuc_nau_an.title, Cong_thuc_nau_an.image_url, Thong_tin_nguoi_dung.username
        FROM Cong_thuc_nau_an
        LEFT JOIN Thong_tin_nguoi_dung ON Cong_thuc_nau_an.author_id = Thong_tin_nguoi_dung.user_id";

$conditions = [];
$params = [];
$param_types = "";

if (!empty($search_query)) {
    $conditions[] = "Cong_thuc_nau_an.title LIKE ?";
    $params[] = "%" . $search_query . "%";
    $param_types .= "s";
}

if (!empty($category_id)) {
    $conditions[] = "Cong_thuc_nau_an.category_id = ?";
    $params[] = $category_id;
    $param_types .= "i";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY Cong_thuc_nau_an.created_at DESC LIMIT 10";

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

// Ánh xạ tên danh mục sang tên file
$category_file_map = [
    'Lẩu' => 'danhmuc/cong_thuc_lau.php',
    'Nướng' => 'danhmuc/cong_thuc_nuong.php',
    'Chiên' => 'danhmuc/cong_thuc_chien.php',
    'Xào' => 'danhmuc/cong_thuc_xao.php',
    'Kho' => 'danhmuc/cong_thuc_kho.php',
    'Hấp' => 'danhmuc/cong_thuc_hap.php',
    'Món chay' => 'danhmuc/cong_thuc_chay.php',
    'Tráng miệng' => 'danhmuc/cong_thuc_trangmieng.php'
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
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
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
            padding: 2px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.2s ease, background-color 0.2s ease;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            aspect-ratio: 1 / 1;
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
    </style>
</head>
<body>
    <div class="header">
        <a href="trangchu.php" class="logo-link">
            <img src="../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        
        <form class="search-form" action="trangchu.php" method="get">
            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm món ăn..." value="<?php echo htmlspecialchars($search_query); ?>">
        </form>

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

    <div class="category-container">
        <?php foreach ($categories as $category): ?>
            <?php
                $category_name = htmlspecialchars($category['name']);
                $file_name = isset($category_file_map[$category_name]) ? $category_file_map[$category_name] : 'trangchu.php';
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