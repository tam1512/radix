<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng đăng xuất
 */

 if(isLogin()) {
   $token = getSession('login_token');
   delete('login_token', "token = '$token'");
   removeSession('login_token');
   setFlashData('msg', '');
   setFlashData('msg_type', '');
   redirect('admin?module=auth&action=login');   
 }