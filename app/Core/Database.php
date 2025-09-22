<?php
// app/Core/Database.php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Statement
    private $error;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // تحضير الاستعلام
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // ربط المتغيرات
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // تنفيذ الاستعلام
    public function execute() {
        return $this->stmt->execute();
    }

    // جلب كل النتائج كمصفوفة من الكائنات
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // جلب نتيجة واحدة ككائن
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    // جلب عدد الصفوف
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}