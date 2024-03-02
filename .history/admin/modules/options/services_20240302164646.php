<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập dịch vụ"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //home blogs
      $homeServicesTitlePage = trim($body['page_services_title_page']);
      $homeServicesTitleBg = trim($body['home_services_title-bg']);
      $homeServicesTitle = trim($body['home_services_title']);
      $homeServicesContent = trim($body['home_services_content']);

      if(empty($homeServicesTitlePage)) {
         $errors['page_services_title_page']['required'] = 'Không được để trống tiêu đề trang';
      }

      if(empty($homeServicesTitleBg)) {
         $errors['home_services_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($homeServicesTitle)) {
         $errors['home_services_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($homeServicesContent)) {
         $errors['home_services_content']['required'] = 'Không được để trống nội dung';
      }


      if(empty($errors)) {
         $updateStatus = updateOptions('page_services');

         if($updateStatus) {
               setFlashData('msg', 'Chỉnh sửa trang dịch vụ thành công.');
               setFlashData('msg_type', 'success');
         } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=blogs');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('old', $body);
         redirect('admin/?module=options&action=blogs');
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $old = getFlashData('old');
?>
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <div class="services px-1">
      <h3 class="text-center">Thiết lập dịch vụ</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start border-bottom pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="home_services_title-bg"><?php echo getOption('home_services_title-bg', 'label') ?></label>
                           <input type="text" name="home_services_title-bg" id="home_services_title-bg"
                              class="form-control"
                              placeholder="<?php echo getOption('home_services_title-bg', 'label') ?>..."
                              value="<?php echo !empty($oldService) ? $oldService['home_services_title-bg'] : getOption('home_services_title-bg') ?>">
                           <?php echo !empty($errors['home_services_title-bg']) ? form_error('home_services_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="home_services_title"><?php echo getOption('home_services_title', 'label') ?></label>
                           <input type="text" name="home_services_title" id="home_services_title" class="form-control"
                              placeholder="<?php echo getOption('home_services_title', 'label') ?>..."
                              value="<?php echo !empty($oldService) ? $oldService['home_services_title'] : getOption('home_services_title') ?>">
                           <?php echo !empty($errors['home_services_title']) ? form_error('home_services_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="home_services_content"><?php echo getOption('home_services_content', 'label') ?></label>
                           <textarea type="text" name="home_services_content" id="home_services_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('home_services_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['home_services_content'] : getOption('home_services_content') ?></textarea>
                           <?php echo !empty($errors['home_services_content']) ? form_error('home_services_content', $errors, '<span class="error">', '</span>') : false ?>
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