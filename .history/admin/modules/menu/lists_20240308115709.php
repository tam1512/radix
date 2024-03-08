<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập Menu"
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
   <div class="menu px-1">
      <h3 class="text-center">Thiết lập Menu</h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-6">
                        <ul id="myEditor" class="sortableLists list-group">
                        </ul>
                     </div>
                     <div class="col-6">

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