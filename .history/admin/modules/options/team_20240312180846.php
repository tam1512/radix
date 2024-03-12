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
  $checkPermission = checkPermission($permissionData, 'options', 'team');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập Team');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

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
      'team_member_linkedin' => 'link linkedin',
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
            <div class="d-flex align-items-start border-bottom pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label for="team_title_page">Tiêu đề tramg</label>
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
                        <hr>
                        </hr>
                        <h4>Các thành viên</h4>
                        <div class="form-group">
                           <div class="team-list">
                              <?php 
                              if(!empty($arrMember)):
                                 foreach($arrMember as $key => $value):
                           ?>
                              <div class="team-item">
                                 <div class="row">
                                    <div class="col-11 row">
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="row ckfinder-group form-group">
                                             <div class="col-10">
                                                <label for="team_member_img">Ảnh thành viên</label>
                                                <input type="text" name="page_team[team_member_img][]"
                                                   id="team_member_img" class="form-control image-link"
                                                   placeholder="Ảnh thành viên..."
                                                   value="<?php echo !empty($value['team_member_img']) ? $value['team_member_img'] : false ?>">
                                                <?php echo !empty($errors['team_member_img']) ? form_error($key, $errors['team_member_img'], '<span class="error">', '</span>') : false?>
                                             </div>
                                             <div class="col-2 pt-30">
                                                <button type="button"
                                                   class="btn btn-success btn-block ckfinder-choose-image">
                                                   <i class="fa fa-upload" aria-hidden="true"></i>
                                                </button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_name">Tên thành viên</label>
                                             <input type="text" name="page_team[team_member_name][]"
                                                id="team_member_name" class="form-control image-link"
                                                placeholder="Tên thành viên..."
                                                value="<?php echo !empty($value['team_member_name']) ? $value['team_member_name'] : false ?>">
                                             <?php echo !empty($errors['team_member_name']) ? form_error($key, $errors['team_member_name'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_position">Chức vụ</label>
                                             <input type="text" name="page_team[team_member_position][]"
                                                id="team_member_position" class="form-control image-link"
                                                placeholder="Chức vụ..."
                                                value="<?php echo !empty($value['team_member_position']) ? $value['team_member_position'] : false ?>">
                                             <?php echo !empty($errors['team_member_position']) ? form_error($key, $errors['team_member_position'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_facebook">Liên kết Facebook</label>
                                             <input type="text" name="page_team[team_member_facebook][]"
                                                id="team_member_facebook" class="form-control image-link"
                                                placeholder="Liên kết facebook..."
                                                value="<?php echo !empty($value['team_member_facebook']) ? $value['team_member_facebook'] : false ?>">
                                             <?php echo !empty($errors['team_member_facebook']) ? form_error($key, $errors['team_member_facebook'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_twitter">Liên kết Twitter</label>
                                             <input type="text" name="page_team[team_member_twitter][]"
                                                id="team_member_twitter" class="form-control image-link"
                                                placeholder="Liên kết twitter..."
                                                value="<?php echo !empty($value['team_member_twitter']) ? $value['team_member_twitter'] : false ?>">
                                             <?php echo !empty($errors['team_member_twitter']) ? form_error($key, $errors['team_member_twitter'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_linkedin">Liên kết Linkedin</label>
                                             <input type="text" name="page_team[team_member_linkedin][]"
                                                id="team_member_linkedin" class="form-control image-link"
                                                placeholder="Liên kết linkedin..."
                                                value="<?php echo !empty($value['team_member_linkedin']) ? $value['team_member_linkedin'] : false ?>">
                                             <?php echo !empty($errors['team_member_linkedin']) ? form_error($key, $errors['team_member_linkedin'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-12">
                                          <div class="form-group">
                                             <label for="team_member_behance">Liên kết Behance</label>
                                             <input type="text" name="page_team[team_member_behance][]"
                                                id="team_member_behance" class="form-control image-link"
                                                placeholder="Liên kết behance..."
                                                value="<?php echo !empty($value['team_member_behance']) ? $value['team_member_behance'] : false ?>">
                                             <?php echo !empty($errors['team_member_behance']) ? form_error($key, $errors['team_member_behance'], '<span class="error">', '</span>') : false?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-1 pt-30">
                                       <button class="btn btn-danger btn-block remove">X</button>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <?php
                              endforeach;
                           endif;
                           ?>
                           </div>
                        </div>
                        <div class="form-group">
                           <button type="button" class="btn btn-warning" id="addTeam">Thêm đối tác</button>
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