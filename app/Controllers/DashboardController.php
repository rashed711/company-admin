<?php
class DashboardController extends Controller {
    public function __construct(){
        // حماية هذا الـ Controller
        // إذا لم يكن المستخدم مسجل دخوله، سيتم توجيهه لصفحة الدخول
        if(!isLoggedIn()){
            redirect('users/login');
        }
    }

    public function index(){
        $data = [
            'title' => 'لوحة التحكم',
            'description' => 'أهلاً بك في نظام إدارة الأعمال. هذه هي صفحتك الرئيسية المحمية.'
        ];
        $this->view('dashboard/index', $data);
    }
}