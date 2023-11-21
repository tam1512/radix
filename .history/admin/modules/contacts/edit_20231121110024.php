<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Sửa thông tin liên hệ'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $listAllDepartments = getRaw("SELECT id, name FROM departments");
 if(isGet()) {
    $id = getBody("get")['id'];
   $defaultContact = firstRaw("SELECT * FROM contacts WHERE id = $id");
   setFlashData('defaultContact', $defaultContact);
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = trim($body['id']);
   $note = trim($body['note']);
   $departmentId = trim($body['department_id']);
   $status = trim($body['status']);


   if(empty($departmentId)) {
      $errors['department_id']['required'] = 'Vui lòng chọn phòng ban';
   } 

   if(empty($status)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'department_id' => $departmentId,
         'status' => $status,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('contacts', $dataUpdate, "id = $id");
      if($updateStatus) {
            setFlashData('msg', 'Sửa thông tin liên hệ thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=contacts');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=contacts&action=edit&id='.$id);
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
                     <label for="name">Tiêu đề</label>
                     <input type="text" id="name" name="fullname" class="form-control" placeholder="Tiêu đề..."
                        value="<?php echo old('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="category_id">Danh mục liên hệ</label>
                     <select name="category_id" id="category_id" class="form-control">
                        <option value="0">Chọn danh mục</option>
                        <?php 
                           if(!empty($listAllDepartments)):
                              foreach($listAllDepartments as $cate):
                        ?>
                        <option value="<?php echo $cate['id'] ?>"
                           <?php echo (!empty($old['category_id']) && $old['category_id'] == $cate['id']) ? "selected" : false ?>>
                           <?php echo $cate['name'] ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('category_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="email">Đường dẫn tĩnh</label>
                     <input type="text" id="email" name="email" class="form-control" placeholder="Đường dẫn tĩnh..."
                        value="<?php echo old('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                     <p class="render-link"><b>Link: </b><span></span></p>
                  </div>
                  <div class="form-group">
                     <label for="thumbnail">Thumbnail</label>
                     <div class="row ckfinder-group">
                        <div class="col-9">
                           <input type="text" id="thumbnail" name="thumbnail" class="form-control image-link"
                              placeholder="Đường dẫn ảnh hoặc mã thumbnail..."
                              value="<?php echo old('thumbnail', $old) ?>">
                           <?php echo form_error('thumbnail', $errors, '<span class="error">', '</span>') ?>
                        </div>
                        <div class="col-3">
                           <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                              ảnh</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="message">Mô tả ngắn</label>
                     <textarea name="message" id="message" placeholder="Mô tả ngắn..."
                        class="form-control"><?php echo old('message', $old) ?></textarea>
                     <?php echo form_error('message', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="">Nội dung</label>
                     <textarea name="content" class="form-control editor"><?php echo old('content', $old) ?></textarea>
                     <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <input type="hidden" name="modules" value="contacts">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="btn btn-primary" type="submit">Chỉnh sửa</button>
            <a class="btn btn-success" href="<?php echo getLinkAdmin('contacts') ?>">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>