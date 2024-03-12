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
    $checkPermission = checkPermission($permissionData, 'pages', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền nhân bản trang');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $pageId = $body['id'];
      $pageDetail = firstRaw("SELECT * FROM pages WHERE id = $pageId");
      if(!empty($pageDetail)) {
         $duplicate = $pageDetail['duplicate'];
         $duplicate++;
         $pageDetail['duplicate'] = 0;
         $pageDetail['user_id'] = isLogin()['user_id'];
         $pageDetail['create_at'] = date('Y-m-d H:i:s');
         $pageDetail['title'] .="($duplicate)"; 

         unset($pageDetail['update_at']);
         unset($pageDetail['id']);

         $insertStatus = insert('pages', $pageDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('pages', [
               'duplicate' => $duplicate
            ], 'id='.$pageId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Trang không tồn tại');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=pages');