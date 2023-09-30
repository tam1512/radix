<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa người dùng
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $userId = $body['id'];
      $userDetailRows = getRows("SELECT id FROM users WHERE id = $userId");
      if($userDetailRows > 0) {
         $deleteToken = delete('logintoken', "userId = $userId");
         if($deleteToken) {
            $deleteUser = delete('users', "id = $userId");
            if($deleteUser) {
               setFlashData('msg','Xóa thành công');
               setFlashData('msg_type', 'success');
            } else {
               setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
               setFlashData('msg_type', 'danger');
            }
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('?module=users');