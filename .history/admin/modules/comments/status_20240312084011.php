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
    $checkPermission = checkPermission($permissionData, 'contact_types', 'status');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền thay đổi trạng thái Bình luận');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
if(isGet()) {
   $body = getBody('get');
   if(!empty($body['id'])) {
      $commentsId = $body['id'];

      $statusArr = [0,1];

      if(isset($body['status']) && in_array($body['status'], $statusArr)) {
         $status = $body['status'];
         if($status == 0) {
            $msg = "Duyệt";
            $dataUpdate = [
               'status' => 1
            ];
         } else {
            $msg = "Bỏ duyệt";
            $dataUpdate = [
               'status' => 0
            ];
         }

         $updateStatus = update('comments', $dataUpdate, "id = $commentsId");
         if($updateStatus) {
            setFlashData('msg',$msg.' bình luận thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Bình luận không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=comments');