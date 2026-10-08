<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width:400px;">
    <h3 class="mb-4">Student Login</h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Invalid username or password.</div>
    <?php endif; ?>
    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">Account created successfully! Please login.</div>
    <?php endif; ?>

    <form action="../controllers/AuthController.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <a href="register.php" class="btn btn-link mt-2">Don't have an account? Register</a>
</div>
</body>
</html>
