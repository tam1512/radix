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
   setFlashData('msg', 'Bạn không có quyền xóa Dự Án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $portfolioId = $body['id'];
      $portfolioDetailRows = getRows("SELECT id FROM portfolios WHERE id = $portfolioId");
      $portfolioImageRows = getRows("SELECT id FROM portfolio_images WHERE portfolio_id = $portfolioId");
      if($portfolioImageRows > 0) {
         delete('portfolio_images', "portfolio_id = $portfolioId");
      } 
      if($portfolioDetailRows > 0) {
         delete('portfolio_category_mapping', "portfolio_id = $portfolioId");
         $deletePortfolio = delete('portfolios', "id = $portfolioId");
         if($deletePortfolio) {
            setFlashData('msg','Xóa thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Dự án không tồn tại');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=portfolios');