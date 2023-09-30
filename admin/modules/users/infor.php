<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng hiển thị thông tin người dùng
 */
$data = [
   'title' => 'Thông tin người dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');

 // Xử lý lấy ra thông tin người dùng
 if(isGet()) {
   $userId = trim(getBody()['id']);
}

if(isPost()) {
   $errors = [];
   $userId = trim(getBody()['id']);
   $body = getBody();
   $phone = trim($body['phone']);
   $fullname = trim($body['fullname']);

   if(empty($phone)) {
      $errors['phone']['required'] = 'Số điện thoại không được để trống';
   } else {
      if(!isPhone($phone)) {
         $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ';
      }
   }

   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ tên không được để trống';
   }

   if(empty($errors)) {
      $dataUpdate = [
         'phone' => $phone,
         'fullname' => $fullname,
         'update_at' => date('Y-m-d H:i:s')
      ];

      $updateStatus = update('users', $dataUpdate, "id = $userId");
      if($updateStatus) {
         setFlashData('msg', 'Chỉnh sửa thông tin tài khoản thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=users&action=infor&id='.$userId);
   }
}

   
if(!empty($userId)) {
   $userDefault = firstRaw("SELECT * FROM users WHERE id = '$userId'");
   setFlashData('userDefault', $userDefault);
} else {
   redirect("admin");
}


$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$infor = getFlashData('userDefault');
if(!empty($old)) {
   $infor['fullname'] = $old['fullname'];
   $infor['phone'] = $old['phone'];
} 

// Mảng quyền trong csdl
$permission = [
   1 => 'Chỉ đọc',
   2 => 'Chỉnh sửa và xóa',
   3 => 'Chỉnh sửa',
   4 => 'Toàn quyền'
];
?>
<hr>
<div class="container mt-5">
   <?php getMsg($message, $msgType) ?>
   <div class="card">
      <div class="card-header">
         <h3>Thông tin người dùng</h3>
      </div>
      <div class="card-body">
         <form action="" method="POST">

            <div class="form-group">
               <label>Email:</label>
               <input type="text" class="form-control" value="<?php echo form_infor('email', $infor) ?>" readonly>
            </div>
            <div class="form-group">
               <label>Số điện thoại:</label>
               <input type="text" name="phone" class="form-control" value="<?php echo form_infor('phone', $infor) ?>">
               <?php echo form_error('phone', $errors, '<span class="error">', '</span>') ?>
            </div>
            <div class="form-group">
               <label>Họ tên đầy đủ:</label>
               <input type="text" name="fullname" class="form-control"
                  value="<?php echo form_infor('fullname', $infor) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
            </div>
            <!-- <div class="form-group">
               <label>Quyền hạn:</label>
               <input type="text" class="form-control" value="<?php echo $permission[form_infor('per_id', $infor)] ?>"
                  readonly>
            </div> -->
            <div class="form-group">
               <label>Trạng thái tài khoản:</label>
               <input type="text" class="form-control"
                  value="<?php echo form_infor('status', $infor) == 0 ? 'Chưa kích hoạt' : 'Kích hoạt' ?>" readonly>
            </div>
            <div class="form-group">
               <label>Ngày tạo:</label>
               <input type="text" class="form-control"
                  value="<?php echo date('d-m-Y', strtotime(form_infor('create_at', $infor))) ?>" readonly>
            </div>
            <div class="form-group">
               <label>Ngày cập nhật gần nhất:</label>
               <input type="text" class="form-control"
                  value="<?php echo form_infor('update_at', $infor) ? date('d-m-Y', strtotime(form_infor('update_at', $infor))) :'Chưa sử dụng chức năng cập nhật' ?>"
                  readonly>
            </div>
            <input type="hidden" name="id" value="<?php echo $userId ?>">
            <a href="<?php echo getLinkAdmin('') ?>" class="btn btn-success btn-sm">Quay lại</a>
            <button type="submit" class="btn btn-primary btn-sm">Chỉnh sửa</a>
         </form>
      </div>
   </div>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>