<?php
session_start();
include 'db_config.php'; // This file should set $conn = new mysqli(...);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    // Collect form data
    $user_id = $_SESSION['user_id'];
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];
    $payment_method = $_POST['payment_method'];

    // Generate order number
    $order_number = 'ORD' . time() . rand(100, 999);

    // Calculate total amount
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders 
        (order_number, user_id, customer_name, customer_phone, customer_address, total_amount, payment_method, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())");
    $stmt->bind_param("sisssds", $order_number, $user_id, $customer_name, $customer_phone, $customer_address, $total, $payment_method);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }
        $stmt->close();

        // Clear cart
        unset($_SESSION['cart']);

        // Redirect to thank you page with order number
        header("Location: thank_you.php?order=$order_number");
        exit;

    } else {
        echo "Failed to save order. Please try again.";
    }

} else {
    echo "No data found or cart is empty.";
}
?>
