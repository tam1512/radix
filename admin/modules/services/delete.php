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
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'services', 'delete');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền xóa Dịch vụ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $serviceId = $body['id'];
      $serviceDetailRows = getRows("SELECT id FROM services WHERE id = $serviceId");
      if($serviceDetailRows > 0) {
         $deleteservice = delete('services', "id = $serviceId");
         if($deleteservice) {
            setFlashData('msg','Xóa thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
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