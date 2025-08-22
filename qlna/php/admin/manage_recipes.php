<?php
session_start();
require_once '../connect.php';

// Chỉ cho phép Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

$message = '';
$categories = [];

// Lấy danh mục để hiển thị trong form và filter
$sql_categories = "SELECT category_id, name FROM danh_muc_mon_an ORDER BY name ASC";
$result_categories = $conn->query($sql_categories);
if ($result_categories && $result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Xóa công thức
if (isset($_GET['delete'])) {
    $recipe_id_to_delete = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM cong_thuc_nau_an WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipe_id_to_delete);
    if ($stmt->execute()) {
        $message = "Đã xóa công thức thành công.";
    } else {
        $message = "Lỗi khi xóa: " . $stmt->error;
    }
    $stmt->close();
}

// Lưu cập nhật công thức
if (isset($_POST['update_recipe'])) {
    $recipe_id = (int) $_POST['recipe_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $category_id = (int) $_POST['category_id'];
    $ingredients_input = $_POST['ingredients'];
    $instructions_input = $_POST['instructions'];

    $conn->begin_transaction();
    try {
        // Cập nhật bảng cong_thuc_nau_an
        $sql_update = "UPDATE cong_thuc_nau_an SET title = ?, description = ?, image_url = ?, category_id = ? WHERE recipe_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssii", $title, $description, $image_url, $category_id, $recipe_id);
        if (!$stmt_update->execute()) {
            throw new Exception($stmt_update->error);
        }
        $stmt_update->close();

        // Làm mới nguyên liệu
        $stmt_del_ing = $conn->prepare("DELETE FROM nguyen_lieu WHERE recipe_id = ?");
        $stmt_del_ing->bind_param("i", $recipe_id);
        if (!$stmt_del_ing->execute()) { throw new Exception($stmt_del_ing->error); }
        $stmt_del_ing->close();

        $ingredients_array = explode("\n", $ingredients_input);
        if (!empty($ingredients_array)) {
            $stmt_ins_ing = $conn->prepare("INSERT INTO nguyen_lieu (recipe_id, ingredient_name) VALUES (?, ?)");
            foreach ($ingredients_array as $ing) {
                $ing = trim($ing);
                if ($ing === '') { continue; }
                $stmt_ins_ing->bind_param("is", $recipe_id, $ing);
                if (!$stmt_ins_ing->execute()) { throw new Exception($stmt_ins_ing->error); }
            }
            $stmt_ins_ing->close();
        }

        // Làm mới các bước nấu
        $stmt_del_step = $conn->prepare("DELETE FROM cac_buoc_nau_an WHERE recipe_id = ?");
        $stmt_del_step->bind_param("i", $recipe_id);
        if (!$stmt_del_step->execute()) { throw new Exception($stmt_del_step->error); }
        $stmt_del_step->close();

        $instructions_array = explode("\n", $instructions_input);
        if (!empty($instructions_array)) {
            $stmt_ins_step = $conn->prepare("INSERT INTO cac_buoc_nau_an (recipe_id, step_number, description) VALUES (?, ?, ?)");
            $step_number = 1;
            foreach ($instructions_array as $step_desc) {
                $step_desc = trim($step_desc);
                if ($step_desc === '') { continue; }
                $stmt_ins_step->bind_param("iis", $recipe_id, $step_number, $step_desc);
                if (!$stmt_ins_step->execute()) { throw new Exception($stmt_ins_step->error); }
                $step_number++;
            }
            $stmt_ins_step->close();
        }

        $conn->commit();
        $message = "Đã cập nhật công thức thành công.";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Lỗi khi cập nhật: " . $e->getMessage();
    }
}

// Lấy dữ liệu để hiển thị
$filter_category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;
$query_list = "SELECT r.recipe_id, r.title, r.image_url, r.created_at, c.name AS category_name
               FROM cong_thuc_nau_an r
               LEFT JOIN danh_muc_mon_an c ON r.category_id = c.category_id";
if ($filter_category_id > 0) {
    $query_list .= " WHERE r.category_id = " . $filter_category_id;
}
$query_list .= " ORDER BY r.created_at DESC";
$recipes = [];
$result_list = $conn->query($query_list);
if ($result_list && $result_list->num_rows > 0) {
    while ($row = $result_list->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Lấy công thức cần sửa
$recipe_to_edit = null;
$ingredients_text = '';
$instructions_text = '';
if (isset($_GET['edit'])) {
    $recipe_id_to_edit = (int) $_GET['edit'];
    $stmt_r = $conn->prepare("SELECT recipe_id, title, description, image_url, category_id FROM cong_thuc_nau_an WHERE recipe_id = ?");
    $stmt_r->bind_param("i", $recipe_id_to_edit);
    $stmt_r->execute();
    $res_r = $stmt_r->get_result();
    if ($res_r && $res_r->num_rows > 0) {
        $recipe_to_edit = $res_r->fetch_assoc();

        // Nguyên liệu
        $stmt_ing = $conn->prepare("SELECT ingredient_name FROM nguyen_lieu WHERE recipe_id = ? ORDER BY id ASC");
        $stmt_ing->bind_param("i", $recipe_id_to_edit);
        $stmt_ing->execute();
        $res_ing = $stmt_ing->get_result();
        $ings = [];
        while ($row = $res_ing->fetch_assoc()) { $ings[] = $row['ingredient_name']; }
        $ingredients_text = implode("\n", $ings);
        $stmt_ing->close();

        // Các bước
        $stmt_step = $conn->prepare("SELECT description FROM cac_buoc_nau_an WHERE recipe_id = ? ORDER BY step_number ASC");
        $stmt_step->bind_param("i", $recipe_id_to_edit);
        $stmt_step->execute();
        $res_step = $stmt_step->get_result();
        $steps = [];
        while ($row = $res_step->fetch_assoc()) { $steps[] = $row['description']; }
        $instructions_text = implode("\n", $steps);
        $stmt_step->close();
    }
    $stmt_r->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Công thức</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; margin: 0; padding: 0; color: #333; }
        .header { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px 80px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo-link { height: 60px; display: flex; align-items: center; }
        .header .logo-image { height: 100%; width: auto; }
        .user-actions { font-weight: bold; }
        .container { max-width: 1100px; margin: 40px auto; padding: 20px; background-color: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        .message { margin: 10px 0; font-weight: bold; text-align: center; }
        .success { color: green; }
        .error { color: #e74c3c; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .card { background: #fff8ec; border: 1px solid #f4d4a6; border-radius: 8px; padding: 16px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: bold; }
        .form-group input[type="text"], .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .form-group textarea { height: 110px; }
        .submit-btn { padding: 12px 18px; background-color: #1877f2; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f7f7f7; }
        .actions a { margin-right: 10px; text-decoration: none; color: #1877f2; }
        .actions .delete-link { color: #e74c3c; }
        .topbar { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
        .back-link { display: inline-block; margin-top: 10px; }
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
        <h1>Quản lý Công thức</h1>
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Lỗi') !== false ? 'error' : 'success'; ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="grid">
            <div class="card">
                <div class="topbar">
                    <form method="GET" action="manage_recipes.php">
                        <label for="category_id"><strong>Lọc theo danh mục:</strong></label>
                        <select id="category_id" name="category_id" onchange="this.form.submit()">
                            <option value="0">Tất cả</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['category_id']); ?>" <?php echo $filter_category_id === (int)$cat['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Hình ảnh</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recipes)): ?>
                            <?php foreach ($recipes as $r): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['recipe_id']); ?></td>
                                    <td><?php echo htmlspecialchars($r['title']); ?></td>
                                    <td><?php echo htmlspecialchars($r['category_name']); ?></td>
                                    <td>
                                        <?php if (!empty($r['image_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($r['image_url']); ?>" alt="img" style="height:40px; width:auto;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($r['created_at']); ?></td>
                                    <td class="actions">
                                        <a href="manage_recipes.php?edit=<?php echo htmlspecialchars($r['recipe_id']); ?>">Sửa</a>
                                        |
                                        <a href="manage_recipes.php?delete=<?php echo htmlspecialchars($r['recipe_id']); ?>" class="delete-link" onclick="return confirm('Bạn có chắc chắn muốn xóa công thức này?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Không có công thức nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h2><?php echo $recipe_to_edit ? 'Sửa công thức' : 'Chọn một công thức để chỉnh sửa'; ?></h2>
                <?php if ($recipe_to_edit): ?>
                    <form method="POST" action="manage_recipes.php<?php echo $filter_category_id ? ('?category_id=' . (int)$filter_category_id) : ''; ?>">
                        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_to_edit['recipe_id']); ?>">
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe_to_edit['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category_edit">Danh mục</label>
                            <select id="category_edit" name="category_id" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat['category_id']); ?>" <?php echo (int)$recipe_to_edit['category_id'] === (int)$cat['category_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image_url">URL hình ảnh</label>
                            <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($recipe_to_edit['image_url']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" required><?php echo htmlspecialchars($recipe_to_edit['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ingredients">Nguyên liệu (mỗi dòng một nguyên liệu)</label>
                            <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($ingredients_text); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="instructions">Hướng dẫn (mỗi dòng một bước)</label>
                            <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($instructions_text); ?></textarea>
                        </div>
                        <button type="submit" name="update_recipe" class="submit-btn">Lưu thay đổi</button>
                    </form>
                <?php else: ?>
                    <p>Hãy chọn nút "Sửa" ở danh sách bên trái để chỉnh sửa một công thức.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="back-link">
            <a href="admin_dashboard.php">Quay lại Bảng điều khiển</a>
        </div>
    </div>
</body>
</html>


