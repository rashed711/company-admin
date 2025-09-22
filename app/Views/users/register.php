<?php require APPROOT . '/Views/inc/header.php'; ?>
<div class="register-container">
    <h2>إنشاء حساب جديد</h2>
    <form action="<?php echo URLROOT; ?>/users/register" method="post">
            <div class="form-group">
                <label for="name">الاسم: <sup>*</sup></label>
                <input type="text" name="name" value="<?php echo $data['name']; ?>">
                <span class="error"><?php echo $data['name_err']; ?></span>
            </div>
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
            <div class="form-group">
                <label for="confirm_password">تأكيد كلمة المرور: <sup>*</sup></label>
                <input type="password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>">
                <span class="error"><?php echo $data['confirm_password_err']; ?></span>
            </div>
            <button type="submit">إنشاء حساب</button>
        </form>
    </div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
