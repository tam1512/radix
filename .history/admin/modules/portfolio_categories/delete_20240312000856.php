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
    $checkPermission = checkPermission($permissionData, 'portfolios', 'delete');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý dự án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $categoryId = $body['id'];
      $categoryDetailRows = getRows("SELECT id FROM portfolio_categories WHERE id = $categoryId");
      if($categoryDetailRows > 0) {
         $portfolioRows = getRows("SELECT category_id FROM portfolio_category_mapping WHERE category_id = $categoryId");
         if($portfolioRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $portfolioRows dự án trong nhóm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('portfolio_categories', "id = $categoryId");
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
redirect('admin/?module=portfolio_categories');