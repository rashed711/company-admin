<?php
class UsersController extends Controller {

    public function __construct() {
        // تحميل المودل الخاص بالمستخدمين
        $this->userModel = $this->model('User');
    }

    public function register() {
        // التحقق إذا كان الطلب من نوع POST (أي تم إرسال الفورم)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // تنظيف البيانات القادمة من الفورم
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // التحقق من صحة الإيميل
            if (empty($data['email'])) {
                $data['email_err'] = 'الرجاء إدخال البريد الإلكتروني';
            } else {
                // التحقق إذا كان الإيميل مسجل من قبل
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'هذا البريد الإلكتروني مسجل بالفعل';
                }
            }

            // التحقق من صحة الاسم
            if (empty($data['name'])) {
                $data['name_err'] = 'الرجاء إدخال الاسم';
            }

            // التحقق من كلمة المرور
            if (empty($data['password'])) {
                $data['password_err'] = 'الرجاء إدخال كلمة المرور';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
            }

            // التحقق من تطابق كلمة المرور
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'الرجاء تأكيد كلمة المرور';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'كلمتا المرور غير متطابقتين';
                }
            }

            // التأكد من عدم وجود أخطاء قبل المتابعة
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // تشفير كلمة المرور
                $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // تسجيل المستخدم عبر المودل
                if ($this->userModel->register($data)) {
                    flash('register_success', 'تم تسجيلك بنجاح، يمكنك الآن تسجيل الدخول');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // إذا كانت هناك أخطاء، أعد تحميل الفورم مع عرض الأخطاء
                $this->view('users/register', $data);
            }

        } else {
            // إذا كان الطلب GET, فقط قم بعرض الفورم
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => ''
            ];
            // تحميل الـ View
            $this->view('users/register', $data);
        }
    }

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data =[
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',      
            ];

            // Validate Email & Password
            if(empty($data['email'])) $data['email_err'] = 'الرجاء إدخال البريد الإلكتروني';
            if(empty($data['password'])) $data['password_err'] = 'الرجاء إدخال كلمة المرور';

            // Check for user/email
            if(empty($data['email_err']) && empty($data['password_err'])){
                if(!$this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'البريد الإلكتروني غير مسجل';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                // Validated, attempt to login
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'كلمة المرور غير صحيحة';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }

        } else {
            // Init data for GET request
            $data =['email' => '', 'password' => '', 'email_err' => '', 'password_err' => ''];
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('dashboard');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }
}