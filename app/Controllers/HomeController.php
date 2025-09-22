<?php
class HomeController extends Controller {
    public function index(){
        $data = [
            'title' => 'أهلاً بك',
            'description' => 'هذه هي الصفحة الرئيسية لنظام إدارة الأعمال.'
        ];
        $this->view('home/index', $data);
    }
}