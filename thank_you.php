<?php
$order_number = $_GET['order'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Received</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .header, .footer {
      background-color: #3b5d50;
      color: white;
      text-align: center;
      padding: 15px 0;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 120px);
      text-align: center;
    }

    .message-box {
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 90%;
    }

    .message-box h2 {
      color: #28a745;
      margin-bottom: 20px;
    }

    .message-box p {
      font-size: 16px;
      color: #333;
    }

    .btn-home {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #3b5d50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn-home:hover {
      background-color:rgb(24, 198, 131);
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>Online Store</h1>
  </div>

  <div class="container">
    <div class="message-box">
      <h2>Thank you for your order!</h2>
      <p>Your Order Number is: <strong><?php echo htmlspecialchars($order_number); ?></strong></p>
      <p>Please keep this number for tracking and support.</p>
      <a href="index.php" class="btn-home">Back to Home</a>
    </div>
  </div>

  <div class="footer">
    <p>&copy; <?php echo date('Y'); ?> Online Store. All rights reserved.</p>
  </div>

</body>
</html>
