<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $subscribeId = $body['id'];
      $subscribeDetailRows = getRows("SELECT id FROM subscribe WHERE id = $subscribeId");
      if($subscribeDetailRows > 0) {
         $statusDelete = delete('subscribe', "id = $subscribeId");

         if($statusDelete) {
            setFlashData('msg','Xóa thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Đăng ký không tồn tại');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Đăng ký không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=subscribe');