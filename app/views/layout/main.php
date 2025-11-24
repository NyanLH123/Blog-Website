<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlassSocial</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <nav class="glass-nav">
        <div class="container nav-container">
            <a href="<?= BASE_URL ?>/" class="brand">GlassSocial</a>
            <div class="nav-links">
                <?php if ($user = \Core\Session::get('user')): ?>
                    <a href="<?= BASE_URL ?>/user/<?= htmlspecialchars($user['username']) ?>">Profile</a>
                    <?php if($user['role'] === 'admin'): ?>
                        <a href="<?= BASE_URL ?>/admin">Admin</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/logout" class="btn-text">Logout</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/login">Login</a>
                    <a href="<?= BASE_URL ?>/register" class="btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php include __DIR__ . '/../partial/_flash.php'; ?>
        <?= $content ?>
    </main>

    <footer class="container footer">
        <p>&copy; <?= date('Y') ?> GlassSocial.</p>
    </footer>

    <script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>