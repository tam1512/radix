<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập Team"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueTeam = [
      'about_title_page' => 'tiêu đề trang',
      'about_title_bg' => 'tiêu đề nền',
      'about_title' => 'tiêu đề',
      'about_desc' => 'mô tả',
      'about_member_img' => 'ảnh',
      'about_member_name' => 'tên thành viên',
      'about_member_position' => 'Chức vụ',
      'about_member_facebook' => 'link facebook',
      'about_member_twitter' => 'link twitter',
      'about_member_instagram' => 'link instagram',
      'about_member_behance' => 'link behance',
   ];

   if(isGet()) {
      //get default about
      $jsonDataAbout = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'page_team'")['opt_value'];
      $pageTeam = json_decode($jsonDataAbout, true);
      setFlashData('aboutDefault', $pageTeam);
   }

   if(isPost()) {
               
      $errors = [];
      $arrTeam = [];

      $body = getBody('post');

      //page_team
      if(!empty(getBody('post')['page_team'])) {
         $pageTeam = getBody('post')['page_team'];
         foreach($pageTeam as $key => $value) {
            if(is_array($value)) {
               foreach($value as $k => $v) {
                  $arrMember[$k][$key] =$v ;
               }
            } else {
               $arrTeam[$key] = $value;
            }
         }
      }

      //xử lý lỗi của page_team
      foreach($arrTeam as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValueTeam
      [$key];
         }
      }
      foreach($arrMember as $key => $value) {
         foreach($value as $k => $v) {
         if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueTeam
      [$k];
         }
         }
      }

      if(empty($errors)) {
         $jsonTeam = json_encode($pageTeam);
         
         // Không có lỗi xảy ra

         $dataAboutUpdate = [
            'opt_value' => $jsonTeam,
         ];

         $updateAboutStatus = update('options', $dataAboutUpdate, "opt_key = 'page_team'");
         if($updateAboutStatus) {
               setFlashData('msg', 'Chỉnh sửa trang Team thành công.');
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
         setFlashData('oldAbout', $pageTeam);
         redirect('admin/?module=options&action=about');
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $oldAbout = getFlashData('oldAbout');

   //old about
   if(empty($oldAbout)) {
      $pageTeam = getFlashData('aboutDefault');
   } else {
      $pageTeam = $oldAbout;
   }
   if(!empty($pageTeam)) {
      foreach($pageTeam as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrMember[$k][$key] =$v ;
            }
         } else {
            $arrTeam[$key] = $value;
         }
      }
   }
?>
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <div class="about px-1">
      <h3 class="text-center"><?php echo getOption('page_team', 'label') ?></h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title_page">Tiêu đề trang</label>
                           <input type="text" name="page_team[about_title_page]" id="about_title_page"
                              class="form-control" placeholder="Tiêu đề trang..."
                              value="<?php echo !empty($arrTeam['about_title_page']) ? $arrTeam['about_title_page'] : false ?>">
                           <?php echo !empty('about_title_page') ? form_error('about_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title_bg">Tiêu đề nền</label>
                           <input type="text" name="page_team[about_title_bg]" id="about_title_bg" class="form-control"
                              placeholder="Tiêu đề nền..."
                              value="<?php echo !empty($arrTeam['about_title_bg']) ? $arrTeam['about_title_bg'] : false ?>">
                           <?php echo !empty('about_title_bg') ? form_error('about_title_bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_title">Tiêu đề</label>
                           <input type="text" name="page_team[about_title]" id="about_title" class="form-control"
                              placeholder="Tiêu đề..."
                              value="<?php echo !empty($arrTeam['about_title']) ? $arrTeam['about_title'] : false ?>">
                           <?php echo !empty('about_title') ? form_error('about_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_desc">Mô tả</label>
                           <textarea type="text" name="page_team[about_desc]" id="about_desc"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrTeam['about_desc']) ? html_entity_decode($arrTeam['about_desc']) : false ?></textarea>
                           <?php echo !empty('about_desc') ? form_error('about_desc', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_image">Ảnh</label>
                           <div class="row ckfinder-group">
                              <div class="col-9">
                                 <input type="text" name="page_team[about_image]" id="about_image"
                                    class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                    value="<?php echo !empty($arrTeam['about_image']) ? $arrTeam['about_image'] : false ?>">
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
                           <input type="text" name="page_team[about_youtube_link]" id="about_youtube_link"
                              class="form-control" placeholder="Link Youtube..."
                              value="<?php echo !empty($arrTeam['about_youtube_link']) ? $arrTeam['about_youtube_link'] : false ?>">
                           <?php echo !empty('about_youtube_link') ? form_error('about_youtube_link', $errors, '<span class="error">', '</span>') : false?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="about_content">
                              Nội dung Team
                           </label>
                           <textarea type="text" name="page_team[about_content]" id="about_content"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrTeam['about_content']) ? html_entity_decode($arrTeam['about_content']) : false ?></textarea>
                           <?php echo !empty('about_content') ? form_error('about_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <label for="">Mức độ tiến hành</label>
                        <div class="form-group">
                           <div class="about_progress">
                              <?php 
                              if(!empty($arrMember)):
                                 foreach($arrMember as $key => $value):
                           ?>
                              <div class="about_progress-item">
                                 <div class="row">
                                    <div class="col-5 ">
                                       <div class="form-group">
                                          <input type="text" name="page_team[about_progress_name][]"
                                             id="about_progress_name" class="form-control"
                                             placeholder="Tên công việc..."
                                             value="<?php echo !empty($value['about_progress_name']) ? $value['about_progress_name'] : false ?>">
                                          <?php echo !empty($errors['about_progress_name']) ? form_error($key, $errors['about_progress_name'], '<span class="error">', '</span>') : false?>
                                       </div>
                                    </div>
                                    <div class="col-6">
                                       <input class="progress-range" type="text" name="page_team[progress-range][]"
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