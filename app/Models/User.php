<?php
class User {
    private $db;

    public function __construct() {
        // في كل مرة ننشئ كائن من User, سيتم إنشاء كائن جديد من Database
        $this->db = new Database;
    }

    /**
     * تسجيل مستخدم جديد
     * @param array $data بيانات المستخدم (name, email, password)
     * @return bool True عند النجاح, False عند الفشل
     */
    public function register($data) {
        $this->db->query('INSERT INTO users (name, email, password_hash) VALUES(:name, :email, :password_hash)');
        // ربط القيم
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password_hash', $data['password_hash']);

        // تنفيذ الاستعلام
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * البحث عن مستخدم عن طريق البريد الإلكتروني
     * @param string $email البريد الإلكتروني للبحث عنه
     * @return mixed User object if found, false otherwise.
     */
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }

    public function login($email, $password){
        $user = $this->findUserByEmail($email);

        if($user === false){
            return false;
        }

        $hashed_password = $user->password_hash;
        if(password_verify($password, $hashed_password)){
            return $user;
        } else {
            return false;
        }
    }
}