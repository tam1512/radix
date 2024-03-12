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
    $checkPermission = checkPermission($permissionData, 'subscribe', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Thêm Nhóm Người Dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
$data = [
   'title' => 'Sửa thông tin đăng ký'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $listStatus = [
   0 => 'Chưa xử lý',
   1 => 'Đã xử lý'
 ];
 
 if(isGet()) {
   $id = getBody("get")['id'];
   $defaultSubscribe = firstRaw("SELECT * FROM subscribe WHERE id = $id");
   setFlashData('defaultSubscribe', $defaultSubscribe);
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form
   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = $body['id'];
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $status = trim($body['status']);

   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ tên không được bỏ trống';
   } 

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else if(!isEmail($email)) {
      $errors['email']['invalid'] = 'Email không đúng định dạng';
   } 

   $arrStatus = [0,1];

   if(!in_array($status, $arrStatus)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'fullname' => $fullname,
         'email' => $email,
         'status' => $status,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('subscribe', $dataUpdate, "id = $id");
      if($updateStatus) {
            setFlashData('msg', 'Sửa thông tin đăng ký thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=subscribe');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=subscribe&action=edit&id='.$id);
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultSubscribe = getFlashData('defaultSubscribe');
if(empty($old)) {
   $old = $defaultSubscribe;
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
                     <label for="fullname">Họ tên người đăng ký:</label>
                     <input type="text" name="fullname" class="form-control" placeholder="Họ tên người đăng ký..."
                        value="<?php echo old('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="email">Email người đăng ký:</label>
                     <input type="text" name="email" class="form-control" placeholder="Email người đăng ký..."
                        value="<?php echo old('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="status">Tình trạng</label>
                     <select name="status" id="status" class="form-control">
                        <option>Chọn trạng thái</option>
                        <?php 
                           if(!empty($listStatus)):
                              foreach($listStatus as $key => $value):
                        ?>
                        <option value="<?php echo $key?>" <?php echo ($old['status'] == $key) ? "selected" : false ?>>
                           <?php echo $value ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('status', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="modules" value="subscribe">
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a class="btn btn-success" href="<?php echo getLinkAdmin('subscribe') ?>">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>