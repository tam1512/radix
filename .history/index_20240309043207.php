<?php
session_start();
ob_start();
require_once 'config.php';
require_once 'route.php';
//import phpmailer libs
require_once 'includes/phpmailer/Exception.php';
require_once 'includes/phpmailer/PHPMailer.php';
require_once 'includes/phpmailer/SMTP.php';

require_once 'includes/functions.php';
require_once 'includes/connect.php';
require_once 'includes/database.php';
require_once 'includes/session.php';



// CHỨC NĂNG ĐIỀU HƯỚNG MODULE (ROUTES)

// lấy config 
$module = _MODULE_DEFAULT;
$action = _ACTION_DEFAULT;

//Xử lý khi có lỗi
set_error_handler("setErrorHandler");

//xử lý khi có exception
set_exception_handler("setExceptionError");
loadExceptionError();

//Xử lý rewrite url
$currentUrl = null;
if(empty($_GET['module'])) {
   $currentUrl = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
}


if($currentUrl != '/') {
   $currentUrl = trim($currentUrl,'/');
}

$targetUrl = null;
if(!empty($route)) {
   foreach($route as $key=>$item) {
      if(preg_match('~^'.$key.'$~i', $currentUrl)) {
         $targetUrl = preg_replace('~^'.$key.'$~i', $item, $currentUrl);
         break;
      }
   }
}


if(!empty($targetUrl)) {
   $targetUrlArr = parse_url($targetUrl);
   if(!empty($targetUrlArr['query'])) {
      $targetUrlQuery = $targetUrlArr['query'];
      $targetUrlQueryArr = array_filter(explode('&', $targetUrlQuery));
      if(!empty($targetUrlQueryArr)) {
         foreach($targetUrlQueryArr as $item) {
            $itemArr = array_filter(explode('=', $item));
            $_GET[$itemArr[0]] = $itemArr[1];
         }
      }
   } 
} else {
   require_once 'modules/errors/404.php';
   die();
}

// lẩy module từ $_GET không có giá trị thì dùng mặc định
if(!empty($_GET["module"])) {
   if(is_string($_GET["module"])) {
      $module = trim($_GET["module"]);
   }
}

// lẩy action từ $_GET không có giá trị thì dùng mặc định
if(!empty($_GET["action"])) {
   if(is_string($_GET["action"])) {
      $action = trim($_GET["action"]);
   }
}

$path = "./modules/$module/$action.php";

// nếu file tồn tại thì hiển thị lên index.php
if(file_exists($path)) {
   require_once($path);
} else {
   require_once 'modules/errors/404.php';
}