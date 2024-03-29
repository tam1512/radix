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
    $checkPermission = checkPermission($permissionData, 'comments', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền chỉnh sửa Bình luận');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
$data = [
   'title' => 'Sửa thông tin bình luận'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $listStatus = [
   0 => 'Chưa duyệt',
   1 => 'Đã duyệt'
 ];
 
 if(isGet()) {
   $id = getBody("get")['id'];
   $defaultComment = firstRaw("SELECT comments.*, blogs.title FROM comments JOIN blogs ON blogs.id = comments.blog_id WHERE comments.id = $id");
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
   $userId = trim($body['user_id']);
   $status = trim($body['status']);
   $content = trim($body['content']);
   $isUserId = false;
   if(!empty($userId) && !empty(getUser($userId))) { 
      $isUserId = true;
   } else {
      $fullname = trim($body['fullname']);
      $email = trim($body['email']);
      $website = trim($body['website']);
      if(empty($fullname)) {
         $errors['fullname']['required'] = 'Họ tên không được bỏ trống';
      } 
   
      if(empty($email)) {
         $errors['email']['required'] = 'Email không được để trống';
      } else if(!isEmail($email)) {
         $errors['email']['invalid'] = 'Email không đúng định dạng';
      } 
   }

   $arrStatus = [0,1];
   if(!in_array($status, $arrStatus)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung bình luận không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      if($isUserId) {
         $dataUpdate = [
            'status' => $status,
            'content' => $content,
            'update_at' => date('Y-m-d H:i:s'),
         ];
      } else {
         $dataUpdate = [
            'fullname' => $fullname,
            'email' => $email,
            'website' => $website,
            'status' => $status,
            'content' => $content,
            'update_at' => date('Y-m-d H:i:s'),
         ];
      }

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

<div class="container-fluid">
   <div class="row">
      <div class="col">

         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="">Thông tin bình luận:</label>
                     <?php 
                        $isUserId = false;
                        if(!empty($old['user_id']) && !empty(getUser($old['user_id']))) {
                           $isUserId = true;
                           echo '<p>Viết bởi: <b>'.getUser($old['user_id'])['fullname'].'</b></p>';
                           echo '<p>Email: <b>'.getUser($old['user_id'])['email'].'</b></p>';
                           if(!empty($old['website'])) {
                              echo '<p>Website: <b>'.$old['website'].'</b></p>';
                           }
                        }
                        if(!empty($old['parent_id']) && !empty(getComment($old['parent_id']))) {
                           echo '<p>Trả lời: <b>'.getComment($old['parent_id'])['fullname'].'</b></p>';
                        }
                        if(!empty($old['blog_id']) && !empty($old['title'])) {
                           echo '<p>Bài viết: <b><a href="'.getLinkClient('blogs', 'detail', ['id'=>$old['blog_id']]).'">'.$old['title'].'</a></b></p>';
                        }
                     ?>
                  </div>
                  <?php if(!$isUserId): ?>
                  <div class="form-group">
                     <label for="fullname">Họ tên người bình luận:</label>
                     <input type="text" name="fullname" class="form-control" placeholder="Họ tên người bình luận..."
                        value="<?php echo old('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="email">Email người bình luận:</label>
                     <input type="text" name="email" class="form-control" placeholder="Email người bình luận..."
                        value="<?php echo old('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="website">Website người bình luận:</label>
                     <input type="text" name="website" class="form-control" placeholder="website người bình luận..."
                        value="<?php echo old('website', $old) ?>">
                  </div>
                  <?php endif; ?>
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
                  <div class="form-group">
                     <label for="content">Nội dung:</label>
                     <textarea type="text" id="name" name="content" class="form-control"
                        placeholder="Nội dung..."><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <input type="hidden" name="modules" value="comments">
            <input type="hidden" name="user_id" value="<?php echo $old['user_id'] ?>">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a class="btn btn-success" href="<?php echo getLinkPrevPage() ?>">Quay lại</a>
         </form>
         <br>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>