<?php
// Redirect to the correct location
if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    header("Location: danhmuc/chi_tiet_cong_thuc.php?recipe_id=" . urlencode($recipe_id));
    exit();
} else {
    header("Location: trangchu.php");
    exit();
}
?> 