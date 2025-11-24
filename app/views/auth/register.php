<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>
    <div class="auth-container">
        <div class="card auth-card">
            <h2>Welcome Back</h2>
            <form action="<?= BASE_URL ?>/register" method="POST">
                <?php include __DIR__ . '/../partial/_csrf.php'; ?>

                <div class="form-group">
                    <label>Username</label>
                    <input type="username" name="username" required placeholder="yourname">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary full-width">Register</button>
            </form>
            <p class="auth-link">No account? <a href="<?= BASE_URL ?>/login">Login</a></p>
        </div>
    </div>
</body>

</html>