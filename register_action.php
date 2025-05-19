<?php
session_start();
include('db_config.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validate form data
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Full Name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    
    if (empty($confirm_password)) {
        $errors[] = "Confirm Password is required.";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Hash the password before saving
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email is already taken.";
            header("Location: register.php");
            exit();
        }

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful. You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "There was an error. Please try again later.";
            header("Location: register.php");
            exit();
        }
    } else {
        // If there are validation errors, redirect back with error messages
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }
}
?>
