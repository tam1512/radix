<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng đăng xuất
 */
 if(isLogin()) {
  $user_id = isLogin()['user_id'];
  delete('login_token', "user_id=$user_id");
  setcookie('user_id', $user_id, time()-60, '/');
  removeSession('login_token');
  if(!empty($_SERVER["HTTP_REFERER"])) {
    redirect($_SERVER["HTTP_REFERER"], true);   
  } else {
    redirect('admin?module=auth&action=login');   
  }
}