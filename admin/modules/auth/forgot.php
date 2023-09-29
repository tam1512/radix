<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng quên mật khẩu
 */
$data = [
   'title' => 'Đặt lại mật khẩu'
];

layout('header-login', $data);


if(isLogin()) {
   redirect('?module=users');
}


//validate form
if(isPost()) {

   $errors = [];
   $email = trim(getBody()['email']);

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else {
      $queryEmail = firstRaw("SELECT id, fullname FROM users WHERE email='$email'");
      if(!empty($queryEmail)) {
         $userId = $queryEmail['id'];
         $fullname = $queryEmail['fullname'];

         // Tạo forgot token
         $forgotToken = sha1(uniqid().time());

         //update dữ liệu lại bảng users
         $dataUpdate = [
            'forgotToken' => $forgotToken,
         ];

         $updateStatus = update('users', $dataUpdate, "id = $userId");

         if($updateStatus) {
            //Tạo link đặt lại mật khẩu
            $linkReset = _WEB_HOST_ROOT.'?module=auth&action=reset&token='.$forgotToken;

            // Nội dung email
            $subject = 'Yêu cầu đặt lại mật khẩu.';
            $content = 'Xin chào '.$fullname. '<br> <br>';
            $content.= 'Chúng tôi nhận được yêu cầu đặt lại mật khẩu từ bạn. Vui lòng click vào link sau để thực hiện đặt lại mật khẩu:<br> <br>';
            $content.= $linkReset.'<br> <br>';
            $content.= 'Trân trọng';

            //Gửi mail
            $sendMail = sendMail($email, $subject, $content);

            if($sendMail) {
               setFlashData('msg', 'Vui lòng kiểm tra email để đặt lại mật khẩu');
               setFlashData('msg_type', 'success');
               redirect('?module=auth&action=forgot');
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Bạn không thể sử dụng chức năng này');
               setFlashData('msg_type', 'danger');
               redirect('?module=auth&action=forgot');
            }
         } else {
            setFlashData('msg', 'Lỗi hệ thống. Bạn không thể sử dụng chức năng này');
            setFlashData('msg_type', 'danger');
            redirect('?module=auth&action=forgot');
         }
      } else {
         $errors['email']['match'] = 'Địa chỉ email không tồn tại!';
      }
   }

   if(!empty($errors)) {
      setFlashData('errors', $errors);
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      redirect('?module=auth&action=forgot');

   } 
}

$errors = getFlashData('errors');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');


 ?>

<div class="row">
   <div class="col-6" style="margin: 20px auto;">
      <h3 class="text-center text-uppercase">Đặt lại mật khẩu</h3>
      <?php getMsg($msg, $msgType) ?>
      <form action="" method="post">
         <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Địa chỉ email...">
            <?php echo form_error('email', $errors, '<span class = "error">', '</span>') ?>
         </div>
         <button class="btn btn-primary btn-block" type="submit">Xác nhận</button>
         <hr>
         <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
         <p class="text-center"><a href="?module=auth&action=register">Đăng ký tài khoản</a></p>
      </form>
   </div>
</div>

<?php
  layout('footer-login');
 ?>