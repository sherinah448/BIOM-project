<?php
session_start();
include 'db_config.php';

// Ensure cart session is always an array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $sql_product = "SELECT * FROM products WHERE id = $product_id";
    $product_result = $conn->query($sql_product);

    if ($product_result && $product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            $_SESSION['cart'][$product_id]['total'] = $_SESSION['cart'][$product_id]['price'] * $_SESSION['cart'][$product_id]['quantity'];
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['product_name'],
                'price' => $product['selling_price'],
                'quantity' => $quantity,
                'total' => $product['selling_price'] * $quantity
            ];
        }

        $_SESSION['cart_notification'] = "Product added to cart!";
        header("Location: index.php"); // Redirect to avoid form resubmission
        exit;
    }
}

// Count cart items
$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    if (is_array($item) && isset($item['quantity'])) {
        $cart_count += $item['quantity'];
    }
}
?>

<!-- Header -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Global Paints<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto">
                <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                <li><a class="nav-link" href="shop.php">Shop</a></li>
                <li><a class="nav-link" href="about.php">About</a></li>
                <li><a class="nav-link" href="services.php">Services</a></li>
                <li><a class="nav-link" href="blog.php">Blog</a></li>
                <li><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
            <ul class="custom-navbar-cta navbar-nav ms-5">
                <li><a class="nav-link" href="admin_login.php"><img src="images/user.svg"></a></li>
                <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"> Cart (<?php echo $cart_count; ?>)</a></li>
            </ul>
        </div>
    </div>
</nav>