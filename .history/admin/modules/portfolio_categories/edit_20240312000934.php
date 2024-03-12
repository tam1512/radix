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
    $checkPermission = checkPermission($permissionData, 'portfolio_categories', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý dự án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 

if(isGet()) {
   $categoryId = trim(getBody()['id']);
   
   if(!empty($categoryId)) {
      $defaultCategory = firstRaw("SELECT * FROM portfolio_categories WHERE id = '$categoryId'");
      setFlashData('defaultCategory', $defaultCategory);
   } else {
      redirect("admin/?module=portfolio_categories");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $categoryId = trim($body['id']);
   
   if(empty($name)) {
      $errors['name']['required'] = 'Tên danh mục không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('portfolio_categories', $dataUpdate, "id=$categoryId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa danh mục thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=portfolio_categories');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=portfolio_categories&action=lists&view=edit&id=$categoryId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultCategory = getFlashData('defaultCategory');
if(!empty($defaultCategory)) {
   $old = $defaultCategory;
}
 ?>

<h4>Chỉnh sửa danh mục</h4>
<form action="" method="post">
   <div class="form-group">
      <input type="text" name="name" class="form-control" placeholder="Tên danh mục..."
         value="<?php echo old('name', $old) ?>">
      <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
   </div>
   <input type="hidden" name="id" value="<?php echo $categoryId ?>">
   <button class="btn btn-primary" type="submit">Cập nhật</button>
   <a href="<?php echo getLinkAdmin('portfolio_categories') ?>" class="btn btn-success" type="submit">Quay lại</a>
   <hr>
</form>