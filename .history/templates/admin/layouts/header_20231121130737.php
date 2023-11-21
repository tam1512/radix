<?php 
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  setFlashData('msg', '');
  setFlashData('msg_type', '');
  redirect('admin?module=auth&action=login');
}
autoLogin();
$isLogin = autoRemoveLoginToken();
if(!$isLogin) {
   saveActivity();   
}
//  autoRemoveLoginToken();
$token = getSession('login_token');

$queryToken = firstRaw("SELECT user_id FROM login_token WHERE token = '$token'");
if(!empty($queryToken)) {
   $id = $queryToken['user_id'];
   $queryUser = firstRaw("SELECT fullname FROM users WHERE id = '$id'");
   $fullname = $queryUser['fullname'];
} else {
  setFlashData('msg', '');
  setFlashData('msg_type', '');
  redirect('admin?module=auth&action=login');
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo $data['title'].' - Quản trị Website' ?></title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php 
      head('admin');
   ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
         <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
         </ul>

         <!-- SEARCH FORM -->
         <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
               <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
               <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                     <i class="fas fa-search"></i>
                  </button>
               </div>
            </div>
         </form>

         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
               </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                     <i class="fas fa-envelope mr-2"></i> 4 new messages
                     <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                     <i class="fas fa-users mr-2"></i> 8 friend requests
                     <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                     <i class="fas fa-file mr-2"></i> 3 new reports
                     <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
               </div>
            </li>
            <!-- Information user -->
            <li class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-user">
                     Chào <?php echo ucfirst($fullname) ?>
                  </i>
               </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('users', 'profile') ?>" class="dropdown-item">
                     <i class="fa fa-info-circle mr-2"></i> Thông tin cá nhân
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('users', 'edit_pass') ?>" class="dropdown-item">
                     <i class="fa fa-cog mr-2"></i> Đổi mật khẩu
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('auth', 'logout') ?>" class="dropdown-item">
                     <i class="fa fa-sign-out-alt mr-2"></i> Đăng xuất
                  </a>
               </div>
            </li>
         </ul>
      </nav>
      <!-- /.navbar -->