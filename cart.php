<?php
session_start();


// Optional: Handle AJAX quantity updates
if (isset($_POST['action']) && $_POST['action'] == 'update_quantity') {
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as &$item) {
      if ($item['id'] == $id) {
        $item['quantity'] = $quantity;
        break;
      }
    }
  }
  echo json_encode(['success' => true]);
  exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    .product-row { vertical-align: middle; }
    .cart-total-line { border-bottom: 1px solid #ccc; padding: 8px 0; }

    /* Smaller buttons for quantity increase/decrease */
    .input-group button {
      padding: 5px 10px;
      font-size: 14px;
      min-width: 30px;
      min-height: 30px;
    }

    /* Remove button styling */
    .btn-remove {
      padding: 5px 10px;
      font-size: 14px;
      background-color: #f44336;
      color: white;
      border: none;
    }

    .btn-remove:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <h2>Your Shopping Cart</h2>
  <table class="table table-bordered mt-4">
    <thead class="thead-dark">
      <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price (UGX)</th>
        <th>Quantity</th>
        <th>Subtotal (UGX)</th>
        <th>Remove</th>
      </tr>
    </thead>
    <tbody id="cart-body">
      <?php
      $total = 0;
      if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
      ?>
        <tr class="product-row" data-id="<?php echo $item['id']; ?>">
          <td><img src="<?php echo $item['image']; ?>" width="60" alt="product"></td>
          <td><?php echo $item['name']; ?></td>
          <td><?php echo number_format($item['price']); ?></td>
          <td>
            <div class="input-group" style="max-width: 120px;">
              <button class="btn btn-sm btn-outline-secondary btn-decrease">-</button>
              <input type="text" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" />
              <button class="btn btn-sm btn-outline-secondary btn-increase">+</button>
            </div>
          </td>
          <td class="item-subtotal"><?php echo number_format($subtotal); ?></td>
          <td><button class="btn-remove btn btn-danger btn-sm btn-remove">X</button></td>
        </tr>
      <?php
        }
      } else {
        echo '<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>';
      }
      ?>
    </tbody>
  </table>

  <?php if (!empty($_SESSION['cart'])): ?>
    <div class="mt-5">
      <h4>Itemized Cost</h4>
      <div id="itemized-cost">
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <div class="cart-total-line">
            <?php echo $item['name']; ?>: <?php echo number_format($item['price']); ?> x <?php echo $item['quantity']; ?> = <strong><?php echo number_format($item['price'] * $item['quantity']); ?> UGX</strong>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="cart-total-line mt-3">
        <h5>Total: <strong id="grand-total"><?php echo number_format($total); ?> UGX</strong></h5>
      </div>
      <a href="checkout.php" class="btn btn-success btn-lg mt-3">Proceed to Checkout</a>
    </div>
  <?php endif; ?>
</div>

<script>
document.querySelectorAll('.btn-increase, .btn-decrease').forEach(button => {
  button.addEventListener('click', function() {
    const row = this.closest('.product-row');
    const quantityInput = row.querySelector('.quantity-input');
    let quantity = parseInt(quantityInput.value);
    if (this.classList.contains('btn-increase')) {
      quantity++;
    } else if (quantity > 1) {
      quantity--;
    }
    quantityInput.value = quantity;

    const id = row.getAttribute('data-id');
    fetch('', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=update_quantity&id=${id}&quantity=${quantity}`
    }).then(() => {
      const price = parseInt(row.children[2].innerText.replace(/,/g, ''));
      const subtotal = price * quantity;
      row.querySelector('.item-subtotal').innerText = subtotal.toLocaleString();
      updateGrandTotal();
    });
  });
});

function updateGrandTotal() {
  let total = 0;
  document.querySelectorAll('.product-row').forEach(row => {
    const subtotal = parseInt(row.querySelector('.item-subtotal').innerText.replace(/,/g, ''));
    total += subtotal;
  });
  document.getElementById('grand-total').innerText = total.toLocaleString() + ' UGX';

  // Also update the itemized costs
  const itemizedCost = document.getElementById('itemized-cost');
  itemizedCost.innerHTML = '';
  document.querySelectorAll('.product-row').forEach(row => {
    const name = row.children[1].innerText;
    const price = parseInt(row.children[2].innerText.replace(/,/g, ''));
    const quantity = parseInt(row.querySelector('.quantity-input').value);
    const subtotal = price * quantity;
    itemizedCost.innerHTML += `<div class="cart-total-line">${name}: ${price.toLocaleString()} x ${quantity} = <strong>${subtotal.toLocaleString()} UGX</strong></div>`;
  });
}

document.querySelectorAll('.btn-remove').forEach(button => {
  button.addEventListener('click', function() {
    const row = this.closest('.product-row');
    const id = row.getAttribute('data-id');
    window.location.href = `remove_cart_item.php?id=${id}`;
  });
});
</script>
<br>
<!-- footer -->
<?php
	include 'footer.php';
		
?>

</body>
</html>
