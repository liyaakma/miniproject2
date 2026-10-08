<?php

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Student.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../views/login.php");
    exit();
}

$studentModel = new Student($conn);
$student = $studentModel->getById($_SESSION['id']);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword     = $_POST['old_password'];
    $newPassword     = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // 1. Verify old password matches what's in the database
    if (!password_verify($oldPassword, $student['password'])) {
        $message = "Old password is incorrect.";
    }
    // 2. Check new password and confirm password match
    elseif ($newPassword !== $confirmPassword) {
        $message = "New password and confirm password do not match.";
    }
    // 3. Enforce a minimum length (good practice)
    elseif (strlen($newPassword) < 6) {
        $message = "New password must be at least 6 characters.";
    }
    else {
        // 4. Hash the new password before saving - NEVER store plain text
        $hashedNew = password_hash($newPassword, PASSWORD_DEFAULT);
        $studentModel->updatePassword($_SESSION['id'], $hashedNew);
        $message = "SUCCESS: Password updated successfully!";
        // Refresh student data so old-password check works if they submit again
        $student = $studentModel->getById($_SESSION['id']);
    }
}
?>
