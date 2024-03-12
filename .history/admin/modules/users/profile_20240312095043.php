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
 layout('breadcrumb', 'admin', $data);

$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname, email, avatar, about_content, contact_facebook, contact_twitter, contact_linkedin, contact_pinterest  FROM users WHERE id = $userId");

if(isPost()) {
   $errors = [];
   $body = getBody();
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $avatar = trim($body['avatar']);
   $aboutContent = trim($body['about_content']);
   $contactFacebook = trim($body['contact_facebook']);
   $contactTwitter = trim($body['contact_twitter']);
   $contactLinkedin = trim($body['contact_linkedin']);
   $contactPrinterest = trim($body['contact_pinterest']);

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

   if(empty($errors)) {
      $dataUpdate = [
         'fullname' => $fullname,
         'email' => $email,
         'avatar' => $avatar,
         'about_content' => $aboutContent,
         'contact_facebook' => $contactFacebook,
         'contact_twitter' => $contactTwitter,
         'contact_linkedin' => $contactLinkedin,
         'contact_pinterest' => $contactPrinterest,
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
      redirect('admin/?module=users&action=profile');
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$infor = $userDetail;
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
      <button type="submit" class="btn btn-primary btn-sm">Chỉnh sửa</a>
   </form>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>