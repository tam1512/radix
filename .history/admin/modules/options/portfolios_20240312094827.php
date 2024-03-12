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
  $checkPermission = checkPermission($permissionData, 'options', 'portfolios');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập dự án');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập dự án"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //home porfolios
      $pagePortfoliosTitlePage = trim($body['page_portfolios_title_page']);
      $pagePortfoliosTitleBg = trim($body['page_portfolios_title-bg']);
      $pagePortfoliosTitle = trim($body['page_portfolios_title']);
      $pagePortfoliosContent = trim($body['page_portfolios_content']);
      $pagePortfoliosBtn = trim($body['page_portfolios_btn']);
      $pagePortfoliosBtnLink = trim($body['page_portfolios_btn_link']);

      if(empty($pagePortfoliosTitlePage)) {
         $errors['page_portfolios_title_page']['required'] = 'Không được để trống tiêu đề trang';
      }

      if(empty($pagePortfoliosTitleBg)) {
         $errors['page_portfolios_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($pagePortfoliosTitle)) {
         $errors['page_portfolios_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($pagePortfoliosContent)) {
         $errors['page_portfolios_content']['required'] = 'Không được để trống nội dung';
      }

      if(empty($pagePortfoliosBtn)) {
         $errors['page_portfolios_btn']['required'] = 'Không được để trống nội dung nút';
      }

      if(empty($pagePortfoliosBtnLink)) {
         $errors['page_portfolios_btn_link']['required'] = 'Không được để trống link nút';
      }

      if(empty($errors)) {
         $updateStatus = updateOptions('page_portfolios');

         if($updateStatus) {
               setFlashData('msg', 'Chỉnh sửa trang dự án thành công.');
               setFlashData('msg_type', 'success');
         } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=portfolios');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('old', $body);
         redirect('admin/?module=options&action=portfolios');
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
   <div class="portfolios px-1">
      <h3 class="text-center">Thiết lập dự án</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_title_page"><?php echo getOption('page_portfolios_title_page', 'label') ?></label>
                           <input type="text" name="page_portfolios_title_page" id="page_portfolios_title_page"
                              class="form-control"
                              placeholder="<?php echo getOption('page_portfolios_title_page', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_portfolios_title_page'] : getOption('page_portfolios_title_page') ?>">
                           <?php echo !empty($errors['page_portfolios_title_page']) ? form_error('page_portfolios_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_title-bg"><?php echo getOption('page_portfolios_title-bg', 'label') ?></label>
                           <input type="text" name="page_portfolios_title-bg" id="page_portfolios_title-bg"
                              class="form-control"
                              placeholder="<?php echo getOption('page_portfolios_title-bg', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_portfolios_title-bg'] : getOption('page_portfolios_title-bg') ?>">
                           <?php echo !empty($errors['page_portfolios_title-bg']) ? form_error('page_portfolios_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_title"><?php echo getOption('page_portfolios_title', 'label') ?></label>
                           <input type="text" name="page_portfolios_title" id="page_portfolios_title"
                              class="form-control"
                              placeholder="<?php echo getOption('page_portfolios_title', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_portfolios_title'] : getOption('page_portfolios_title') ?>">
                           <?php echo !empty($errors['page_portfolios_title']) ? form_error('page_portfolios_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_content"><?php echo getOption('page_portfolios_content', 'label') ?></label>
                           <textarea type="text" name="page_portfolios_content" id="page_portfolios_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('page_portfolios_content', 'label') ?>..."><?php echo !empty($old) ? $old['page_portfolios_content'] : getOption('page_portfolios_content') ?></textarea>
                           <?php echo !empty($errors['page_portfolios_content']) ? form_error('page_portfolios_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_btn"><?php echo getOption('page_portfolios_btn', 'label') ?></label>
                           <input type="text" name="page_portfolios_btn" id="page_portfolios_btn" class="form-control"
                              placeholder="<?php echo getOption('page_portfolios_btn', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_portfolios_btn'] : getOption('page_portfolios_btn') ?>">
                           <?php echo !empty($errors['page_portfolios_btn']) ? form_error('page_portfolios_btn', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_portfolios_btn_link"><?php echo getOption('page_portfolios_btn_link', 'label') ?></label>
                           <input type="text" name="page_portfolios_btn_link" id="page_portfolios_btn_link"
                              class="form-control"
                              placeholder="<?php echo getOption('page_portfolios_btn_link', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_portfolios_btn_link'] : getOption('page_portfolios_btn_link') ?>">
                           <?php echo !empty($errors['page_portfolios_btn_link']) ? form_error('page_portfolios_btn_link', $errors, '<span class="error">', '</span>') : false ?>
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