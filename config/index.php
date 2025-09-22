<?php require APPROOT . '/Views/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <?php if(!isLoggedIn()): ?>
        <p>الرجاء <a href="<?php echo URLROOT; ?>/users/login">تسجيل الدخول</a> للمتابعة.</p>
    <?php endif; ?>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
