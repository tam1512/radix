<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Sửa thông tin bình luận'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $listAllDepartments = getRaw("SELECT id, name FROM departments");
 $listStatus = [
   0 => 'Chưa duyệt',
   2 => 'Đã duyệt'
 ];
 
 if(isGet()) {
   $id = getBody("get")['id'];
   $defaultComment = firstRaw("SELECT * FROM comments WHERE id = $id");
   $fullname = $defaultComment['fullname'];
   $email = $defaultComment['email'];
   $website = !empty($defaultComment['website']) ? $defaultComment['website'] : "";
   setFlashData('defaultComment', $defaultComment);
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = trim($body['id']);
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $website = trim($body['website']);
   $status = trim($body['status']);
   $content = trim($body['content']);

   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ tên không được bỏ trống';
   } 

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else if(!isEmail($email)) {
      $errors['email']['invalid'] = 'Email không đúng định dạng';
   } 

   if(empty($status)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung bình luận không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'fullname' => $fullname,
         'email' => $email,
         'website' => $website,
         'status' => $status,
         'content' => $content,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('comments', $dataUpdate, "id = $id");
      if($updateStatus) {
            setFlashData('msg', 'Sửa thông tin liên hệ thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=comments');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=comments&action=edit&id='.$id);
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
      <div class="col" style="margin: 20px auto;">

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
                     <label for="department_id">Danh sách phòng ban</label>
                     <select name="department_id" id="department_id" class="form-control">
                        <option value="0">Chọn phòng ban</option>
                        <?php 
                           if(!empty($listAllDepartments)):
                              foreach($listAllDepartments as $department):
                        ?>
                        <option value="<?php echo $department['id'] ?>"
                           <?php echo (!empty($old['department_id']) && $old['department_id'] == $department['id']) ? "selected" : false ?>>
                           <?php echo $department['name'] ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('department_id', $errors, '<span class="error">', '</span>') ?>
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
            <input type="hidden" name="modules" value="comments">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="btn btn-primary" type="submit">Chỉnh sửa</button>
            <a class="btn btn-success" href="<?php echo getLinkAdmin('comments') ?>">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>