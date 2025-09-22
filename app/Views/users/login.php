<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="login-container">
    <?php flash('register_success'); ?>
    <h2>تسجيل الدخول</h2>
    <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="form-group">
                <label for="email">البريد الإلكتروني: <sup>*</sup></label>
                <input type="email" name="email" value="<?php echo $data['email']; ?>">
                <span class="error"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور: <sup>*</sup></label>
                <input type="password" name="password" value="<?php echo $data['password']; ?>">
                <span class="error"><?php echo $data['password_err']; ?></span>
            </div>
            <button type="submit">دخول</button>
        </form>
    </div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>