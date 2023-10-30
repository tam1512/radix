<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $categoryId = $body['id'];
      $categoryDetail = firstRaw("SELECT * FROM portfolio_categories WHERE id = $categoryId");
      if(!empty($categoryDetail)) {
         $duplicate = $categoryDetail['duplicate'];
         $duplicate++;
         $categoryDetail['duplicate'] = 0;
         $categoryDetail['user_id'] = isLogin()['user_id'];
         $categoryDetail['create_at'] = date('Y-m-d H:i:s');
         $categoryDetail['name'] .="($duplicate)"; 

         unset($categoryDetail['update_at']);
         unset($categoryDetail['id']);

         $insertStatus = insert('portfolio_categories', $categoryDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('portfolio_categories', [
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
redirect('admin/?module=portfolio_categories');