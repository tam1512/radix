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
            setFlashData('msg', 'Sửa thông tin bình luận thành công.');
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
$defaultComment = getFlashData('defaultComment');
if(empty($old)) {
   $old = $defaultComment;
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
                     <label for="">Thông tin bình luận:</label>
                     <?php 
                        if(!empty($old['user_id']) && !empty(getUser($old['user_id']))) {
                           echo '<p>Đăng bởi: <b>'.getUser($old['user_id'])['fullname'].'</b></p>';
                        }
                        if(!empty($old['parent_id']) && !empty(getComment($old['parent_id']))) {
                           echo '<p>Đăng bởi: <b>'.getComment($old['parent_id'])['fullname'].'</b></p>';
                        }

                     ?>
                  </div>
                  <div class="form-group">
                     <label for="fullname">Họ tên người bình luận:</label>
                     <input type="text" name="fullname" class="form-control" disabled
                        placeholder="Họ tên người bình luận..." value="<?php echo old('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="email">Email người bình luận:</label>
                     <input type="text" name="email" class="form-control" disabled
                        placeholder="Email người bình luận..." value="<?php echo old('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="website">Website người bình luận:</label>
                     <input type="text" name="website" class="form-control" disabled
                        placeholder="website người bình luận..." value="<?php echo old('website', $old) ?>">
                  </div>
                  <div class="form-group">
                     <label for="content">Nội dung:</label>
                     <textarea type="text" id="name" name="content" class="form-control" disabled
                        placeholder="Nội dung..."><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="status">Tình trạng</label>
                     <select name="status" id="status" class="form-control">
                        <option>Chọn tình trạng</option>
                        <?php 
                           if(!empty($listStatus)):
                              foreach($listStatus as $key => $value):
                        ?>
                        <option value="<?php echo old('status', $old) ?>"
                           <?php echo ($old['status'] == $key) ? "selected" : false ?>>
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