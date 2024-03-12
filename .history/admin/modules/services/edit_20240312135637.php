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
    $checkPermission = checkPermission($permissionData, 'services', 'edit');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền chỉnh sửa Dịch vụ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
$data = [
   'title' => 'Chỉnh sửa dịch vụ'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý đăng ký

if(isGet()) {
   $serviceId = trim(getBody()['id']);
   
   if(!empty($serviceId)) {
      $defaultService = firstRaw("SELECT name, slug, icon, description, content FROM services WHERE id = '$serviceId'");
      setFlashData('defaultService', $defaultService);
   } else {
      redirect("admin/?module=services");
   }
}

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
   $serviceId = trim($body['id']);
   
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
      $dataUpdate = [
         'name' => $name,
         'slug' => $slug,
         'icon' => $icon,
         'description' => $description,
         'content' => $content,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('services', $dataUpdate, "id=$serviceId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa dịch vụ thành công.');
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
      redirect("admin/?module=services&action=edit&id=$serviceId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultService = getFlashData('defaultService');
if(!empty($defaultService)) {
   $old = $defaultService;
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
                  <div class="form-service">
                     <label for="name">Tên dịch vụ</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên dịch vụ..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-service">
                     <label for="slug">Đường dẫn tĩnh</label>
                     <input type="text" id="slug" name="slug" class="form-control" placeholder="Phân quyền..."
                        value="<?php echo old('slug', $old) ?>">
                     <?php echo form_error('slug', $errors, '<span class="error">', '</span>') ?>
                     <p class="render-link"><b>Link: </b><span></span></p>
                  </div>
                  <div class="form-service">
                     <label for="icon">Icon</label>
                     <div class="row ckfinder-service">
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
                  <div class="form-service">
                     <label for="description">Mô tả ngắn</label>
                     <textarea name="description" id="description" placeholder="Mô tả ngắn..."
                        class="form-control"><?php echo old('description', $old) ?></textarea>
                     <?php echo form_error('description', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-service">
                     <label for="">Nội dung</label>
                     <textarea name="content" class="form-control editor"><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $serviceId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a href="<?php echo getLinkAdmin('services') ?>" class="btn btn-success" type="submit">Quay lại</a>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>