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
    $checkPermission = checkPermission($permissionData, 'users', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Sửa Người Dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
$data = [
   'title' => 'Chỉnh sửa thông tin người dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$listAllGroups = getRaw("SELECT id, name FROM groups");

if(isGet()) {
   $userId = getBody()['id'];
   $userDetailt = firstRaw("SELECT * FROM users WHERE id = $userId");
   setFlashData('userDetailt', $userDetailt); 
}

if(isPost()) {
   $errors = [];
   $body = getBody();
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $avatar = trim($body['avatar']);
   $password = trim($body['password']);
   $confirmPassword = trim($body['confirm_password']);
   $status = trim($body['status']);
   $permission = trim($body['groups']);
   $aboutContent = trim($body['about_content']);
   $contactFacebook = trim($body['contact_facebook']);
   $contactTwitter = trim($body['contact_twitter']);
   $contactLinkedin = trim($body['contact_linkedin']);
   $contactPrinterest = trim($body['contact_pinterest']);

   $userId = trim($body['id']);

   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ tên không được để trống';
   }

   if(empty($avatar)) {
      $errors['avatar']['required'] = 'Vui lòng chọn ảnh đại diện';
   }

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else {
      if(!isEmail($email)) {
         $errors['email']['invalid'] = 'Địa chỉ email không đúng. Vui lòng nhập lại';
      }
   }

   if(!empty($password)) {
      if($password != $confirmPassword) {
         $errors['confirm_password']['match'] = 'Mật khẩu không trùng khớp';
      }
   }


   if(empty($errors)) {
      $dataUpdate = [
         'fullname' => $fullname,
         'email' => $email,
         'avatar' => $avatar,
         'status' => $status,
         'group_id' => $permission,
         'about_content' => $aboutContent,
         'contact_facebook' => $contactFacebook,
         'contact_twitter' => $contactTwitter,
         'contact_linkedin' => $contactLinkedin,
         'contact_pinterest' => $contactPrinterest,
         'update_at' => date('Y-m-d H:i:s')
      ];

      if(!empty($password)) {
         $dataUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
      }

      $updateStatus = update('users', $dataUpdate, "id = $userId");
      if($updateStatus) {
         setFlashData('msg', 'Chỉnh sửa thông tin tài khoản thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=users');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=users&action=edit&id='.$userId);
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$infor = getFlashData('userDetailt');
if(!empty($old)) {
   $infor = $old;
} 
?>
<hr>
<div class="container">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST">
      <div class="row">
         <div class="col-6">
            <div class="form-group">
               <label for="fullname">Họ tên:</label>
               <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ tên..."
                  value="<?php echo form_infor('fullname', $infor) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" id="email" name="email" class="form-control" placeholder="Email..."
                  value="<?php echo form_infor('email', $infor) ?>">
               <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="status">Trạng thái</label>
               <select name="status" class="form-control">
                  <option value="0" <?php echo (!empty($infor['status']) && $infor['status']==0)? 'selected' : false ?>>
                     Chưa kích hoạt
                  <option value="1" <?php echo (!empty($infor['status']) && $infor['status']==1)? 'selected' : false ?>>
                     Kích hoạt</option>
                  </option>
               </select>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="groups">Nhóm quyền</label>
               <select name="groups" class="form-control">
                  <?php 
                  if(!empty($listAllGroups)):
                     foreach($listAllGroups as $group):
               ?>
                  <option value="<?php echo $group['id'] ?>"
                     <?php echo (!empty($infor['group_id']) && $infor['group_id']==$group['id'])? 'selected' : false ?>>
                     <?php echo $group['name'] ?></option>
                  <?php 
                  endforeach;
               endif;
               ?>
               </select>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="contact_facebook">Facebook</label>
               <input type="text" id="contact_facebook" name="contact_facebook" class="form-control"
                  placeholder="Facebook..." value="<?php echo form_infor('contact_facebook', $infor) ?>">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="contact_twitter">Twitter</label>
               <input type="text" id="contact_twitter" name="contact_twitter" class="form-control"
                  placeholder="Twitter..." value="<?php echo form_infor('contact_twitter', $infor) ?>">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="contact_linkedin">Linkedin</label>
               <input type="text" id="contact_linkedin" name="contact_linkedin" class="form-control"
                  placeholder="Linkedin..." value="<?php echo form_infor('contact_linkedin', $infor) ?>">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="contact_pinterest">Printerest</label>
               <input type="text" id="contact_pinterest" name="contact_pinterest" class="form-control"
                  placeholder="Printerest..." value="<?php echo form_infor('contact_pinterest', $infor) ?>">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="password">Mật khẩu</label>
               <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu mới...">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="confirm_password">Nhập lại mật khẩu</label>
               <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                  placeholder="Nhập lại mật khẩu mới...">
               <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="avatar">Ảnh đại diện</label>
               <div class="row ckfinder-group">
                  <div class="col-9">
                     <input type="text" id="avatar" name="avatar" class="form-control image-link"
                        placeholder="Ảnh đại diện..." value="<?php echo old('avatar', $infor) ?>">
                     <?php echo form_error('avatar', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="col-3">
                     <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                        ảnh</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="about_content">Nội dung giới thiệu</label>
               <textarea name="about_content" id="about_content" class="form-control"
                  placeholder="Nội dung giới thiệu..."><?php echo form_infor('about_content', $infor) ?></textarea>
            </div>
         </div>
      </div>
      <input type="hidden" name='id' value="<?php echo $userId ?>">
      <button type="submit" class="btn btn-primary btn-sm">Chỉnh sửa</button>
      <a href="<?php echo getLinkAdmin('users')?>" type="submit" class="btn btn-success btn-sm">Quay lại</a>
   </form>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>