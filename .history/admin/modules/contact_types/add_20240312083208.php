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
    $isEdit = true;
    $isDelete = true;
    $isAdd = true;
    $isDuplicate = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'contact_types', 'lists');
    $isEdit = checkPermission($permissionData, 'contact_types', 'edit');
    $isDelete = checkPermission($permissionData, 'contact_types', 'delete');
    $isAdd = checkPermission($permissionData, 'contact_types', 'add');
    $isDuplicate = checkPermission($permissionData, 'contact_types', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Loại liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }

 $userId = isLogin()['user_id'];

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên nhóm không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'user_id' => $userId,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('contact_types', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm phòng ban thành công.');
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
      redirect('admin/?module=contact_types');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

 ?>

<h4>Thêm phòng ban</h4>
<form action="" method="post">
   <div class="form-group">
      <input type="text" name="name" id="name" class="form-control" placeholder="Tên phòng ban..."
         value="<?php echo old('name', $old) ?>">
      <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
   </div>
   <button type="submit" class="btn btn-success">Thêm</button>
</form>