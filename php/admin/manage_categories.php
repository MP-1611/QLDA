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
$category_to_edit = null;

// Xử lý thêm danh mục mới
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $stmt = $conn->prepare("INSERT INTO danh_muc_mon_an (name) VALUES (?)");
    $stmt->bind_param("s", $category_name);
    if ($stmt->execute()) {
        $message = "Đã thêm danh mục mới thành công!";
    } else {
        $message = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}

// Xử lý cập nhật danh mục
if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $stmt = $conn->prepare("UPDATE danh_muc_mon_an SET name = ? WHERE category_id = ?");
    $stmt->bind_param("si", $category_name, $category_id);
    if ($stmt->execute()) {
        $message = "Đã cập nhật danh mục thành công!";
    } else {
        $message = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}

// Xử lý xóa danh mục
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM danh_muc_mon_an WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    if ($stmt->execute()) {
        $message = "Đã xóa danh mục thành công!";
    } else {
        $message = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}

// Lấy thông tin danh mục cần sửa nếu có yêu cầu
if (isset($_GET['edit'])) {
    $category_id_to_edit = $_GET['edit'];
    $stmt = $conn->prepare("SELECT category_id, name FROM danh_muc_mon_an WHERE category_id = ?");
    $stmt->bind_param("i", $category_id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $category_to_edit = $result->fetch_assoc();
    }
    $stmt->close();
}

// Lấy danh sách danh mục hiện có
$sql = "SELECT category_id, name FROM danh_muc_mon_an ORDER BY name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Danh mục</title>
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
        .form-group input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { padding: 10px 20px; background-color: #1877f2; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.3s; }
        .submit-btn:hover { background-color: #166fe5; }
        .message { margin-top: 15px; text-align: center; font-weight: bold; }
        .success { color: green; }
        .error { color: red; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; color: #555; }
        .action-links a { margin-right: 10px; text-decoration: none; color: #1877f2; }
        .action-links .delete-link { color: #e74c3c; }
        .back-link { display: block; margin-top: 20px; text-align: center; }
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
        <h1>Quản lý Danh mục</h1>
        <?php if ($message): ?>
            <p class="message <?php echo strpos($message, 'Lỗi') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <h2>
            <?php echo $category_to_edit ? 'Sửa Danh mục' : 'Thêm Danh mục mới'; ?>
        </h2>
        <form action="manage_categories.php" method="POST">
            <input type="hidden" name="category_id" value="<?php echo $category_to_edit ? htmlspecialchars($category_to_edit['category_id']) : ''; ?>">
            <div class="form-group">
                <label for="category_name">Tên Danh mục</label>
                <input type="text" id="category_name" name="category_name" required value="<?php echo $category_to_edit ? htmlspecialchars($category_to_edit['name']) : ''; ?>">
            </div>
            <button type="submit" name="<?php echo $category_to_edit ? 'update_category' : 'add_category'; ?>" class="submit-btn">
                <?php echo $category_to_edit ? 'Cập nhật' : 'Thêm Danh mục'; ?>
            </button>
        </form>

        <h2>Danh sách Danh mục</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                            <td>
                                <a href="manage_recipes.php?category_id=<?php echo htmlspecialchars($category['category_id']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </td>
                            <td class="action-links">
                                <a href="manage_categories.php?edit=<?php echo htmlspecialchars($category['category_id']); ?>">Sửa</a> | 
                                <a href="manage_categories.php?delete=<?php echo htmlspecialchars($category['category_id']); ?>" class="delete-link" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Không có danh mục nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="back-link">
            <a href="admin_dashboard.php">Quay lại Bảng điều khiển</a>
        </div>
    </div>
</body>
</html>
