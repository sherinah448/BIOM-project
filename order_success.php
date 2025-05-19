<?php
session_start();
if (!isset($_GET['order_id'])) {
    header('Location: index.php'); // Redirect to home if no order ID
    exit;
}

$order_id = $_GET['order_id'];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order Success</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h2>Order Confirmation</h2>
  <p>Your order has been placed successfully! Your order ID is <strong><?php echo $order_id; ?></strong>.</p>
  <p>We will process your payment and notify you shortly.</p>
  <a href="index.php" class="btn btn-primary">Return to Home</a>
</div>

</body>
</html>
