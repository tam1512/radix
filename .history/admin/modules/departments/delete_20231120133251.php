<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa người dùng
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $departmentId = $body['id'];
      $departmentDetailRows = getRows("SELECT id FROM departments WHERE id = $departmentId");
      if($departmentDetailRows > 0) {
         $contactRows = getRows("SELECT id FROM contacts WHERE department_id = $departmentId");
         if($contactRows > 0) {
            setFlashData('msg',"Không thể xóa phòng ban, còn $contactRows liên hệ trong nhóm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('departments', "id = $departmentId");
            if($deleteGroup) {
               setFlashData('msg','Xóa thành công');
               setFlashData('msg_type', 'success');
            } else {
               setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
               setFlashData('msg_type', 'danger');
            }
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
redirect('admin/?module=departments');