<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category_name'];
    $subcategory = $_POST['subcategory_name'];

    $stmt = $conn->prepare("INSERT INTO categories (category_name, subcategory_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $category, $subcategory);

    if ($stmt->execute()) {
        echo "✅ Category & Subcategory uploaded successfully!";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
}
?>
