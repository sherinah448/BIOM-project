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
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Global Paints</title>
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

<!-- Hero -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Global Paints <span class="d-block">Uganda</span></h1>
                    <p class="mb-4">Global Paints is dedicated to delivering top-tier paint solutions that combine beauty, durability, and innovation. 
                        With a commitment to excellence, we help you transform any space into a vibrant, lasting reflection of your style. Our products are crafted to provide premium finishes, ensuring that every project stands the test of time.</p>
                    <p><a href="shop.php" class="btn btn-secondary me-2">Shop Now</a><a href="about.php" class="btn btn-white-outline">Explore</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="images/couch1.png" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Section -->
<div class="product-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title">Crafted with Premium Paint Solutions from Global Paints</h2>
                <p class="mb-4">At Global Paints, we use only high-quality materials to ensure a smooth, lasting finish. Whether for residential or commercial use, 
                    our paints are designed to offer vibrant color, durability, and unmatched performance.</p>
                <p><a href="shop.php" class="btn">Explore</a></p>
            </div>

            <?php
            $sql_products = "SELECT * FROM products ORDER BY id DESC";
            $result_products = mysqli_query($conn, $sql_products);
            if ($result_products && $result_products->num_rows > 0):
                while ($row = $result_products->fetch_assoc()):
            ?>
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <form method="POST" class="product-item">
                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid product-thumbnail" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                    <h3 class="product-name"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                    <strong class="product-price">UGX <?php echo number_format($row['selling_price'], 2); ?></strong>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-sm btn-primary mt-2">
                        <img src="images/cross.svg" alt="Add"> Add to Cart
                    </button>
                </form>
            </div>
            <?php endwhile; else: ?>
            <p>No products found.</p>
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
