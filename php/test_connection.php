<?php
// Test database connection
require_once 'connect.php';

echo "<h2>Database Connection Test</h2>";

// Test 1: Check if connection is working
if ($conn) {
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
} else {
    echo "<p style='color: red;'>✗ Database connection failed!</p>";
    exit();
}

// Test 2: Check if tables exist
$tables = ['cong_thuc_nau_an', 'nguyen_lieu', 'cac_buoc_nau_an', 'thong_tin_nguoi_dung', 'danh_muc_mon_an'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Table '$table' exists</p>";
    } else {
        echo "<p style='color: red;'>✗ Table '$table' does not exist</p>";
    }
}

// Test 3: Check data in cong_thuc_nau_an table
$result = $conn->query("SELECT COUNT(*) as count FROM cong_thuc_nau_an");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Number of recipes in database: " . $row['count'] . "</p>";
    
    if ($row['count'] > 0) {
        // Show first few recipes
        $recipes = $conn->query("SELECT recipe_id, title FROM cong_thuc_nau_an LIMIT 5");
        echo "<h3>Sample Recipes:</h3>";
        while ($recipe = $recipes->fetch_assoc()) {
            echo "<p>- Recipe ID: " . $recipe['recipe_id'] . ", Title: " . $recipe['title'] . "</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Error querying cong_thuc_nau_an table</p>";
}

// Test 4: Check ingredients for recipe ID 6 (from the error URL)
$result = $conn->query("SELECT COUNT(*) as count FROM nguyen_lieu WHERE recipe_id = 6");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Number of ingredients for recipe ID 6: " . $row['count'] . "</p>";
}

// Test 5: Check cooking steps for recipe ID 6
$result = $conn->query("SELECT COUNT(*) as count FROM cac_buoc_nau_an WHERE recipe_id = 6");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Number of cooking steps for recipe ID 6: " . $row['count'] . "</p>";
}

$conn->close();
?> 