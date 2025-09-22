<?php
// app/bootstrap.php

// Start Session
session_start();

// Load Config
require_once '../config/config.php';

// Load Helpers
require_once 'helpers/url_helper.php'; // Assumed to exist for redirect()
require_once 'helpers/session_helper.php';
require_once 'helpers/permission_helper.php'; // Our new helper

// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'Core/' . $className . '.php';
});