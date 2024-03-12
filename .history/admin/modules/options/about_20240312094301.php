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
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Nhóm người dùng');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập Giới thiệu"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueAbout = [
      'about_title_page' => 'tiêu đề trang',
      'about_title_bg' => 'tiêu đề nền',
      'about_title' => 'tiêu đề',
      'about_content' => 'nội dung',
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
   <div class="about px-1">
      <h3 class="text-center"><?php echo getOption('page_about', 'label') ?></h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title_page">Tiêu đề trang</label>
                           <input type="text" name="page_about[about_title_page]" id="about_title_page"
                              class="form-control" placeholder="Tiêu đề trang..."
                              value="<?php echo !empty($arrAbout['about_title_page']) ? $arrAbout['about_title_page'] : false ?>">
                           <?php echo !empty('about_title_page') ? form_error('about_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title_bg">Tiêu đề nền</label>
                           <input type="text" name="page_about[about_title_bg]" id="about_title_bg" class="form-control"
                              placeholder="Tiêu đề nền..."
                              value="<?php echo !empty($arrAbout['about_title_bg']) ? $arrAbout['about_title_bg'] : false ?>">
                           <?php echo !empty('about_title_bg') ? form_error('about_title_bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title">Tiêu đề</label>
                           <input type="text" name="page_about[about_title]" id="about_title" class="form-control"
                              placeholder="Tiêu đề..."
                              value="<?php echo !empty($arrAbout['about_title']) ? $arrAbout['about_title'] : false ?>">
                           <?php echo !empty('about_title') ? form_error('about_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_desc">Mô tả</label>
                           <textarea type="text" name="page_about[about_desc]" id="about_desc"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrAbout['about_desc']) ? html_entity_decode($arrAbout['about_desc']) : false ?></textarea>
                           <?php echo !empty('about_desc') ? form_error('about_desc', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_image">Ảnh</label>
                           <div class="row ckfinder-group">
                              <div class="col-9">
                                 <input type="text" name="page_about[about_image]" id="about_image"
                                    class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                    value="<?php echo !empty($arrAbout['about_image']) ? $arrAbout['about_image'] : false ?>">
                                 <?php echo !empty('about_image') ? form_error('about_image', $errors, '<span class="error">', '</span>') : false ?>
                              </div>
                              <div class="col-3">
                                 <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_youtube_link">Link Youtube</label>
                           <input type="text" name="page_about[about_youtube_link]" id="about_youtube_link"
                              class="form-control" placeholder="Link Youtube..."
                              value="<?php echo !empty($arrAbout['about_youtube_link']) ? $arrAbout['about_youtube_link'] : false ?>">
                           <?php echo !empty('about_youtube_link') ? form_error('about_youtube_link', $errors, '<span class="error">', '</span>') : false?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_content">
                              Nội dung giới thiệu
                           </label>
                           <textarea type="text" name="page_about[about_content]" id="about_content"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrAbout['about_content']) ? html_entity_decode($arrAbout['about_content']) : false ?></textarea>
                           <?php echo !empty('about_content') ? form_error('about_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <label for="">Mức độ tiến hành</label>
                        <div class="form-group">
                           <div class="about_progress">
                              <?php 
                              if(!empty($arrAboutProgress)):
                                 foreach($arrAboutProgress as $key => $value):
                           ?>
                              <div class="about_progress-item">
                                 <div class="row">
                                    <div class="col-5 ">
                                       <div class="form-group">
                                          <input type="text" name="page_about[about_progress_name][]"
                                             id="about_progress_name" class="form-control"
                                             placeholder="Tên công việc..."
                                             value="<?php echo !empty($value['about_progress_name']) ? $value['about_progress_name'] : false ?>">
                                          <?php echo !empty($errors['about_progress_name']) ? form_error($key, $errors['about_progress_name'], '<span class="error">', '</span>') : false?>
                                       </div>
                                    </div>
                                    <div class="col-6">
                                       <input class="progress-range" type="text" name="page_about[progress-range][]"
                                          value="<?php echo !empty($value['progress-range']) ? $value['progress-range'] : false ?>">
                                       <?php echo !empty($errors['progress-range']) ? form_error($key, $errors['progress-range'], '<span class="error">', '</span>') : false?>
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
                           <button type="button" class="btn btn-warning" id="addAboutProgress">Thêm công việc</button>
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