<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa người dùng
 */
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
    $checkPermission = checkPermission($permissionData, 'groups', 'add');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Thêm Nhóm Người Dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $groupId = $body['id'];
      $groupDetailRows = getRows("SELECT id FROM groups WHERE id = $groupId");
      if($groupDetailRows > 0) {
         $userRows = getRows("SELECT id FROM users WHERE group_id = $groupId");
         if($userRows > 0) {
            setFlashData('msg',"Không thể xóa nhóm, còn $userRows người dùng trong nhóm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('groups', "id = $groupId");
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
redirect('admin/?module=groups');