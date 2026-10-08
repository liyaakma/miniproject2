<?php
require_once __DIR__ . '/../controllers/ProfileController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5" style="max-width: 550px;">

    <h3 class="mb-4 text-center">Student Profile</h3>

    <!-- ============================= -->
    <!-- SUCCESS MESSAGE -->
    <!-- ============================= -->

    <?php if (isset($_SESSION['upload_success'])): ?>

        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['upload_success']) ?>
        </div>

        <?php unset($_SESSION['upload_success']); ?>

    <?php endif; ?>


    <!-- ============================= -->
    <!-- ERROR MESSAGE -->
    <!-- ============================= -->

    <?php if (isset($_SESSION['upload_error'])): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['upload_error']) ?>
        </div>

        <?php unset($_SESSION['upload_error']); ?>

    <?php endif; ?>


    <div class="card shadow-sm">

        <div class="card-body">

            <!-- ============================= -->
            <!-- PROFILE PICTURE -->
            <!-- ============================= -->

            <div class="text-center mb-4">

                <?php if (!empty($student['profile_picture'])): ?>

                    <img
                        src="../uploads/<?= htmlspecialchars($student['profile_picture']) ?>"
                        alt="Profile Picture"
                        class="rounded-circle border"
                        width="150"
                        height="150"
                        style="object-fit: cover;">

                <?php else: ?>

                    <div
                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                        style="width:150px; height:150px; font-size:60px;">

                        👤

                    </div>

                    <p class="text-muted mt-2">
                        No profile picture uploaded
                    </p>

                <?php endif; ?>

            </div>


            <!-- ============================= -->
            <!-- STUDENT INFORMATION -->
            <!-- ============================= -->

            <p>
                <strong>Name:</strong>
                <?= htmlspecialchars($student['name']) ?>
            </p>

            <p>
                <strong>NRIC:</strong>
                <?= htmlspecialchars($student['nric']) ?>
            </p>

            <p>
                <strong>Program:</strong>
                <?= htmlspecialchars($student['program']) ?>
            </p>


            <hr>


            <!-- ============================= -->
            <!-- PROFILE PICTURE UPLOAD FORM -->
            <!-- ============================= -->

            <h5 class="mb-3">Upload Profile Picture</h5>

            <form
                method="POST"
                action="../controllers/ProfileController.php"
                enctype="multipart/form-data">

                <div class="mb-3">

                    <label class="form-label">
                        Choose Profile Picture
                    </label>

                    <input
                        type="file"
                        name="profile_picture"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                        required>

                    <div class="form-text">
                        JPG, JPEG or PNG only. Maximum file size: 2MB.
                    </div>

                </div>

                <button
                    type="submit"
                    name="upload_picture"
                    class="btn btn-primary w-100">

                    Upload Picture

                </button>

            </form>

        </div>

    </div>


    <!-- ============================= -->
    <!-- ORIGINAL MINI PROJECT 1 BUTTONS -->
    <!-- ============================= -->

    <div class="mt-3">

        <a
            href="edit_profile.php"
            class="btn btn-secondary">

            Edit Profile

        </a>

        <a
            href="change_password.php"
            class="btn btn-secondary">

            Change Password

        </a>

        <a
            href="logout.php"
            class="btn btn-outline-danger">

            Logout

        </a>

    </div>


    <!-- ============================= -->
    <!-- DELETE ACCOUNT -->
    <!-- ============================= -->

    <form
        method="POST"
        action="../controllers/ProfileController.php"
        class="mt-3">

        <button
            type="submit"
            name="delete"
            class="btn btn-outline-danger"
            onclick="return confirm('Are you sure you want to delete your account?');">

            Delete Account

        </button>

    </form>

</div>

</body>
</html>
