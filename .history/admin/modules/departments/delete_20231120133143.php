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
         $blogRows = getRows("SELECT id FROM blogs WHERE department_id = $departmentId");
         if($blogRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $blogRows dự án trong nhóm này");
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