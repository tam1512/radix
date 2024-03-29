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
    $checkPermission = checkPermission($permissionData, 'groups', 'add');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Thêm Nhóm Người Dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }

$data = [
   'title' => 'Thêm nhóm người dùng'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form
   $root = !empty(trim($body['root'])) ? trim($body['root']) : 0;

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
         'root' => $root,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('groups', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm nhóm tài khoản thành công.');
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
      redirect('admin/?module=groups&action=add');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

 ?>

<div class="container-fluid">
   <div class="row">
      <div class="col">

         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label for="name">Tên nhóm người dùng</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên nhóm người dùng..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <?php if($isRoot): ?>
                  <div class="form-group row">
                     <div class="col-12">
                        <div class="form-check d-flex align-item-center">
                           <input class="form-check-input" type="checkbox" id="root" name="root" value="1">
                           <label class="form-check-label ml-2" for="root">
                              Phân quyền cao nhất
                           </label>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Thêm nhóm người dùng</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>