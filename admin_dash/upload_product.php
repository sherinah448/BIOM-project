<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $product_name = $_POST['product_name'];
    $normal_price = $_POST['normal_price'];
    $selling_price = $_POST['selling_price'];
    $description = $_POST['description'];
    $stock_qty = $_POST['stock_qty'];
    $size = $_POST['size'];

    // Handle image upload
    $image_name = $_FILES['product_image']['name'];
    $image_tmp = $_FILES['product_image']['tmp_name'];
    $image_path = '../products/' . basename($image_name);

    // Ensure products folder exists
    if (!is_dir('products')) {
        mkdir('products', 0777, true);
    }

    if (move_uploaded_file($image_tmp, $image_path)) {
        // Insert into database
        $sql = "INSERT INTO products (category, subcategory, product_name, normal_price, selling_price, description, stock_qty, size, image_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssiss", $category, $subcategory, $product_name, $normal_price, $selling_price, $description, $stock_qty, $size, $image_path);

        if ($stmt->execute()) {
            echo "✅ Product uploaded successfully!";
        } else {
            echo "❌ Error inserting into database: " . $stmt->error;
        }
    } else {
        echo "❌ Failed to upload image.";
    }

    $stmt->close();
    $conn->close();
}
?>
