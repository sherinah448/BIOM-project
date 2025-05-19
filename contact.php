<?php
include 'db_config.php'; // Database connection file

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (fname, lname, email, message) 
            VALUES ('$fname', '$lname', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $success = "🎨 Thank you for reaching out to <strong>Global Paints</strong>!<br>We’ve received your message and will get back to you shortly to brighten up your space.";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Global Paints – Contact</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

  <!-- Header -->
  <?php include 'header.php'; ?>

  <!-- Hero Section -->
  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <h1>Contact</h1>
          <p class="mb-4">At Global Paints, we believe in transforming spaces with vibrant color and quality finishes.</p>
        </div>
        <div class="col-lg-7">
          <div class="hero-img-wrap">
            <img src="images/couch1.png" class="img-fluid" alt="Hero Image">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="untree_co-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">

          <!-- Success or Error Message -->
          <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>

        </div>

        <?php if (!$success): ?>
        <div class="col-md-8">
          <!-- Contact Form -->
          <form method="POST" action="">
            <div class="row">
              <div class="col-6 mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" id="fname" class="form-control" required>
              </div>
              <div class="col-6 mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" id="lname" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
