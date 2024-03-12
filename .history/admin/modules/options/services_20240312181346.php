<?php 
if(!defined('_INCODE')) die('Access denied...');
if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;
if($isRoot) {
  $checkPermission = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'options', 'services');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập dịch vụ');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập dịch vụ"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //home services
      $pageServicesTitlePage = trim($body['page_services_title_page']);
      $pageServicesTitleBg = trim($body['page_services_title-bg']);
      $pageServicesTitle = trim($body['page_services_title']);
      $pageServicesContent = trim($body['page_services_content']);

      if(empty($pageServicesTitlePage)) {
         $errors['page_services_title_page']['required'] = 'Không được để trống tiêu đề trang';
      }

      if(empty($pageServicesTitleBg)) {
         $errors['page_services_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($pageServicesTitle)) {
         $errors['page_services_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($pageServicesContent)) {
         $errors['page_services_content']['required'] = 'Không được để trống nội dung';
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
         redirect('admin/?module=options&action=services');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('old', $body);
         redirect('admin/?module=options&action=services');
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
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_services_title_page"><?php echo getOption('page_services_title_page', 'label') ?></label>
                           <input type="text" name="page_services_title_page" id="page_services_title_page"
                              class="form-control"
                              placeholder="<?php echo getOption('page_services_title_page', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_services_title_page'] : getOption('page_services_title_page') ?>">
                           <?php echo !empty($errors['page_services_title_page']) ? form_error('page_services_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_services_title-bg"><?php echo getOption('page_services_title-bg', 'label') ?></label>
                           <input type="text" name="page_services_title-bg" id="page_services_title-bg"
                              class="form-control"
                              placeholder="<?php echo getOption('page_services_title-bg', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_services_title-bg'] : getOption('page_services_title-bg') ?>">
                           <?php echo !empty($errors['page_services_title-bg']) ? form_error('page_services_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_services_title"><?php echo getOption('page_services_title', 'label') ?></label>
                           <input type="text" name="page_services_title" id="page_services_title" class="form-control"
                              placeholder="<?php echo getOption('page_services_title', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_services_title'] : getOption('page_services_title') ?>">
                           <?php echo !empty($errors['page_services_title']) ? form_error('page_services_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_services_content"><?php echo getOption('page_services_content', 'label') ?></label>
                           <textarea type="text" name="page_services_content" id="page_services_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('page_services_content', 'label') ?>..."><?php echo !empty($old) ? $old['page_services_content'] : getOption('page_services_content') ?></textarea>
                           <?php echo !empty($errors['page_services_content']) ? form_error('page_services_content', $errors, '<span class="error">', '</span>') : false ?>
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
   <br>
</form>

<?php
   layout('footer', 'admin', $data);
?>