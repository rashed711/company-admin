<?php
// app/Core/Controller.php

class Controller {
    // تحميل الـ Model
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        return new $model();
    }

    // تحميل الـ View
    public function view($view, $data = []) {
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}