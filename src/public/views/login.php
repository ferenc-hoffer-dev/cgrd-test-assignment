<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../assets/images/logo.svg">
</head>
<body>
<div class="main-container">
    <div class="logo-container">
        <img src="../assets/images/logo.svg" alt="cgrd logo" class="logo">
    </div>

    <?php if (!empty($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-save">Login</button>
    </form>
</div>
</body>
</html>
