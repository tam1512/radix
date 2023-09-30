<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
 */
$data = [
   'title' => 'Chỉnh sửa tài khoản'
];

 layout('header', $data);

 // Xử lý đăng ký

if(isGet()) {
   $userId = trim(getBody()['id']);
   
   if(!empty($userId)) {
      $defaultUser = firstRaw("SELECT fullname, email, phone, status, per_id FROM users WHERE id = '$userId'");
      setFlashData('defaultUser', $defaultUser);
   } else {
      redirect("?module=users");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $fullname = trim($body['fullname']);
   $phone = trim($body['phone']);
   $email = trim($body['email']);
   $password = trim($body['password']);
   $confirm_password = trim($body['confirm_password']);
   $status = trim($body['status']);
   $per_id = trim($body['per_id']);
   $userId = trim($body['id']);
   // Validate họ tên: bắt buộc nhập, >= 5 ký tự
   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ và tên không được để trống';
   } else if (strlen($fullname) < 5) {
      $errors['fullname']['min'] = 'Họ và tên tối thiểu phải có 5 ký tự';
   }

   //Validate phone: không được bỏ trống, là số điện thoại
   if(empty($phone)) {
      $errors['phone']['required'] = 'Số điện thoại không được để trống';
   } else if(!isPhone($phone)) {
      $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ';
   }

   //Validate email: không được bỏ trống, là email, email phải là duy nhất
   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else {
      if(!isEmail($email)) {
         $errors['email']['invalid'] = 'Địa chỉ email không hợp lệ';
      } else {
         $sql = "SELECT id FROM users WHERE email = '$email' AND id <> $userId";
         if(getRows($sql) > 0) {
            $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
         }
      }
   }

   if(!empty($password)) {
      if (strlen($password) < 8) {
         $errors['password']['min'] = 'Mật khẩu tối thiểu phải có 8 ký tự';
      } else {
         // Validate nhập lại mật khẩu: bắt buộc nhập, trùng với mật khẩu
         if(empty($confirm_password)) {
            $errors['confirm_password']['required'] = 'Nhập lại mật khẩu không được để trống';
         } else if ($password !== $confirm_password)  {
            $errors['confirm_password']['match'] = 'Mật khẩu không trùng khớp';
         }
      }
   } 

   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'email' => $email,
         'fullname' => $fullname,
         'phone' => $phone,
         'updateAt' => date('Y-m-d H:i:s'),
         'status' => $status,
         'per_id' => $per_id,
      ];
      if(!empty($password)) {
         $dataUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
      }

      $updateStatus = update('users', $dataUpdate, "id=$userId");
      if($updateStatus) {
            setFlashData('message', 'Chỉnh sửa tài khoản thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('message', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('?module=users');
      
   } else {
      setFlashData('message', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("?module=users&action=edit&id=$userId");
   }
}

// Cấp bậc quyền
$level = $_COOKIE['level'];

// Nên phát triển dựa trên csdl

//Mảng cấp bậc quyền và các mã quyền được set trong csdl
$levelArr= [
   1 => [1, 2, 3, 4],
   2 => [1, 2, 3],
   3 => [1, 2, 3, 4],
   4 => [1, 3]
];

// Mảng quyền trong csdl
$permission = [
   1 => 'Chỉ đọc',
   2 => 'Chỉnh sửa và xóa',
   3 => 'Chỉnh sửa',
   4 => 'Toàn quyền'
];

$message = getFlashData('message');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultUser = getFlashData('defaultUser');
if(!empty($defaultUser)) {
   $old = $defaultUser;
}
$userIdCookie = $_COOKIE['userId'];

 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <h3 class="text-center text-uppercase">Sửa tài khoản</h3>

         <?php 
            getMsg($message, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="fullname">Họ tên</label>
                     <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ tên..."
                        value="<?php echo old('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="phone">Số điện thoại</label>
                     <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại..."
                        value="<?php echo old('phone', $old) ?>">
                     <?php echo form_error('phone', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="text" id="email" name="email" class="form-control" placeholder="Địa chỉ email..."
                        value="<?php echo old('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="per_id">Quyền</label>
                     <select name="per_id" id="per_id" class="form-control">
                        <?php 
                           if(!empty($level)) {
                              foreach($levelArr as $key => $value) {
                                 if($level == $key) {
                                    foreach($value as $item) {
                                       echo '<option value="'.$item.'"';
                                       echo (!empty($defaultUser['per_id']) && $defaultUser['per_id'] == $item) ? 'selected' :  null;
                                       echo '>';
                                       echo $permission[$item];
                                       echo '</option>';
                                    }
                                    break;
                                 }
                              }
                           }

                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="password">Mật khẩu</label>
                     <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu"
                        value="<?php echo old('password', $old) ?>">
                     <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="confirm_password">Nhập lại mật khẩu</label>
                     <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        placeholder="Nhập lại mật khẩu" value="<?php echo old('confirm_password', $old) ?>">
                     <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="status">Tình trạng</label>
                     <select name="status" id="status" class="form-control">
                        <option value="0"
                           <?php echo (!empty($old['status']) && $old['status'] == 0) ? 'selected' :  false?>>Chưa kích
                           hoạt
                        </option>
                        <option value="1"
                           <?php echo (!empty($old['status']) && $old['status'] == 1) ? 'selected' : false ?>>Kích hoạt
                        </option>
                     </select>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $userId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa tài khoản</button>
            <a href="<?php echo '?module=users' ?>" class="btn btn-success">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer');
 ?>