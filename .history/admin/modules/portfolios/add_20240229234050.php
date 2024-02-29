<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Thêm dự án'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $userId = isLogin()['user_id'];

 $listAllCates = getRaw("SELECT id, name FROM portfolio_categories");
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form
   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $slug = trim($body['slug']);
   $thumbnail = trim($body['thumbnail']);
   $description = trim($body['description']);
   $content = trim($body['content']);
   $cateId = !empty($body['cate_id']) ? array_filter($body['cate_id']) : false;
   $video = trim($body['video']);
   $images = !empty($body['gallery']) ? $body['gallery'] : false;

   if(empty($name)) {
      $errors['name']['required'] = 'Tên nhóm không được để trống';
   }

   if(empty($slug)) {
      $errors['slug']['required'] = 'Đường dẫn tĩnh không được để trống';
   }

   if(empty($thumbnail)) {
      $errors['thumbnail']['required'] = 'Thumbnail không được để trống';
   }

   if(empty($video)) {
      $errors['video']['required'] = 'Video không được để trống';
   }

   if(empty($cateId)) {
      $errors['cate_id']['required'] = 'Vui lòng chọn danh mục sản phẩm';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsertPortfolio = [
         'name' => $name,
         'slug' => $slug,
         'thumbnail' => $thumbnail,
         'description' => $description,
         'content' => $content,
         'user_id' => $userId,
         'video' => $video,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('portfolios', $dataInsertPortfolio);
      if($insertStatus) {
         $portfolioId = insertId();
            foreach($cateId as $key => $value) {
               $dataInsert = [
                  'portfolio_id' => $portfolioId,
                  'category_id' => $value,
                  'user_id' => $userId,
                  'create_at' => date('Y-m-d H:i:s'),
               ];

               insert('portfolio_category_mapping', $dataInsert);
            }

            if(empty($images)) {
               setFlashData('msg', 'Thêm dự án thành công.');
               setFlashData('msg_type', 'success');
            } else {
               foreach($images as $image) {
                  $dataInsertImage = [
                     'portfolio_id' => $portfolioId,
                     'image' => $image,
                     'create_at' => date('Y-m-d H:i:s')
                  ];
                  $insertImageStatus = insert('portfolio_images', $dataInsertImage);
                  if($insertImageStatus) {
                     setFlashData('msg', 'Thêm dự án thành công.');
                     setFlashData('msg_type', 'success');
                  } else {
                     setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau (insertImage).');
                     setFlashData('msg_type', 'danger'); 
                  }
               }
            }
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=portfolios');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=portfolios&action=add');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');


if(!empty($old)) {
   echo '<pre>';
   print_r($old['cate_id']);
   echo '</pre>';
}

echo '<pre>';
print_r($listAllCates);
echo '</pre>';
die();
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
                     <label for="name">Tên dự án</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên dự án..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="cate_id">Danh mục dự án</label>
                     <select name="cate_id[]" id="cate_id" class="form-control" multiple>
                        <option value="0">Chọn danh mục</option>
                        <?php 
                           if(!empty($listAllCates)):
                              foreach($listAllCates as $cate):
                        ?>
                        <option value="<?php echo $cate['id'] ?>"
                           <?php echo (!empty($old['cate_id']) && $old['cate_id'] == $cate['id']) ? "selected" : false ?>>
                           <?php echo $cate['name'] ?>
                        </option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                     <?php echo form_error('cate_id', $errors, '<span class="error">', '</span>') ?>
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
                     <label for="video">Video</label>
                     <input type="url" id="video" name="video" class="form-control" placeholder="Đường dẫn video..."
                        value="<?php echo old('video', $old) ?>">
                     <?php echo form_error('video', $errors, '<span class="error">', '</span>') ?>
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
                  <div class="form-group">
                     <label for="">Ảnh dự án</label>
                     <div class="gallery-images">
                        <?php 
                           if(!empty($old["gallery"])):
                              foreach($old["gallery"] as $image):
                        ?>
                        <div class="gallery-item">
                           <div class="row ckfinder-group">
                              <div class="col-9">
                                 <input type="text" id="gallery" name="gallery[]" class="form-control image-link"
                                    placeholder="Đường dẫn ảnh..." value=<?php echo $image ?>>
                              </div>
                              <div class="col-2">
                                 <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                                    ảnh</button>
                              </div>
                              <div class="col-1">
                                 <button type="button" class="btn btn-danger btn-block btn-remove-image"><i
                                       class="fa fa-times"></i></button>
                              </div>
                           </div>
                        </div>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <button type="button" class="btn btn-warning btn-small" id="addImage">Thêm ảnh</button>
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