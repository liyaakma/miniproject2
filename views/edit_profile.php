<?php
require_once __DIR__ . '/../controllers/ProfileController.php';

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $program = $_POST['program'];

    // Call your model to update student info
    $studentModel->updateStudent($_SESSION['id'], $name, $program);

    // Redirect back to profile with success message
    header("Location: profile.php?updated=1");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width:500px;">
    <h3 class="mb-4">Edit Profile</h3>
    <form method="POST" action="edit_profile.php">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" 
                   value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Program</label>
            <input type="text" name="program" class="form-control" 
                   value="<?= htmlspecialchars($student['program']) ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>