<?php
session_start();
ob_start();
require_once '../config.php';
//import phpmailer libs
require_once '../includes/phpmailer/Exception.php';
require_once '../includes/phpmailer/PHPMailer.php';
require_once '../includes/phpmailer/SMTP.php';

require_once '../includes/functions.php';
require_once '../includes/permalink.php';
require_once '../includes/connect.php';
require_once '../includes/database.php';
require_once '../includes/session.php';

//

// CHỨC NĂNG ĐIỀU HƯỚNG MODULE (ROUTES)
// lấy config 
$module = _MODULE_DEFAULT_ADMIN;
$action = _ACTION_DEFAULT;

//Xử lý khi có lỗi
set_error_handler("setErrorHandler");

//xử lý khi có exception
set_exception_handler("setExceptionError");
loadExceptionError();
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
   $exception = getSession('debug_error');
   require_once _WEB_PATH_ROOT.'/modules/errors/404.php';
}