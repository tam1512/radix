<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $serviceId = $body['id'];
      $serviceDetail = firstRaw("SELECT * FROM services WHERE id = $serviceId");
      if(!empty($serviceDetail)) {
         $duplicate = $serviceDetail['duplicate'];
         $duplicate++;
         $serviceDetail['duplicate'] = 0;
         $serviceDetail['user_id'] = isLogin()['user_id'];
         $serviceDetail['create_at'] = date('Y-m-d H:i:s');
         $serviceDetail['name'] .="($duplicate)"; 

         unset($serviceDetail['update_at']);
         unset($serviceDetail['id']);

         $insertStatus = insert('services', $serviceDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('services', [
               'duplicate' => $duplicate
            ], 'id='.$serviceId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Dịch vụ không tồn tại');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=services');