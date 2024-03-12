<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $typeId = $body['id'];
      $typeDetail = firstRaw("SELECT * FROM contact_types WHERE id = $typeId");
      if(!empty($typeDetail)) {
         $duplicate = $typeDetail['duplicate'];
         $duplicate++;
         $typeDetail['duplicate'] = 0;
         $typeDetail['user_id'] = isLogin()['user_id'];
         $typeDetail['create_at'] = date('Y-m-d H:i:s');
         $typeDetail['name'] .="($duplicate)"; 

         unset($typeDetail['update_at']);
         unset($typeDetail['id']);

         $insertStatus = insert('contact_types', $typeDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('contact_types', [
               'duplicate' => $duplicate
            ], 'id='.$typeId);
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
redirect('admin/?module=contact_types');