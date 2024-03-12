<?php
if(!defined('_INCODE')) die('Access denied...');
if(!isLogin()) {
   redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
 $group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
 $isRoot = !empty($group['root']) ? $group['root'] : false;
 if($isRoot) {
    $checkPermission = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'services', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền nhân bản Dịch vụ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
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