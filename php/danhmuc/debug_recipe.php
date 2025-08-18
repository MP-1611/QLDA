<?php
session_start();
require_once '../connect.php';

echo "<h2>Recipe Detail Debug</h2>";

// Check if recipe_id is provided
if (!isset($_GET['recipe_id'])) {
    echo "<p style='color: red;'>No recipe_id provided</p>";
    exit();
}

$recipe_id = $_GET['recipe_id'];
echo "<p>Recipe ID: " . htmlspecialchars($recipe_id) . "</p>";

// Test database connection
if (!$conn) {
    echo "<p style='color: red;'>Database connection failed</p>";
    exit();
}

// Check if recipe exists
$sql = "SELECT * FROM cong_thuc_nau_an WHERE recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p style='color: red;'>Recipe not found in database</p>";
    exit();
}

$recipe = $result->fetch_assoc();
echo "<h3>Recipe Details:</h3>";
echo "<p>Title: " . htmlspecialchars($recipe['title']) . "</p>";
echo "<p>Description: " . htmlspecialchars($recipe['description']) . "</p>";
echo "<p>Image URL: " . htmlspecialchars($recipe['image_url']) . "</p>";

// Check ingredients
$sql_ingredients = "SELECT * FROM nguyen_lieu WHERE recipe_id = ?";
$stmt_ingredients = $conn->prepare($sql_ingredients);
$stmt_ingredients->bind_param("i", $recipe_id);
$stmt_ingredients->execute();
$result_ingredients = $stmt_ingredients->get_result();

echo "<h3>Ingredients (" . $result_ingredients->num_rows . " found):</h3>";
if ($result_ingredients->num_rows > 0) {
    while ($ingredient = $result_ingredients->fetch_assoc()) {
        echo "<p>- " . htmlspecialchars($ingredient['ingredient_name']) . "</p>";
    }
} else {
    echo "<p style='color: orange;'>No ingredients found</p>";
}

// Check cooking steps
$sql_steps = "SELECT * FROM cac_buoc_nau_an WHERE recipe_id = ? ORDER BY step_number";
$stmt_steps = $conn->prepare($sql_steps);
$stmt_steps->bind_param("i", $recipe_id);
$stmt_steps->execute();
$result_steps = $stmt_steps->get_result();

echo "<h3>Cooking Steps (" . $result_steps->num_rows . " found):</h3>";
if ($result_steps->num_rows > 0) {
    while ($step = $result_steps->fetch_assoc()) {
        echo "<p>" . $step['step_number'] . ". " . htmlspecialchars($step['description']) . "</p>";
    }
} else {
    echo "<p style='color: orange;'>No cooking steps found</p>";
}

// Check author information
$sql_author = "SELECT username FROM thong_tin_nguoi_dung WHERE user_id = ?";
$stmt_author = $conn->prepare($sql_author);
$stmt_author->bind_param("i", $recipe['author_id']);
$stmt_author->execute();
$result_author = $stmt_author->get_result();

if ($result_author->num_rows > 0) {
    $author = $result_author->fetch_assoc();
    echo "<h3>Author:</h3>";
    echo "<p>" . htmlspecialchars($author['username']) . "</p>";
} else {
    echo "<p style='color: orange;'>Author not found</p>";
}

$conn->close();
?> 