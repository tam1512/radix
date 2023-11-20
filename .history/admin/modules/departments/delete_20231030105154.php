<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa người dùng
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $categoryId = $body['id'];
      $categoryDetailRows = getRows("SELECT id FROM blog_categories WHERE id = $categoryId");
      if($categoryDetailRows > 0) {
         $blogRows = getRows("SELECT id FROM blogs WHERE category_id = $categoryId");
         if($blogRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $blogRows dự án trong nhóm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('blog_categories', "id = $categoryId");
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
redirect('admin/?module=blog_categories');