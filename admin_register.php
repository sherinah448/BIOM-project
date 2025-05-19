<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Register</title>
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
      background: #f9f9f9;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-box input[type="text"],
    .form-box input[type="email"],
    .form-box input[type="password"] {
      width: 100%;
      padding: 14px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      font-size: 16px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-box input[type="text"]:focus,
    .form-box input[type="email"]:focus,
    .form-box input[type="password"]:focus {
      border-color: #3b5d50;
      box-shadow: 0 0 5pxrgb(99, 194, 158);
      outline: none;
    }

    .form-box input[type="submit"] {
      width: 100%;
      background-color: #3b5d50;
      color: white;
      padding: 14px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form-box input[type="submit"]:hover {
      background-color: #3b5d50;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0, 91, 187, 0.2);
    }

    .form-box p {
      text-align: center;
      margin-top: 15px;
    }

    .form-box a {
      color: #3b5d50;
      text-decoration: none;
    }

    .form-box a:hover {
      text-decoration: underline;
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
    <form class="form-box" action="register_process.php" method="post">
      <h2>Admin Register</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Register">
      <p>
        Already have an account? <a href="admin_login.php">Login</a>
      </p>
    </form>
  </div>
  <div class="image-side">
    <img src="images/admin_login.png" alt="Register Image">
  </div>
</div>
</body>
</html>
