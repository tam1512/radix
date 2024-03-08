<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $departmentId = $body['id'];
      $departmentDetail = firstRaw("SELECT * FROM departments WHERE id = $departmentId");
      if(!empty($departmentDetail)) {
         $duplicate = $departmentDetail['duplicate'];
         $duplicate++;
         $departmentDetail['duplicate'] = 0;
         $departmentDetail['user_id'] = isLogin()['user_id'];
         $departmentDetail['create_at'] = date('Y-m-d H:i:s');
         $departmentDetail['name'] .="($duplicate)"; 

         unset($departmentDetail['update_at']);
         unset($departmentDetail['id']);

         $insertStatus = insert('departments', $departmentDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('departments', [
               'duplicate' => $duplicate
            ], 'id='.$departmentId);
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
redirect('admin/?module=departments');