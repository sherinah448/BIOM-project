<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Create an Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }
    .register-container {
      max-width: 500px;
      margin: 50px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .register-container h2 {
      margin-bottom: 20px;
      color: #3b5d50;
    }
    .form-control {
      border-radius: 5px;
    }
    .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #3b5d50;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn-primary:hover {
      background-color: #3b5d50;
    }
    .footer-text {
      text-align: center;
      margin-top: 20px;
    }
    .footer-text a {
      text-decoration: none;
      color: #3b5d50;
    }
  </style>
</head>
<body>

<div class="register-container">
  <h2>Create an Account</h2>
  <form action="register_action.php" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
  <div class="footer-text">
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
