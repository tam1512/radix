<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập Giới thiệu"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueAbout = [
      'about_title' => 'tiêu đề',
      'about_content' => 'nội dung',
      'about_content_title' => 'tiêu đề nội dung',
      'about_youtube_link' => 'link Youtube',
      'about_image' => 'ảnh',
      'about_desc' => 'mô tả',
      'about_progress_name' => 'tên công việc',
      'progress-range' => 'phạm vi tiến hành'
   ];

   if(isGet()) {
      //get default about
      $jsonDataAbout = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'page_about'")['opt_value'];
      $pageAbout = json_decode($jsonDataAbout, true);
      setFlashData('aboutDefault', $pageAbout);
   }

   if(isPost()) {
               
      $errors = [];
      $arrAbout = [];

      $body = getBody('post');

      //page_about
      if(!empty(getBody('post')['page_about'])) {
         $pageAbout = getBody('post')['page_about'];
         foreach($pageAbout as $key => $value) {
            if(is_array($value)) {
               foreach($value as $k => $v) {
                  $arrAboutProgress[$k][$key] =$v ;
               }
            } else {
               $arrAbout[$key] = $value;
            }
         }
      }

      //xử lý lỗi của page_about
      foreach($arrAbout as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValueAbout[$key];
         }
      }
      foreach($arrAboutProgress as $key => $value) {
         foreach($value as $k => $v) {
         if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueAbout[$k];
         }
         }
      }

      if(empty($errors)) {
         $jsonAbout = json_encode($pageAbout);
         
         // Không có lỗi xảy ra

         $dataAboutUpdate = [
            'opt_value' => $jsonAbout,
         ];

         $updateAboutStatus = update('options', $dataAboutUpdate, "opt_key = 'page_about'");
         if($updateAboutStatus) {
               setFlashData('msg', 'Chỉnh sửa trang giới thiệu thành công.');
               setFlashData('msg_type', 'success');
         } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=about');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('oldAbout', $pageAbout);
         redirect('admin/?module=options&action=about');
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $oldAbout = getFlashData('oldAbout');

   //old about
   if(empty($oldAbout)) {
      $pageAbout = getFlashData('aboutDefault');
   } else {
      $pageAbout = $oldAbout;
   }
   if(!empty($pageAbout)) {
      foreach($pageAbout as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrAboutProgress[$k][$key] =$v ;
            }
         } else {
            $arrAbout[$key] = $value;
         }
      }
   }
?>
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <div class="blogs px-1">
      <h3 class="text-center">Thiết lập Blogs</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start border-bottom pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="home_blogs_title-bg"><?php echo getOption('home_blogs_title-bg', 'label') ?></label>
                           <input type="text" name="home_blogs_title-bg" id="home_blogs_title-bg" class="form-control"
                              placeholder="<?php echo getOption('home_blogs_title-bg', 'label') ?>..."
                              value="<?php echo !empty($oldService) ? $oldService['home_blogs_title-bg'] : getOption('home_blogs_title-bg') ?>">
                           <?php echo !empty($errors['home_blogs_title-bg']) ? form_error('home_blogs_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="home_blogs_title"><?php echo getOption('home_blogs_title', 'label') ?></label>
                           <input type="text" name="home_blogs_title" id="home_blogs_title" class="form-control"
                              placeholder="<?php echo getOption('home_blogs_title', 'label') ?>..."
                              value="<?php echo !empty($oldService) ? $oldService['home_blogs_title'] : getOption('home_blogs_title') ?>">
                           <?php echo !empty($errors['home_blogs_title']) ? form_error('home_blogs_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="home_blogs_content"><?php echo getOption('home_blogs_content', 'label') ?></label>
                           <textarea type="text" name="home_blogs_content" id="home_blogs_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('home_blogs_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['home_blogs_content'] : getOption('home_blogs_content') ?></textarea>
                           <?php echo !empty($errors['home_blogs_content']) ? form_error('home_blogs_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="px-1 mb-2">
      <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
   </div>
</form>

<?php
   layout('footer', 'admin', $data);
?>