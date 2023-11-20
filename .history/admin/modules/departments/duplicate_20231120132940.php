<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $categoryId = $body['id'];
      $categoryDetail = firstRaw("SELECT * FROM department WHERE id = $categoryId");
      if(!empty($categoryDetail)) {
         $duplicate = $categoryDetail['duplicate'];
         $duplicate++;
         $categoryDetail['duplicate'] = 0;
         $categoryDetail['user_id'] = isLogin()['user_id'];
         $categoryDetail['create_at'] = date('Y-m-d H:i:s');
         $categoryDetail['name'] .="($duplicate)"; 
         $categoryDetail['slug'] .="$duplicate"; 

         unset($categoryDetail['update_at']);
         unset($categoryDetail['id']);

         $insertStatus = insert('department', $categoryDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('department', [
               'duplicate' => $duplicate
            ], 'id='.$categoryId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Danh mục không tồn tại');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=department');