<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Student.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $nric     = trim($_POST['nric']);
    $program  = trim($_POST['program']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $studentModel = new Student($conn);

    // Server-side validation
    if ($name === "" || $nric === "" || $program === "" || $username === "" || $password === "") {
        $message = "All fields are required.";
    }
    elseif ($password !== $confirmPassword) {
        $message = "Password and confirm password do not match.";
    }
    elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    }
    elseif ($studentModel->usernameExists($username)) {
        $message = "Username is already taken. Please choose another.";
    }
    else {
        // Hash the password before storing - same principle as 1.2
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $studentModel->register($name, $nric, $program, $username, $hashedPassword);
        header("Location: ../views/login.php?registered=1");
        exit();
    }
}
?>
