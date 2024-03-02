<?php 
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập Team"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueTeam = [
      'team_title_page' => 'tiêu đề trang',
      'team_title_bg' => 'tiêu đề nền',
      'team_title' => 'tiêu đề',
      'team_desc' => 'mô tả',
      'team_member_img' => 'ảnh',
      'team_member_name' => 'tên thành viên',
      'team_member_position' => 'Chức vụ',
      'team_member_facebook' => 'link facebook',
      'team_member_twitter' => 'link twitter',
      'team_member_instagram' => 'link instagram',
      'team_member_behance' => 'link behance',
   ];

   if(isGet()) {
      //get default team
      $jsonDatateam = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'page_team'")['opt_value'];
      $pageTeam = json_decode($jsonDatateam, true);
      setFlashData('teamDefault', $pageTeam);
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

         $dataTeamUpdate = [
            'opt_value' => $jsonTeam,
         ];

         $updateTeamStatus = update('options', $dataTeamUpdate, "opt_key = 'page_team'");
         if($updateTeamStatus) {
               setFlashData('msg', 'Chỉnh sửa trang Team thành công.');
               setFlashData('msg_type', 'success');
         } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=team');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('oldTeam', $pageTeam);
         redirect('admin/?module=options&action=team');
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $oldTeam = getFlashData('oldTeam');

   //old team
   if(empty($oldTeam)) {
      $pageTeam = getFlashData('teamDefault');
   } else {
      $pageTeam = $oldTeam;
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
   <div class="team px-1">
      <h3 class="text-center"><?php echo getOption('page_team', 'label') ?></h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_title_page">Tiêu đề trang</label>
                           <input type="text" name="page_team[team_title_page]" id="team_title_page"
                              class="form-control" placeholder="Tiêu đề trang..."
                              value="<?php echo !empty($arrTeam['team_title_page']) ? $arrTeam['team_title_page'] : false ?>">
                           <?php echo !empty('team_title_page') ? form_error('team_title_page', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_title_bg">Tiêu đề nền</label>
                           <input type="text" name="page_team[team_title_bg]" id="team_title_bg" class="form-control"
                              placeholder="Tiêu đề nền..."
                              value="<?php echo !empty($arrTeam['team_title_bg']) ? $arrTeam['team_title_bg'] : false ?>">
                           <?php echo !empty('team_title_bg') ? form_error('team_title_bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_title">Tiêu đề</label>
                           <input type="text" name="page_team[team_title]" id="team_title" class="form-control"
                              placeholder="Tiêu đề..."
                              value="<?php echo !empty($arrTeam['team_title']) ? $arrTeam['team_title'] : false ?>">
                           <?php echo !empty('team_title') ? form_error('team_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_desc">Mô tả</label>
                           <textarea type="text" name="page_team[team_desc]" id="team_desc" class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrTeam['team_desc']) ? html_entity_decode($arrTeam['team_desc']) : false ?></textarea>
                           <?php echo !empty('team_desc') ? form_error('team_desc', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_image">Ảnh</label>
                           <div class="row ckfinder-group">
                              <div class="col-9">
                                 <input type="text" name="page_team[team_image]" id="team_image"
                                    class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                    value="<?php echo !empty($arrTeam['team_image']) ? $arrTeam['team_image'] : false ?>">
                                 <?php echo !empty('team_image') ? form_error('team_image', $errors, '<span class="error">', '</span>') : false ?>
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
                           <label for="team_youtube_link">Link Youtube</label>
                           <input type="text" name="page_team[team_youtube_link]" id="team_youtube_link"
                              class="form-control" placeholder="Link Youtube..."
                              value="<?php echo !empty($arrTeam['team_youtube_link']) ? $arrTeam['team_youtube_link'] : false ?>">
                           <?php echo !empty('team_youtube_link') ? form_error('team_youtube_link', $errors, '<span class="error">', '</span>') : false?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_content">
                              Nội dung Team
                           </label>
                           <textarea type="text" name="page_team[team_content]" id="team_content"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrTeam['team_content']) ? html_entity_decode($arrTeam['team_content']) : false ?></textarea>
                           <?php echo !empty('team_content') ? form_error('team_content', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <label for="">Mức độ tiến hành</label>
                        <div class="form-group">
                           <div class="team_progress">
                              <?php 
                              if(!empty($arrMember)):
                                 foreach($arrMember as $key => $value):
                           ?>
                              <div class="team_progress-item">
                                 <div class="row">
                                    <div class="col-5 ">
                                       <div class="form-group">
                                          <input type="text" name="page_team[team_progress_name][]"
                                             id="team_progress_name" class="form-control" placeholder="Tên công việc..."
                                             value="<?php echo !empty($value['team_progress_name']) ? $value['team_progress_name'] : false ?>">
                                          <?php echo !empty($errors['team_progress_name']) ? form_error($key, $errors['team_progress_name'], '<span class="error">', '</span>') : false?>
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
                           <button type="button" class="btn btn-warning" id="addteamProgress">Thêm công việc</button>
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