<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng đăng xuất
 */

 if(isLogin()) {
   $token = getSession('login_token');
   delete('login_token', "token = '$token'");
   removeSession('login_token');
   redirect('admin?module=auth&action=login');   
 }