<?php

// إعدادات قاعدة البيانات
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // <-- اسم مستخدم قاعدة البيانات
define('DB_PASS', '');     // <-- كلمة المرور
define('DB_NAME', 'erp_db'); // <-- اسم قاعدة البيانات التي أنشأتها

// مسار التطبيق الأساسي
define('APPROOT', dirname(dirname(__FILE__)) . '/app'); // المسار إلى مجلد app

// رابط الموقع (URL Root)
define('URLROOT', 'http://localhost/company-admin/public'); // <-- عدّل الرابط ليشمل public

// اسم الموقع
define('SITENAME', 'نظام إدارة الأعمال');