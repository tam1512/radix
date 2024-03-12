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
    $checkPermission = checkPermission($permissionData, 'contact_types', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền chỉnh sửa Loại liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
if(isGet()) {
   $typeId = trim(getBody()['id']);
   
   if(!empty($typeId)) {
      $defaultCategory = firstRaw("SELECT * FROM contact_types WHERE id = '$typeId'");
      setFlashData('defaultCategory', $defaultCategory);
   } else {
      redirect("admin/?module=contact_types");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $typeId = trim($body['id']);
   
   if(empty($name)) {
      $errors['name']['required'] = 'Tên phòng ban không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('contact_types', $dataUpdate, "id=$typeId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa phòng ban thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=contact_types');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=contact_types&action=lists&view=edit&id=$typeId");
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

<h4>Chỉnh sửa phòng ban</h4>
<form action="" method="post">
   <div class="form-group">
      <input type="text" name="name" id="name" class="form-control" placeholder="Tên phòng ban..."
         value="<?php echo old('name', $old) ?>">
      <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
   </div>
   <input type="hidden" name="id" value="<?php echo $typeId ?>">
   <button class="btn btn-primary" type="submit">Cập nhật</button>
   <a href="<?php echo getLinkAdmin('contact_types') ?>" class="btn btn-success" type="submit">Quay lại</a>
   <hr>
</form>