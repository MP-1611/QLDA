<?php
session_start();
require_once '../connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$users = [];
$report = [];

// Lấy danh sách tất cả người dùng kèm số lượt đánh giá và bình luận của họ
$sql_users = "SELECT 
                u.user_id, 
                u.username, 
                u.email,
                COUNT(DISTINCT d.rating_id) AS rating_count,
                COUNT(DISTINCT b.content) AS comment_count
              FROM 
                Thong_tin_nguoi_dung u
              LEFT JOIN 
                danh_gia d ON u.user_id = d.user_id
              LEFT JOIN
                binh_luan b ON u.user_id = b.user_id
              GROUP BY 
                u.user_id, u.username, u.email
              ORDER BY
                u.user_id ASC";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Lấy báo cáo dữ liệu công thức bao gồm số lượt yêu thích và đánh giá trung bình
$sql_report = "SELECT c.recipe_id, c.title, COUNT(mf.recipe_id) AS like_count, AVG(d.rating_value) AS average_rating
              FROM Cong_thuc_nau_an c
              LEFT JOIN Mon_an_yeu_thich mf ON c.recipe_id = mf.recipe_id
              LEFT JOIN danh_gia d ON c.recipe_id = d.recipe_id
              GROUP BY c.recipe_id, c.title
              ORDER BY like_count DESC, c.title ASC";
$result_report = $conn->query($sql_report);

if ($result_report->num_rows > 0) {
    while ($row = $result_report->fetch_assoc()) {
        $report[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Báo Cáo Dữ Liệu</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .header { background-color: #E67E22; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; }
        .back-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #d32f2f;
        }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #E67E22; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 40px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #FFE0B2; color: #333; }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<div class="header">
    <h1>Báo Cáo Dữ Liệu</h1>
    <a href="admin_dashboard.php" class="back-btn">Quay lại Trang Admin</a>
</div>

<div class="container">
    <h2>Báo Cáo Người Dùng</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Số lượt đánh giá</th>
                <th>Số lượt bình luận</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['rating_count']); ?></td>
                        <td><?php echo htmlspecialchars($user['comment_count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Không có người dùng nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Báo Cáo Dữ Liệu Công Thức</h2>
    <table>
        <thead>
            <tr>
                <th>ID Công thức</th>
                <th>Tên công thức</th>
                <th>Số lượt yêu thích</th>
                <th>Đánh giá trung bình</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($report)): ?>
                <?php foreach ($report as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['recipe_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['like_count']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($row['average_rating'] ?? 0, 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Chưa có dữ liệu về công thức.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>