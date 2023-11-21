<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Sửa thông tin blog'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $userId = isLogin()['user_id'];

 $listAllCates = getRaw("SELECT id, name FROM departments");
 if(isGet()) {
    $id = getBody("get")['id'];
   $defaultBlog = firstRaw("SELECT * FROM contacts WHERE id = $id");
   setFlashData('defaultBlog', $defaultBlog);
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = trim($body['id']);
   $title = trim($body['title']);
   $slug = trim($body['slug']);
   $thumbnail = trim($body['thumbnail']);
   $description = trim($body['description']);
   $content = trim($body['content']);
   $cateId = trim($body['category_id']);

   if(empty($title)) {
      $errors['title']['required'] = 'Tiêu đề không được để trống';
   }

   if(empty($slug)) {
      $errors['slug']['required'] = 'Đường dẫn tĩnh không được để trống';
   }

   if(empty($thumbnail)) {
      $errors['thumbnail']['required'] = 'Thumbnail không được để trống';
   }

   if(empty($cateId)) {
      $errors['category_id']['required'] = 'Vui lòng chọn danh mục sản phẩm';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'title' => $title,
         'slug' => $slug,
         'thumbnail' => $thumbnail,
         'description' => $description,
         'content' => $content,
         'user_id' => $userId,
         'category_id' => $cateId,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('contacts', $dataUpdate, "id = $id");
      if($updateStatus) {
            setFlashData('msg', 'Sửa thông tin blog thành công.');
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
$defaultBlog = getFlashData('defaultBlog');
if(empty($old)) {
   $old = $defaultBlog;
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
                     <input type="text" id="name" name="title" class="form-control" placeholder="Tiêu đề..."
                        value="<?php echo old('title', $old) ?>">
                     <?php echo form_error('title', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="category_id">Danh mục blog</label>
                     <select name="category_id" id="category_id" class="form-control">
                        <option value="0">Chọn danh mục</option>
                        <?php 
                           if(!empty($listAllCates)):
                              foreach($listAllCates as $cate):
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
                     <label for="slug">Đường dẫn tĩnh</label>
                     <input type="text" id="slug" name="slug" class="form-control" placeholder="Đường dẫn tĩnh..."
                        value="<?php echo old('slug', $old) ?>">
                     <?php echo form_error('slug', $errors, '<span class="error">', '</span>') ?>
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