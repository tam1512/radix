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
    $checkPermission = checkPermission($permissionData, 'services', 'add');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền thêm Dịch vụ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
$data = [
   'title' => 'Thêm dịch vụ'
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
   $name = trim($body['name']);
   $slug = trim($body['slug']);
   $icon = trim($body['icon']);
   $description = trim($body['description']);
   $content = trim($body['content']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên nhóm không được để trống';
   }

   if(empty($slug)) {
      $errors['slug']['required'] = 'Đường dẫn tĩnh không được để trống';
   }

   if(empty($icon)) {
      $errors['icon']['required'] = 'Icon không được để trống';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'slug' => $slug,
         'icon' => $icon,
         'description' => $description,
         'content' => $content,
         'user_id' => $userId,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('services', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm dịch vụ thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=services');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=services&action=add');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

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
                     <label for="name">Tên dịch vụ</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên dịch vụ..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="slug">Đường dẫn tĩnh</label>
                     <input type="text" id="slug" name="slug" class="form-control" placeholder="Phân quyền..."
                        value="<?php echo old('slug', $old) ?>">
                     <?php echo form_error('slug', $errors, '<span class="error">', '</span>') ?>
                     <p class="render-link"><b>Link: </b><span></span></p>
                  </div>
                  <div class="form-group">
                     <label for="icon">Icon</label>
                     <div class="row ckfinder-group">
                        <div class="col-9">
                           <input type="text" id="icon" name="icon" class="form-control image-link"
                              placeholder="Đường dẫn ảnh hoặc mã icon..." value="<?php echo old('icon', $old) ?>">
                           <?php echo form_error('icon', $errors, '<span class="error">', '</span>') ?>
                        </div>
                        <div class="col-3">
                           <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                              ảnh</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="description">Mô tả ngắn</label>
                     <textarea name="description" id="description" placeholder="Mô tả ngắn..."
                        class="form-control"><?php echo old('description', $old) ?></textarea>
                     <?php echo form_error('description', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="">Nội dung</label>
                     <textarea name="content" class="form-control editor"><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Thêm</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>