<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'global_paints'; // change this to your DB name

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
