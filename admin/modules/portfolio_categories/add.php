<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm danh mục
 */

 // Xử lý đăng ký

 $userId = isLogin()['user_id'];

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên nhóm không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'user_id' => $userId,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('portfolio_categories', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm danh mục thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=portfolio_categories');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=portfolio_categories');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

 ?>

<h4>Thêm danh mục</h4>
<form action="" method="post">
   <div class="form-group">
      <input type="text" name="name" class="form-control" placeholder="Tên danh mục..."
         value="<?php echo old('name', $old) ?>">
      <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
   </div>
   <button type="submit" class="btn btn-success">Thêm</button>
</form>