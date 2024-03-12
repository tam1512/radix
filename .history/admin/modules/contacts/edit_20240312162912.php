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
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'contacts', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền chỉnh sửa liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
$data = [
   'title' => 'Sửa thông tin liên hệ'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $listAllContactTypes = getRaw("SELECT id, name FROM contact_types");
 $listStatus = [
   1 => 'Chưa xử lý',
   2 => 'Đang xử lý',
   3 => 'Đã xử lý'
 ];
 
 if(isGet()) {
   $id = getBody("get")['id'];
   $defaultContact = firstRaw("SELECT * FROM contacts WHERE id = $id");
   $fullname = $defaultContact['fullname'];
   $email = $defaultContact['email'];
   $message = $defaultContact['message'];
   setFlashData('defaultContact', $defaultContact);
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = trim($body['id']);
   $note = trim($body['note']);
   $typeId = trim($body['type_id']);
   $status = trim($body['status']);


   if(empty($typeId)) {
      $errors['type_id']['required'] = 'Vui lòng chọn phòng ban';
   } 

   if(empty($status)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'type_id' => $typeId,
         'note' => $note,
         'status' => $status,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('contacts', $dataUpdate, "id = $id");
      if($updateStatus) {
            setFlashData('msg', 'Sửa thông tin liên hệ thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=contacts');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=contacts&action=edit&id='.$id);
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultContact = getFlashData('defaultContact');
if(empty($old)) {
   $old = $defaultContact;
}
 ?>

<div class="container">
   <div class="row">
      <div class="col">

         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="fullname">Họ tên khách hàng:</label>
                     <input type="text" id="name" name="fullname" class="form-control" disabled
                        placeholder="Họ tên khách hàng..." value="<?php echo $fullname ?>">
                  </div>
                  <div class="form-group">
                     <label for="email">Email khách hàng:</label>
                     <input type="text" id="name" name="email" class="form-control" disabled
                        placeholder="Email khách hàng..." value="<?php echo $email ?>">
                  </div>
                  <div class="form-group">
                     <label for="message">Nội dung:</label>
                     <input type="text" id="name" name="message" class="form-control" disabled placeholder="Nội dung..."
                        value="<?php echo $message ?>">
                  </div>
                  <div class="form-group">
                     <label for="type_id">Danh sách phòng ban</label>
                     <select name="type_id" id="type_id" class="form-control">
                        <option value="0">Chọn phòng ban</option>
                        <?php 
                           if(!empty($listAllContactTypes)):
                              foreach($listAllContactTypes as $department):
                        ?>
                        <option value="<?php echo $department['id'] ?>"
                           <?php echo (!empty($old['type_id']) && $old['type_id'] == $department['id']) ? "selected" : false ?>>
                           <?php echo $department['name'] ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('type_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="status">Tình trạng</label>
                     <select name="status" id="status" class="form-control">
                        <option value="0">Chọn tình trạng</option>
                        <?php 
                           if(!empty($listStatus)):
                              foreach($listStatus as $key => $value):
                        ?>
                        <option value="<?php echo $key ?>" <?php echo ($old['status'] == $key) ? "selected" : false ?>>
                           <?php echo $value ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('status', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="note">Ghi chú</label>
                     <textarea name="note" id="note" placeholder="Ghi chú..."
                        class="form-control"><?php echo old('note', $old) ?></textarea>
                     <?php echo form_error('note', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <input type="hidden" name="modules" value="contacts">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="btn btn-primary" type="submit">Chỉnh sửa</button>
            <a class="btn btn-success" href="<?php echo getLinkPrevPage() ?>">Quay lại</a>
         </form>
         <br>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>