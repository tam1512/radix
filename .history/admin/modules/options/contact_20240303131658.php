<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập liên hệ"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //home contact
      $pageContactTitlePage = trim($body['page_contact_title_page']);
      $pageContactTitleBg = trim($body['page_contact_title-bg']);
      $pageContactTitle = trim($body['page_contact_title']);
      $pageContactContent = trim($body['page_contact_content']);
      $pageContactMessageType = !empty($body['page_contact_message_type']) ? array_filter($body['page_contact_message_type']) : false;

      if(empty($pageContactTitlePage)) {
         $errors['page_contact_title_page']['required'] = 'Không được để trống tiêu đề trang';
      }

      if(empty($pageContactTitleBg)) {
         $errors['page_contact_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($pageContactTitle)) {
         $errors['page_contact_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($pageContactContent)) {
         $errors['page_contact_content']['required'] = 'Không được để trống nội dung';
      }

      if(!empty($pageContactMessageType)) {
         foreach($pageContactMessageType as $key => $value) {
            if(empty($value)) {
               $errors['page_contact_message_type'][$key]['required'] = 'Không được để trống loại liên kết';
            }
         }
      }

      if(empty($errors)) {
         $updateStatus = updateOptions('page_contact');

         if($updateStatus) {
               setFlashData('msg', 'Chỉnh sửa trang liên hệ thành công.');
               setFlashData('msg_type', 'success');
         } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=contact');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('old', $body);
         redirect('admin/?module=options&action=contact');
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $old = getFlashData('old');

   $arrMessageType = [];
   if(!empty($old['page_contact_message_type'])) {
      $arrMessageType = $old['page_contact_message_type'];
   } else {
      $jsonMessageType = getOption('page_contact_message_type');
      $arrMessageType = json_decode($jsonMessageType, true);
   }
?>
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <div class="contact px-1">
      <h3 class="text-center">Thiết lập liên hệ</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_contact_title_page"><?php echo getOption('page_contact_title_page', 'label') ?></label>
                           <input type="text" name="page_contact_title_page" id="page_contact_title_page"
                              class="form-control"
                              placeholder="<?php echo getOption('page_contact_title_page', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_contact_title_page'] : getOption('page_contact_title_page') ?>">
                           <?php echo !empty($errors['page_contact_title_page']) ? form_error('page_contact_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_contact_title-bg"><?php echo getOption('page_contact_title-bg', 'label') ?></label>
                           <input type="text" name="page_contact_title-bg" id="page_contact_title-bg"
                              class="form-control"
                              placeholder="<?php echo getOption('page_contact_title-bg', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_contact_title-bg'] : getOption('page_contact_title-bg') ?>">
                           <?php echo !empty($errors['page_contact_title-bg']) ? form_error('page_contact_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_contact_title"><?php echo getOption('page_contact_title', 'label') ?></label>
                           <input type="text" name="page_contact_title" id="page_contact_title" class="form-control"
                              placeholder="<?php echo getOption('page_contact_title', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_contact_title'] : getOption('page_contact_title') ?>">
                           <?php echo !empty($errors['page_contact_title']) ? form_error('page_contact_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_contact_content"><?php echo getOption('page_contact_content', 'label') ?></label>
                           <textarea type="text" name="page_contact_content" id="page_contact_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('page_contact_content', 'label') ?>..."><?php echo !empty($old) ? $old['page_contact_content'] : getOption('page_contact_content') ?></textarea>
                           <?php echo !empty($errors['page_contact_content']) ? form_error('page_contact_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <label
                           for="page_contact_message_type"><?php echo getOption('page_contact_message_type', 'label') ?>
                        </label>
                        <div class="form-group">
                           <div class="message_type">
                              <?php 
                              if(!empty($arrMessageType)):
                                 foreach($arrMessageType as $key => $value):
                           ?>
                              <div class="message_type-item">
                                 <div class="row">
                                    <div class="col-11">
                                       <div class="form-group">
                                          <input type="text" name="page_contact_message_type[]"
                                             id="page_contact_message_type" class="form-control"
                                             placeholder="Liên hệ..."
                                             value="<?php echo !empty($value) ? $value : false ?>">
                                          <?php echo !empty($errors['page_contact_message_type']) ? form_error($key, $errors['page_contact_message_type'], '<span class="error">', '</span>') : false?>
                                       </div>
                                    </div>
                                    <div class="col-1">
                                       <button class="btn btn-danger btn-block remove">X</button>
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
                           <button type="button" class="btn btn-warning" id="addMessageType">Thêm loại liên hệ</button>
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