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
   <div class="partners px-1">
      <h3 class="text-center"><?php echo getOption('home_partners', 'label') ?></h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start border-bottom pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-12">
                        <div class="form-group">
                           <label for="partners_title_bg">Tiêu đề nền</label>
                           <input type="text" name="home_partners[partners_title_bg]" id="partners_title_bg"
                              class="form-control" placeholder="Tiêu đề nền..."
                              value="<?php echo !empty($arrPartnersContent['partners_title_bg']) ? $arrPartnersContent['partners_title_bg'] : false ?>">
                           <?php echo !empty('partners_title_bg') ? form_error('partners_title_bg', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="partners_title">Tiêu đề</label>
                           <input type="text" name="home_partners[partners_title]" id="partners_title"
                              class="form-control" placeholder="Tiêu đề..."
                              value="<?php echo !empty($arrPartnersContent['partners_title']) ? $arrPartnersContent['partners_title'] : false ?>">
                           <?php echo !empty('partners_title') ? form_error('partners_title', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="partners_desc">Mô tả</label>
                           <textarea type="text" name="home_partners[partners_desc]" id="partners_desc"
                              class="form-control editor"
                              placeholder="Mô tả..."><?php echo !empty($arrPartnersContent['partners_desc']) ? html_entity_decode($arrPartnersContent['partners_desc']) : false ?></textarea>
                           <?php echo !empty('partners_desc') ? form_error('partners_desc', $errors, '<span class="error">', '</span>') : false ?>
                        </div>
                     </div>
                     <div class="col-12">
                        <label for="">Các đối tác</label>
                        <div class="form-group">
                           <div class="partners-list">
                              <?php 
                              if(!empty($arrPartners)):
                                 foreach($arrPartners as $key => $value):
                           ?>
                              <div class="partners-item">
                                 <div class="row">
                                    <div class="col-7">
                                       <div class="row ckfinder-group">
                                          <div class="col-9">
                                             <input type="text" name="home_partners[partners_imgs][]" id="partners_imgs"
                                                class="form-control image-link" placeholder="Ảnh đối tác..."
                                                value="<?php echo !empty($value['partners_imgs']) ? $value['partners_imgs'] : false ?>">
                                             <?php echo !empty($errors['partners_imgs']) ? form_error($key, $errors['partners_imgs'], '<span class="error">', '</span>') : false?>
                                          </div>
                                          <div class="col-3">
                                             <button type="button"
                                                class="btn btn-success btn-block ckfinder-choose-image">
                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="form-group">
                                          <input type="text" name="home_partners[partners_links][]" id="partners_links"
                                             class="form-control image-link" placeholder="Liên kết..."
                                             value="<?php echo !empty($value['partners_links']) ? $value['partners_links'] : false ?>">
                                          <?php echo !empty($errors['partners_links']) ? form_error($key, $errors['partners_links'], '<span class="error">', '</span>') : false?>
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
                           <button type="button" class="btn btn-warning" id="addPartners">Thêm đối tác</button>
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