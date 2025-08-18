<?php
// Simple test to verify everything is working
require_once 'connect.php';

echo "<h2>Simple Database Test</h2>";

// Test 1: Connection
if ($conn) {
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
} else {
    echo "<p style='color: red;'>✗ Database connection failed!</p>";
    exit();
}

// Test 2: Check if recipe ID 6 exists
$recipe_id = 6;
$sql = "SELECT * FROM cong_thuc_nau_an WHERE recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Recipe ID 6 found: " . htmlspecialchars($recipe['title']) . "</p>";
    
    // Test 3: Check ingredients
    $sql_ingredients = "SELECT * FROM nguyen_lieu WHERE recipe_id = ?";
    $stmt_ingredients = $conn->prepare($sql_ingredients);
    $stmt_ingredients->bind_param("i", $recipe_id);
    $stmt_ingredients->execute();
    $result_ingredients = $stmt_ingredients->get_result();
    
    echo "<p>✓ Found " . $result_ingredients->num_rows . " ingredients for recipe ID 6</p>";
    
    // Test 4: Check cooking steps
    $sql_steps = "SELECT * FROM cac_buoc_nau_an WHERE recipe_id = ?";
    $stmt_steps = $conn->prepare($sql_steps);
    $stmt_steps->bind_param("i", $recipe_id);
    $stmt_steps->execute();
    $result_steps = $stmt_steps->get_result();
    
    echo "<p>✓ Found " . $result_steps->num_rows . " cooking steps for recipe ID 6</p>";
    
} else {
    echo "<p style='color: red;'>✗ Recipe ID 6 not found in database</p>";
}

$conn->close();
echo "<p><a href='danhmuc/chi_tiet_cong_thuc.php?recipe_id=6'>Test Recipe Detail Page</a></p>";
?> 