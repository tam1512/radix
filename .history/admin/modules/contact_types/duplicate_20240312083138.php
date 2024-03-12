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
    $checkPermission = checkPermission($permissionData, 'contact_types', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền nhân bản Loại liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
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