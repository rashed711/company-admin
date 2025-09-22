<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <style>
        /* Simple styles for layout */
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; }
        .navbar { background: #333; color: #fff; padding: 1rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #fff; text-decoration: none; padding: 0 10px; }
        .navbar .logo { font-weight: bold; }
        .container { max-width: 960px; margin: 2rem auto; padding: 2rem; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; text-align: center; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .error { color: red; font-size: 0.8rem; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?php echo URLROOT; ?>" class="logo"><?php echo SITENAME; ?></a>
        <div>
            <?php if(isLoggedIn()) : ?>
                <a href="#">أهلاً <?php echo $_SESSION['user_name']; ?></a>
                <a href="<?php echo URLROOT; ?>/users/logout">تسجيل الخروج</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/login">تسجيل الدخول</a>
                <a href="<?php echo URLROOT; ?>/users/register">إنشاء حساب</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="container">
        <?php flash('message'); ?>