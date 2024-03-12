<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
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
    $checkPermission = checkPermission($permissionData, 'groups', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Sửa Nhóm Người Dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }



$data = [
   'title' => 'Chỉnh sửa tài khoản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý đăng ký

if(isGet()) {
   $groupId = trim(getBody()['id']);
   
   if(!empty($groupId)) {
      $defaultGroup = firstRaw("SELECT name, root FROM groups WHERE id = '$groupId'");
      setFlashData('defaultGroup', $defaultGroup);
   } else {
      redirect("admin/?module=groups");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $root = !empty(trim($body['root'])) ? trim($body['root']) : 0;
   $groupId = trim($body['id']);
   if(empty($name)) {
      $errors['name']['required'] = 'Nhóm người dùng không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'root' => $root,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('groups', $dataUpdate, "id=$groupId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa nhóm người dùng thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=groups');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=groups&action=edit&id=$groupId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultGroup = getFlashData('defaultGroup');
if(!empty($defaultGroup)) {
   $old = $defaultGroup;
}
 ?>

<div class="container-fluid">
   <div class="row">
      <div class="col">
         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="name">Tên nhóm người dùng</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên nhóm người dùng..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <?php if($isRoot): ?>
                  <div class="form-group row">
                     <div class="col-sm-12">
                        <div class="form-check d-flex align-item-center">
                           <input class="form-check-input" type="checkbox" id="root" name="root" value="1"
                              <?php echo ($old['root'] == 1) ? "checked" : false ?>>
                           <label class="form-check-label ml-2" for="root">
                              Phân quyền cao nhất
                           </label>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
                  <input type="hidden" name="id" value="<?php echo $groupId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a href="<?php echo getLinkPrevPage() ?>" class="btn btn-success" type="submit">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>