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
    $checkPermission = checkPermission($permissionData, 'contact_types', 'delete');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền xóa Loại liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $typeId = $body['id'];
      $typeDetailRows = getRows("SELECT id FROM contact_types WHERE id = $typeId");
      if($typeDetailRows > 0) {
         $contactRows = getRows("SELECT id FROM contacts WHERE type_id = $typeId");
         if($contactRows > 0) {
            setFlashData('msg',"Không thể xóa phòng ban, còn $contactRows liên hệ trong nhóm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('contact_types', "id = $typeId");
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
redirect('admin/?module=contact_types');