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
    $checkPermission = checkPermission($permissionData, 'about', 'lists');
  }
  
  
  if(!$checkPermission) {
    setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập giới thiệu');
    setFlashData('msg_type', 'danger');
    redirect("admin/");
  }

   $data = [
      'title' => "Thiết lập Bài viết"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //page blogs
      $pageBlogsTitlePage = trim($body['page_blogs_title_page']);
      $pageBlogsTitleBg = trim($body['page_blogs_title-bg']);
      $pageBlogsTitle = trim($body['page_blogs_title']);
      $pageBlogsContent = trim($body['page_blogs_content']);

      if(empty($pageBlogsTitlePage)) {
         $errors['page_blogs_title_page']['required'] = 'Không được để trống tiêu đề trang';
      }

      if(empty($pageBlogsTitleBg)) {
         $errors['page_blogs_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($pageBlogsTitle)) {
         $errors['page_blogs_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($pageBlogsContent)) {
         $errors['page_blogs_content']['required'] = 'Không được để trống nội dung';
      }

      if(empty($errors)) {
         $updateStatus = updateOptions('page_blogs');

         if($updateStatus) {
               setFlashData('msg', 'Chỉnh sửa trang Blogs thành công.');
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
   <div class="blogs px-1">
      <h3 class="text-center">Thiết lập Blogs</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_blogs_title_page"><?php echo getOption('page_blogs_title_page', 'label') ?></label>
                           <input type="text" name="page_blogs_title_page" id="page_blogs_title_page"
                              class="form-control"
                              placeholder="<?php echo getOption('page_blogs_title_page', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_blogs_title_page'] : getOption('page_blogs_title_page') ?>">
                           <?php echo !empty($errors['page_blogs_title-bg']) ? form_error('page_blogs_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_blogs_title-bg"><?php echo getOption('page_blogs_title-bg', 'label') ?></label>
                           <input type="text" name="page_blogs_title-bg" id="page_blogs_title-bg" class="form-control"
                              placeholder="<?php echo getOption('page_blogs_title-bg', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_blogs_title-bg'] : getOption('page_blogs_title-bg') ?>">
                           <?php echo !empty($errors['page_blogs_title-bg']) ? form_error('page_blogs_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="page_blogs_title"><?php echo getOption('page_blogs_title', 'label') ?></label>
                           <input type="text" name="page_blogs_title" id="page_blogs_title" class="form-control"
                              placeholder="<?php echo getOption('page_blogs_title', 'label') ?>..."
                              value="<?php echo !empty($old) ? $old['page_blogs_title'] : getOption('page_blogs_title') ?>">
                           <?php echo !empty($errors['page_blogs_title']) ? form_error('page_blogs_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label
                              for="page_blogs_content"><?php echo getOption('page_blogs_content', 'label') ?></label>
                           <textarea type="text" name="page_blogs_content" id="page_blogs_content"
                              class="form-control editor"
                              placeholder="<?php echo getOption('page_blogs_content', 'label') ?>..."><?php echo !empty($old) ? $old['page_blogs_content'] : getOption('page_blogs_content') ?></textarea>
                           <?php echo !empty($errors['page_blogs_content']) ? form_error('page_blogs_content', $errors, '<span class="error">', '</span>') : false ?>
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