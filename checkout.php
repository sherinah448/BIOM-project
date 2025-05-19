<?php
session_start();

// Ensure the user is logged in before proceeding to checkout
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}

// Initialize cart total
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Confirm Order</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<!-- header -->
 
<div class="container my-5">
  <h2>Confirm Order</h2>
  <p>You're logged in as <strong><?php echo $_SESSION['user_name']; ?></strong>. Please confirm your delivery information and payment method.</p>

  <div class="row">
    <!-- Left Column: Order Summary -->
    <div class="col-md-6">
      <h4>Order Summary</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price (UGX)</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
              <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo number_format($item['price']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'] * $item['quantity']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <h5>Total: <strong><?php echo number_format($total); ?> UGX</strong></h5>
    </div>

    <!-- Right Column: Customer Info + Payment -->
    <div class="col-md-6">
      <h4>Delivery & Payment Details</h4>
      <form method="POST" action="order_process.php">
        <div class="form-group">
          <label for="customer_name">Full Name</label>
          <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>

        <div class="form-group">
          <label for="customer_phone">Phone Number</label>
          <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
        </div>

        <div class="form-group">
          <label for="customer_address">Delivery Address</label>
          <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
        </div>

        <div class="form-group">
          <label for="payment_method">Payment Method</label>
          <select class="form-control" id="payment_method" name="payment_method" required>
            <option value="mtn_mobile_money">MTN Mobile Money</option>
            <option value="airtel_mobile_money">Airtel Mobile Money</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
            <option value="bank_transfer">Bank Transfer</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success btn-lg mt-3">Confirm Order</button>
      </form>
    </div>
  </div>
</div>

<!-- footer -->
<?php
			include 'footer.php';
	?>

</body>
</html>
