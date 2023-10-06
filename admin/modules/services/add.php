<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Thêm dịch vụ'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

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

   if(empty($permission)) {
      $errors['permission']['required'] = 'Phân quyền không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'permission' => $permission,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('groups', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm nhóm tài khoản thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=groups');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=groups&action=add');
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
                     <div class="row">
                        <div class="col-9">
                           <input type="text" id="icon" name="icon" class="form-control"
                              placeholder="Đường dẫn ảnh hoặc mã icon..." value="<?php echo old('icon', $old) ?>">
                           <?php echo form_error('icon', $errors, '<span class="error">', '</span>') ?>
                        </div>
                        <div class="col-3">
                           <button type="button" class="btn btn-success btn-block">Chọn ảnh</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="description">Mô tả ngắn</label>
                     <textarea name="description" id="description" placeholder="Mô tả ngắn..."
                        class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                     <label for="content">Nội dung</label>
                     <textarea name="content" id="content" class="form-control"></textarea>
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