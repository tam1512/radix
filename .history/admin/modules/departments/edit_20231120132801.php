<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
 */

 // Xử lý đăng ký

if(isGet()) {
   $categoryId = trim(getBody()['id']);
   
   if(!empty($categoryId)) {
      $defaultCategory = firstRaw("SELECT * FROM departments WHERE id = '$categoryId'");
      setFlashData('defaultCategory', $defaultCategory);
   } else {
      redirect("admin/?module=departments");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $categoryId = trim($body['id']);
   
   if(empty($name)) {
      $errors['name']['required'] = 'Tên danh mục không được để trống';
   }
   if(empty($slug)) {
      $errors['slug']['required'] = 'Đường dẫn tĩnh không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'slug' => $slug,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('departments', $dataUpdate, "id=$categoryId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa danh mục thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=departments');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=departments&action=lists&view=edit&id=$categoryId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultCategory = getFlashData('defaultCategory');
if(!empty($defaultCategory)) {
   $old = $defaultCategory;
}
 ?>

<h4>Chỉnh sửa danh mục</h4>
<form action="" method="post">
   <div class="form-group">
      <input type="text" name="name" id="name" class="form-control" placeholder="Tên danh mục..."
         value="<?php echo old('name', $old) ?>">
      <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
   </div>
   <div class="form-group">
      <label for="slug">Đường dẫn tĩnh</label>
      <input type="text" id="slug" name="slug" class="form-control" placeholder="Đường dẫn tĩnh..."
         value="<?php echo old('slug', $old) ?>">
      <?php echo form_error('slug', $errors, '<span class="error">', '</span>') ?>
      <p class="render-link"><b>Link: </b><span></span></p>
   </div>
   <input type="hidden" name="id" value="<?php echo $categoryId ?>">
   <button class="btn btn-primary" type="submit">Cập nhật</button>
   <a href="<?php echo getLinkAdmin('departments') ?>" class="btn btn-success" type="submit">Quay lại</a>
   <hr>
</form>