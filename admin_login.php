<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f2f2f2;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .login-form {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fff;
    }

    .form-box {
      width: 80%;
      max-width: 400px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-box input[type="text"],
    .form-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .form-box input[type="submit"] {
      width: 100%;
      background-color: #3b5d50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .form-box input[type="submit"]:hover {
      background-color: #3b5d50;
    }

    .image-side {
      flex: 1;
      background: #3b5d50;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .image-side img {
      width: 70%;
      max-width: 400px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .image-side {
        display: none;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="login-form">
    <form class="form-box" action="login_process.php" method="post">
      <h2>Admin Login</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
      <p style="text-align:center; margin-top:10px;">
        Don't have an account? <a href="admin_register.php">Register</a>
      </p>
    </form>
  </div>
  <div class="image-side">
    <img src="images/admin_login.png" alt="Login Image">
  </div>
</div>
</body>
</html>
