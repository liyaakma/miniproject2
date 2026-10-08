<?php


session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $studentModel = new Student($conn);
    $student = $studentModel->getByUsername($username);

    if ($student && password_verify($password, $student['password'])) {
        
        $_SESSION['id'] = $student['id'];
        header("Location: ../views/profile.php");
        exit();
    } else {
        header("Location: ../views/login.php?error=1");
        exit();
    }
}
?>
