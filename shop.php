<?php
session_start();
include 'db_config.php';

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
        header("Location: shop.php"); // return to shop page
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
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Global Paints – Premium Paints & Coatings for Interior and Exterior Designs.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
        }
    </style>
</head>
<body>

<!-- Cart Notification -->
<?php if (isset($_SESSION['cart_notification'])): ?>
    <div class="cart-notification">
        <?php echo $_SESSION['cart_notification']; unset($_SESSION['cart_notification']); ?>
    </div>
<?php endif; ?>

<!-- Header -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Global Paints<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto">
                <li><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="shop.php">Shop</a></li>
                <li><a class="nav-link" href="about.php">About</a></li>
                <li><a class="nav-link" href="services.php">Services</a></li>
                <li><a class="nav-link" href="blog.php">Blog</a></li>
                <li><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
            <ul class="custom-navbar-cta navbar-nav ms-5">
                <li><a class="nav-link" href="#"><img src="images/user.svg"></a></li>
                <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"> Cart (<?php echo $cart_count; ?>)</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Shop Product Section -->
<div class="product-section pt-5 pb-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row">

        <?php
        $sql_products = "SELECT * FROM products ORDER BY id DESC";
        $result_products = mysqli_query($conn, $sql_products);
        if ($result_products && $result_products->num_rows > 0):
            while ($row = $result_products->fetch_assoc()):
        ?>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <form method="POST" class="product-item border p-3 text-center">
                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid mb-2" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                    <h5 class="product-name"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                    <p class="text-muted">UGX <?php echo number_format($row['selling_price'], 2); ?></p>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
        <?php endwhile; else: ?>
            <p class="text-center">No products found.</p>
        <?php endif; ?>

        </div>
    </div>
</div>
<!-- footer -->
<?php
	include 'footer.php';
		
?>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/main.js"></script>

</body>
</html>
