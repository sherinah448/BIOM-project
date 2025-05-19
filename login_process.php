<?php
include 'db_config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_name'] = $user['username'];
    header("Location: admin_dash/index.php");
    exit();
} else {
    echo "Invalid username or password. <a href='admin_login.php'>Try again</a>";
}
?>
