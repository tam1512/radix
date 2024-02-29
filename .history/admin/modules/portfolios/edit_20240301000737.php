<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm người dùng
 */
$data = [
   'title' => 'Sửa thông tin dự án'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $userId = isLogin()['user_id'];

 $listAllCates = getRaw("SELECT id, name FROM portfolio_categories");
 if(isGet()) {
    $id = getBody("get")['id'];
   $defaultPortfolio = firstRaw("SELECT * FROM portfolios WHERE id = $id");
   $listImages = getRaw("SELECT id, image FROM portfolio_images WHERE portfolio_id = $id");
   $listCategories = getRaw("SELECT category_id FROM portfolio_category_mapping WHERE portfolio_id = $id");
   //xử lý cho mảng categories giống với lúc submit
   $listCategoriesDefault = [];
   foreach($listCategories as $item) {
      $listCategoriesDefault[] = $item['category_id'];
   }
   $defaultPortfolio['cate_id'] = $listCategoriesDefault;
   if(empty($listImages)) {
      setFlashData('defaultPortfolio', $defaultPortfolio);
   } else {
      $defaultPortfolio['gallery'] = $listImages;
      setFlashData('defaultPortfolio', $defaultPortfolio);
   }
 }
 if(isPost()) {

   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $id = trim($body['id']);
   $name = trim($body['name']);
   $slug = trim($body['slug']);
   $thumbnail = trim($body['thumbnail']);
   $description = trim($body['description']);
   $content = trim($body['content']);
   $cateId = !empty($body['cate_id']) ? array_filter($body['cate_id']) : false;
   $video = trim($body['video']);
   if(isset($body['gallery'])) {
      $images = $body['gallery'];
   } else {
      $images = [];
   }

   
   $listImages = getRaw("SELECT id, image FROM portfolio_images WHERE portfolio_id = $id");
   $listCatesById = getRaw("SELECT portfolio_id, category_id FROM portfolio_category_mapping WHERE portfolio_id = $id");

   $listImageDelete = [];
   foreach($listImages as $image) {
      $checkDelete = false;
      foreach($images as $item) {
         if(!empty($item['id'])) {
            if($image['id'] == $item['id']) {
               $checkDelete = true;
            }
         }
      }
      if(!$checkDelete) {
         $listImageDelete[] = $image;
      }
   }


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
      $errors['category_id']['required'] = 'Vui lòng chọn danh mục sản phẩm';
   } 

   if(empty($content)) {
      $errors['content']['required'] = 'Nội dung không được để trống';
   } 

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'slug' => $slug,
         'thumbnail' => $thumbnail,
         'description' => $description,
         'content' => $content,
         'user_id' => $userId,
         'video' => $video,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('portfolios', $dataUpdate, "id = $id");
      if($updateStatus) {
         delete('portfolio_category_mapping', "portfolio_id = $id");
         foreach($cateId as $item) {
            $dataInsertMapping = [
               'portfolio_id' => $id,
               'category_id' => $item,
               'user_id' => $userId,
               'create_at' => date('Y-m-d H:i:s'),
            ];
            insert('portfolio_category_mapping', $dataInsertMapping);
         }


         if(empty($images)) {
            $deleteImageStatus = delete('portfolio_images', 'portfolio_id='.$id);
            if($deleteImageStatus) {
               setFlashData('msg', 'Sửa thông tin dự án thành công.');
               setFlashData('msg_type', 'success');
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau ($deleteImage).');
               setFlashData('msg_type', 'danger');
            }
         } else {
            foreach($images as $key=>$value) {
               if(!empty($value['id'])) {
                  $dataUpdateImage = [
                     'id' => $value['id'],
                     'portfolio_id' => $id,
                     'image' => $value['image'],
                     'update_at' => date('Y-m-d H:i:s')
                  ];
                  $updateImageStatus = update('portfolio_images', $dataUpdateImage, "id = ".$value['id']);
                  if($updateImageStatus) {
                     setFlashData('msg', 'Sửa thông tin dự án thành công.');
                     setFlashData('msg_type', 'success');
                  } else {
                     setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau ($updateImage).');
                     setFlashData('msg_type', 'danger');
                  }
               } else {
                  if(is_string($value) && !empty($value)) {
                     $dataInsertImage = [
                        'portfolio_id' => $id,
                        'image' => $value,
                        'create_at' => date('Y-m-d H:i:s')
                     ];
                     $insertImageStatus = insert('portfolio_images', $dataInsertImage);
                     if($insertImageStatus) {
                        setFlashData('msg', 'Sửa thông tin dự án thành công.');
                        setFlashData('msg_type', 'success');
                     } else {
                        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau ($insertImage).');
                        setFlashData('msg_type', 'danger');
                     }
                  }
               }
            }

            if(!empty($listImageDelete)) {
               foreach($listImageDelete as $image) {
                 $deleteImageStatus = delete('portfolio_images', "id=".$image['id']);
                 if(!$deleteImageStatus) {
                  setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau ($deleteImage).');
                  setFlashData('msg_type', 'danger');
                 }
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
      redirect('admin/?module=portfolios&action=edit&id='.$id);
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultPortfolio = getFlashData('defaultPortfolio');
if(empty($old)) {
   $old = $defaultPortfolio;
}
echo '<pre>';
print_r($old);
echo '</pre>';
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
                        <option value="<?php echo $cate['id'] ?>" <?php 
                              if(!empty($old['cate_id'])) {
                                 foreach($old['cate_id'] as $item) {
                                    if($item == $cate['id']) {
                                       echo ' selected';
                                       break;
                                    }
                                 }
                              }
                           ?>>
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
                              foreach($old["gallery"] as $key=>$image):
                        ?>
                        <div class="gallery-item">
                           <div class="row ckfinder-group">
                              <div class="col-9">
                                 <input type="text" id="gallery" name="gallery[<?php echo $key ?>][image]"
                                    class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                    value=<?php echo $image['image'] ?>>
                                 <input type="hidden" name="gallery[<?php echo $key ?>][id]"
                                    value="<?php echo $image['id'] ?>">
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
            <input type="hidden" name="modules" value="portfolios">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="btn btn-primary" type="submit">Chỉnh sửa</button>
            <a class="btn btn-success" href="<?php echo getLinkAdmin('portfolios') ?>">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>