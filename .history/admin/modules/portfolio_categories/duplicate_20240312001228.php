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
    $checkPermission = checkPermission($permissionData, 'portfolio_categories', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền nhân bản Danh mục dự án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $categoryId = $body['id'];
      $categoryDetail = firstRaw("SELECT * FROM portfolio_categories WHERE id = $categoryId");
      if(!empty($categoryDetail)) {
         $duplicate = $categoryDetail['duplicate'];
         $duplicate++;
         $categoryDetail['duplicate'] = 0;
         $categoryDetail['user_id'] = isLogin()['user_id'];
         $categoryDetail['create_at'] = date('Y-m-d H:i:s');
         $categoryDetail['name'] .="($duplicate)"; 

         unset($categoryDetail['update_at']);
         unset($categoryDetail['id']);

         $insertStatus = insert('portfolio_categories', $categoryDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('portfolio_categories', [
               'duplicate' => $duplicate
            ], 'id='.$categoryId);
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
redirect('admin/?module=portfolio_categories');