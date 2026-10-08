<?php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Student.php';

// ==========================================
// ACCESS CONTROL
// ==========================================
// User must login before accessing profile
if (!isset($_SESSION['id'])) {
    header("Location: ../views/login.php");
    exit();
}

$studentModel = new Student($conn);

// Get currently logged-in student
$student = $studentModel->getById($_SESSION['id']);


// ==========================================
// PROFILE PICTURE UPLOAD
// ==========================================
if (isset($_POST['upload_picture'])) {

    // Check whether a file was selected
    if (
        !isset($_FILES['profile_picture']) ||
        $_FILES['profile_picture']['error'] == UPLOAD_ERR_NO_FILE
    ) {
        $_SESSION['upload_error'] = "Please select a profile picture.";
        header("Location: ../views/profile.php");
        exit();
    }

    $file = $_FILES['profile_picture'];

    // Check for upload error
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['upload_error'] = "An error occurred while uploading the file.";
        header("Location: ../views/profile.php");
        exit();
    }


    // ======================================
    // FILE SIZE VALIDATION
    // Maximum: 2MB
    // ======================================
    $maxFileSize = 2 * 1024 * 1024;

    if ($file['size'] > $maxFileSize) {
        $_SESSION['upload_error'] = "File size must not exceed 2MB.";
        header("Location: ../views/profile.php");
        exit();
    }


    // ======================================
    // FILE TYPE VALIDATION
    // Only JPG, JPEG and PNG
    // ======================================
    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png'
    ];

    // Detect actual file MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!isset($allowedMimeTypes[$mimeType])) {
        $_SESSION['upload_error'] = "Only JPG, JPEG and PNG files are allowed.";
        header("Location: ../views/profile.php");
        exit();
    }


    // ======================================
    // SECURE FILE RENAMING
    // ======================================
    $extension = $allowedMimeTypes[$mimeType];

    $newFileName = uniqid('profile_', true) . '.' . $extension;


    // ======================================
    // UPLOAD DIRECTORY
    // ======================================
    $uploadDirectory = __DIR__ . '/../uploads/';

    // Create uploads folder if it does not exist
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    $destination = $uploadDirectory . $newFileName;


    // ======================================
    // MOVE FILE TO UPLOADS FOLDER
    // ======================================
    if (move_uploaded_file($file['tmp_name'], $destination)) {

        // Save filename into database
        $updated = $studentModel->updateProfilePicture(
            $_SESSION['id'],
            $newFileName
        );

        if ($updated) {

            // OPTIONAL:
            // Delete previous profile picture
            if (
                !empty($student['profile_picture']) &&
                file_exists($uploadDirectory . $student['profile_picture'])
            ) {
                unlink($uploadDirectory . $student['profile_picture']);
            }

            $_SESSION['upload_success'] =
                "Profile picture uploaded successfully.";

        } else {

            // Database update failed, remove uploaded file
            if (file_exists($destination)) {
                unlink($destination);
            }

            $_SESSION['upload_error'] =
                "Unable to update profile picture in database.";
        }

    } else {

        $_SESSION['upload_error'] =
            "Unable to upload profile picture.";
    }


    // Return to profile page
    header("Location: ../views/profile.php");
    exit();
}


// ==========================================
// DELETE ACCOUNT
// ==========================================
if (isset($_POST['delete'])) {

    $studentModel->deleteStudent($_SESSION['id']);

    session_destroy();

    header("Location: ../views/register.php?deleted=1");
    exit();
}

?>