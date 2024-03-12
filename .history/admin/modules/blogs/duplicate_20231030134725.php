<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $blogId = $body['id'];
      $blogDetail = firstRaw("SELECT * FROM blogs WHERE id = $blogId");
      if(!empty($blogDetail)) {
         $duplicate = $blogDetail['duplicate'];
         $duplicate++;
         $blogDetail['duplicate'] = 0;
         $blogDetail['user_id'] = isLogin()['user_id'];
         $blogDetail['create_at'] = date('Y-m-d H:i:s');
         $blogDetail['title'] .="($duplicate)"; 
         $blogDetail['slug'] .="$duplicate"; 

         unset($blogDetail['update_at']);
         unset($blogDetail['id']);

         $insertStatus = insert('blogs', $blogDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('blogs', [
               'duplicate' => $duplicate
            ], 'id='.$blogId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Blog không tồn tại');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=blogs');