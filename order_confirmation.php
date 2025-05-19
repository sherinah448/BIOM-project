<?php
session_start();
include('db_config.php');

if (!isset($_GET['order_id'])) {
    die("Order ID is required.");
}

$order_id = $_GET['order_id'];

// Get order details from the database
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    // Display order information
    echo "<h1>Order Confirmation</h1>";
    echo "<p>Order Number: " . $order['order_number'] . "</p>";
    echo "<p>Customer Name: " . $order['customer_name'] . "</p>";
    echo "<p>Shipping Address: " . $order['customer_address'] . "</p>";
    echo "<p>Phone Number: " . $order['customer_phone'] . "</p>";
    echo "<p>Payment Method: " . $order['payment_method'] . "</p>";
    echo "<p>Total Amount: UGX " . number_format($order['total_amount'], 2) . "</p>";
    echo "<p>Status: " . ucfirst($order['status']) . "</p>";

    // Get order items
    $stmt2 = $conn->prepare("SELECT oi.*, p.name, p.price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
    $stmt2->bind_param("i", $order_id);
    $stmt2->execute();
    $order_items_result = $stmt2->get_result();

    echo "<h3>Order Items</h3>";
    echo "<ul>";
    while ($item = $order_items_result->fetch_assoc()) {
        echo "<li>" . $item['name'] . " (UGX " . number_format($item['price'], 2) . ") x " . $item['quantity'] . " = UGX " . number_format($item['subtotal'], 2) . "</li>";
    }
    echo "</ul>";

} else {
    echo "Order not found.";
}
?>
