<?php
session_start();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  
  // Loop through the cart items and find the item to remove
  foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $id) {
      unset($_SESSION['cart'][$key]);
      break;
    }
  }

  // Reindex the cart array to fill any gaps in the keys
  $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header('Location: cart.php');
exit;
?>
