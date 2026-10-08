<?php require_once __DIR__ . '/../controllers/RegisterController.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width:450px;">
    <h3 class="mb-4">Create Student Account</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">NRIC</label>
            <input type="text" name="nric" class="form-control" placeholder="e.g. 060903-08-0158" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Program</label>
            <input type="text" name="program" class="form-control" placeholder="e.g. Diploma in Information Technology" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <a href="login.php" class="btn btn-link mt-2">Already have an account? Login</a>
</div>
</body>
</html>
