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
    $checkPermission = checkPermission($permissionData, 'portfolios', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền nhân bản Dự Án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $portfolioId = $body['id'];
      $portfolioDetail = firstRaw("SELECT * FROM portfolios WHERE id = $portfolioId");
      $mapping = getRaw('SELECT category_id FROM portfolio_category_mapping WHERE portfolio_id = '.$portfolioId);
      if(!empty($portfolioDetail)) {
         $duplicate = $portfolioDetail['duplicate'];
         $duplicate++;
         $portfolioDetail['duplicate'] = 0;
         $portfolioDetail['user_id'] = isLogin()['user_id'];
         $portfolioDetail['create_at'] = date('Y-m-d H:i:s');
         $portfolioDetail['name'] .="($duplicate)"; 
         $portfolioDetail['slug'] .="$duplicate"; 

         unset($portfolioDetail['update_at']);
         unset($portfolioDetail['id']);

         $insertStatus = insert('portfolios', $portfolioDetail);
         if($insertStatus) {
            $id = insertId();
            foreach($mapping as $map) {
               $dataInsert = [
                  'portfolio_id' => $id,
                  'category_id' => $map['category_id'],
                  'user_id' => isLogin()['user_id'],
                  'create_at' => date('Y-m-d H:i:s')
               ];
               insert('portfolio_category_mapping', $dataInsert);
            }
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('portfolios', [
               'duplicate' => $duplicate
            ], 'id='.$portfolioId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
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