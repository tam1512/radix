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
    $checkPermission = checkPermission($permissionData, 'pages', 'add');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền thêm trang');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
$data = [
   'title' => 'Thêm trang'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $userId = isLogin()['user_id'];

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $title = trim($body['title']);
   $slug = trim($body['slug']);
   $content = trim($body['content']);

   if(empty($title)) {
      $errors['title']['required'] = 'Tiêu đề không được để trống';
   }

   if(empty($slug)) {
      $errors['slug']['required'] = 'Đường dẫn tĩnh không được để trống';
   }

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'title' => $title,
         'slug' => $slug,
         'content' => $content,
         'user_id' => $userId,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('pages', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm trang thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=pages');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=pages&action=add');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

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
                     <label for="name">Tiêu đề</label>
                     <input type="text" id="name" name="title" class="form-control slug" placeholder="Tiêu đề..."
                        value="<?php echo old('title', $old) ?>">
                     <?php echo form_error('title', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="slug">Đường dẫn tĩnh</label>
                     <input type="text" id="slug" name="slug" class="form-control" placeholder="Đường dẫn tĩnh..."
                        value="<?php echo old('slug', $old) ?>">
                     <?php echo form_error('slug', $errors, '<span class="error">', '</span>') ?>
                     <p class="render-link"><b>Link: </b><span></span></p>
                  </div>
                  <div class="form-group">
                     <label for="">Nội dung</label>
                     <textarea name="content" class="form-control editor"><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Thêm trang</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>