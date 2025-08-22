<?php
session_start();
require_once '../connect.php';

// Kiểm tra kết nối CSDL
if (!$conn) {
    die("Lỗi kết nối CSDL: Vui lòng kiểm tra lại file connect.php và đảm bảo máy chủ MySQL đã chạy.");
}

if (!isset($_GET['recipe_id']) || !is_numeric($_GET['recipe_id'])) {
    header("Location: ../trangchu.php");
    exit();
}

$recipe_id = $_GET['recipe_id'];
$is_logged_in = isset($_SESSION['user_id']);
$is_favorited = false;
$user_id = null;
$error_message = '';
$user_rating = 0; // Đánh giá của người dùng hiện tại, mặc định là 0
$average_rating = 0; // Điểm trung bình

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    
    // Xử lý POST request để thêm/xóa yêu thích
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
        $action = $_POST['action'];
        $recipe_id_post = $_POST['recipe_id'];

        if ($action === 'add') {
            // Thêm vào yêu thích
            $sql_insert = "INSERT INTO Mon_an_yeu_thich (user_id, recipe_id, saved_at) VALUES (?, ?, NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $user_id, $recipe_id_post);
            $stmt_insert->execute();
            $stmt_insert->close();
        } elseif ($action === 'remove') {
            // Bỏ yêu thích
            $sql_delete = "DELETE FROM Mon_an_yeu_thich WHERE user_id = ? AND recipe_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("ii", $user_id, $recipe_id_post);
            $stmt_delete->execute();
            $stmt_delete->close();
        }
        
        header("Location: chi_tiet_cong_thuc.php?recipe_id=" . $recipe_id_post);
        exit();
    }

    // Xử lý POST request để thêm bình luận
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comment_text'])) {
        $comment_text = trim($_POST['comment_text']);
        if (!empty($comment_text)) {
            $sql_comment = "INSERT INTO binh_luan (user_id, recipe_id, content, created_at) VALUES (?, ?, ?, NOW())";
            $stmt_comment = $conn->prepare($sql_comment);
            $stmt_comment->bind_param("iis", $user_id, $recipe_id, $comment_text);
            $stmt_comment->execute();
            $stmt_comment->close();
            
            header("Location: chi_tiet_cong_thuc.php?recipe_id=" . $recipe_id);
            exit();
        } else {
            $error_message = "Bình luận không được để trống!";
        }
    }
    
    // Xử lý POST request để thêm/cập nhật đánh giá
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['rating'])) {
        $rating = intval($_POST['rating']);
        if ($rating >= 1 && $rating <= 5) {
            // Kiểm tra xem người dùng đã đánh giá trước đó chưa
            $sql_check_rating = "SELECT rating_id FROM danh_gia WHERE user_id = ? AND recipe_id = ?";
            $stmt_check = $conn->prepare($sql_check_rating);
            $stmt_check->bind_param("ii", $user_id, $recipe_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                // Cập nhật đánh giá hiện có
                $sql_update = "UPDATE danh_gia SET rating_value = ?, rated_at = NOW() WHERE user_id = ? AND recipe_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("iii", $rating, $user_id, $recipe_id);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                // Thêm đánh giá mới
                $sql_insert_rating = "INSERT INTO danh_gia (user_id, recipe_id, rating_value, rated_at) VALUES (?, ?, ?, NOW())";
                $stmt_insert_rating = $conn->prepare($sql_insert_rating);
                $stmt_insert_rating->bind_param("iii", $user_id, $recipe_id, $rating);
                $stmt_insert_rating->execute();
                $stmt_insert_rating->close();
            }
            $stmt_check->close();
            
            header("Location: chi_tiet_cong_thuc.php?recipe_id=" . $recipe_id);
            exit();
        }
    }
    
    // Lấy đánh giá của người dùng hiện tại
    $sql_get_user_rating = "SELECT rating_value FROM danh_gia WHERE user_id = ? AND recipe_id = ?";
    $stmt_get_user_rating = $conn->prepare($sql_get_user_rating);
    $stmt_get_user_rating->bind_param("ii", $user_id, $recipe_id);
    $stmt_get_user_rating->execute();
    $result_user_rating = $stmt_get_user_rating->get_result();
    if ($result_user_rating->num_rows > 0) {
        $user_rating = $result_user_rating->fetch_assoc()['rating_value'];
    }
    $stmt_get_user_rating->close();

    // Kiểm tra trạng thái yêu thích hiện tại của công thức
    $sql_check_favorite = "SELECT favorite_id FROM Mon_an_yeu_thich WHERE user_id = ? AND recipe_id = ?";
    $stmt_check_favorite = $conn->prepare($sql_check_favorite);
    $stmt_check_favorite->bind_param("ii", $user_id, $recipe_id);
    $stmt_check_favorite->execute();
    $result_check_favorite = $stmt_check_favorite->get_result();
    if ($result_check_favorite->num_rows > 0) {
        $is_favorited = true;
    }
    $stmt_check_favorite->close();
}

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
    header("Location: ../trangchu.php");
    exit();
}
$stmt_recipe->close();

// Lấy điểm trung bình của công thức từ bảng danh_gia
$sql_avg_rating = "SELECT AVG(rating_value) AS avg_rating FROM danh_gia WHERE recipe_id = ?";
$stmt_avg_rating = $conn->prepare($sql_avg_rating);
$stmt_avg_rating->bind_param("i", $recipe_id);
$stmt_avg_rating->execute();
$result_avg_rating = $stmt_avg_rating->get_result();
if ($result_avg_rating->num_rows > 0) {
    $avg_row = $result_avg_rating->fetch_assoc();
    $average_rating = $avg_row['avg_rating'] ?? 0;
}
$stmt_avg_rating->close();

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

// Lấy danh sách bình luận (Đã sửa tên cột)
$comments = [];
$sql_comments = "SELECT b.content, b.created_at, u.username 
                 FROM binh_luan b
                 JOIN thong_tin_nguoi_dung u ON b.user_id = u.user_id
                 WHERE b.recipe_id = ?
                 ORDER BY b.created_at DESC";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $recipe_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();
if ($result_comments->num_rows > 0) {
    while ($row = $result_comments->fetch_assoc()) {
        $comments[] = $row;
    }
}
$stmt_comments->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($recipe_details['title']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #E67E22; margin: 0; padding: 0; color: #333; }
        .header { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px 80px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo-link { height: 60px; display: flex; align-items: center; }
        .header .logo-image { height: 100%; width: auto; }
        .user-actions { font-weight: bold; }
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
        .container { max-width: 900px; margin: 40px auto; padding: 20px; background-color: #FFE0B2; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .recipe-title { text-align: center; color: #333; margin-bottom: 20px; }
        .recipe-meta { text-align: center; color: #555; margin-bottom: 20px; }
        .recipe-image { width: 100%; height: auto; border-radius: 10px; margin-bottom: 20px; }
        .section-title { font-size: 24px; border-bottom: 2px solid #555; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; }
        .recipe-content p, .recipe-content ul, .recipe-content ol { line-height: 1.6; }
        .recipe-content ul, .recipe-content ol { padding-left: 20px; }
        /* Cập nhật CSS cho phần đánh giá và yêu thích */
        .rating-section {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Đẩy các phần tử ra hai đầu */
            margin-bottom: 20px;
        }
        .rating-group {
            display: flex;
            align-items: center;
        }
        .rating-display {
            display: flex;
            align-items: center;
            font-size: 24px;
            color: gold;
        }
        .rating-display .fas.fa-star, .rating-display .fas.fa-star-half-alt {
            color: gold;
        }
        .rating-display .far.fa-star {
            color: gray;
        }
        .average-rating-text {
            font-size: 18px;
            color: #333;
            margin-left: 10px;
            font-weight: bold;
        }
        .rating-form .stars {
            unicode-bidi: bidi-override;
            direction: rtl;
            font-size: 24px;
        }
        .rating-form .stars input {
            display: none;
        }
        .rating-form .stars label {
            display: inline-block;
            cursor: pointer;
            color: #ccc;
        }
        .rating-form .stars label:hover,
        .rating-form .stars label:hover ~ label,
        .rating-form .stars input:checked ~ label {
            color: gold;
        }
        .favorite-form { 
            text-align: right; 
        }
        .favorite-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .favorite-btn:hover { background-color: #d32f2f; }
        .unfavorite-btn {
            background-color: #888;
        }
        .unfavorite-btn:hover {
            background-color: #666;
        }
        /* CSS cho phần bình luận */
        .comment-section { margin-top: 40px; }
        .comment-form textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .comment-form button {
            background-color: #E67E22;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .comment-form button:hover { background-color: #d35400; }
        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
        .comment-meta {
            font-size: 14px;
            color: #888;
            margin-bottom: 5px;
        }
        .comment-meta strong {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../trangchu.php" class="logo-link">
            <img src="../../logo/logo.jpg" alt="Logo Trang Nấu Ăn" class="logo-image">
        </a>
        <div class="user-actions">
            <a href="../trangchu.php" class="back-btn">Quay lại</a>
        </div>
    </div>
    <div class="container">
        <h1 class="recipe-title"><?php echo htmlspecialchars($recipe_details['title']); ?></h1>
        <div class="recipe-meta">
            Đăng bởi: <?php echo htmlspecialchars($recipe_details['username']); ?> vào ngày <?php echo htmlspecialchars(date("d/m/Y", strtotime($recipe_details['created_at']))); ?>
        </div>
        <img src="<?php echo htmlspecialchars($recipe_details['image_url']); ?>" alt="<?php echo htmlspecialchars($recipe_details['title']); ?>" class="recipe-image">
        
        <div class="rating-section">
            <div class="rating-group">
                <div class="rating-display">
                    <span class="average-rating-text">Đánh giá: </span>
                    <?php
                    $full_stars = floor($average_rating);
                    $has_half_star = ($average_rating - $full_stars) >= 0.5;
                    for ($i = 0; $i < $full_stars; $i++) {
                        echo '<i class="fas fa-star"></i>';
                    }
                    if ($has_half_star) {
                        echo '<i class="fas fa-star-half-alt"></i>';
                        for ($i = 0; $i < 4 - $full_stars; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                    } else {
                        for ($i = 0; $i < 5 - $full_stars; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    echo ' <span class="average-rating-text">('. number_format($average_rating, 2) .')</span>';
                    ?>
                </div>
                
                <?php if ($is_logged_in): ?>
                <div class="rating-form">
                    <form method="post" action="chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe_id); ?>">
                        <div class="stars">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo ($user_rating == $i) ? 'checked' : ''; ?> onclick="this.form.submit();">
                                <label for="star<?php echo $i; ?>">&#9733;</label>
                            <?php endfor; ?>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if ($is_logged_in): ?>
            <div class="favorite-form">
                <?php if ($is_favorited): ?>
                    <form method="post" action="chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe_id); ?>">
                        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_id); ?>">
                        <input type="hidden" name="action" value="remove">
                        <button type="submit" class="favorite-btn unfavorite-btn">Bỏ yêu thích</button>
                    </form>
                <?php else: ?>
                    <form method="post" action="chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe_id); ?>">
                        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_id); ?>">
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="favorite-btn">Thêm vào yêu thích</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php else: ?>
                <div class="favorite-form">
                    <a href="../dangnhap.php" class="favorite-btn">Đăng nhập để đánh giá & yêu thích</a>
                </div>
            <?php endif; ?>
        </div>

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

        <div class="comment-section">
            <h2 class="section-title">Bình luận</h2>
            
            <?php if ($is_logged_in): ?>
            <form class="comment-form" method="post" action="chi_tiet_cong_thuc.php?recipe_id=<?php echo htmlspecialchars($recipe_id); ?>">
                <?php if (!empty($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <textarea name="comment_text" placeholder="Viết bình luận của bạn tại đây..."></textarea>
                <button type="submit">Gửi bình luận</button>
            </form>
            <?php else: ?>
                <p>Vui lòng <a href="../dangnhap.php">đăng nhập</a> để bình luận.</p>
            <?php endif; ?>

            <div class="comments-list" style="margin-top: 20px;">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <div class="comment-meta">
                                <strong><?php echo htmlspecialchars($comment['username']); ?></strong> - 
                                <span class="comment-date"><?php echo htmlspecialchars(date("d/m/Y H:i", strtotime($comment['created_at']))); ?></span>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">Chưa có bình luận nào cho công thức này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>