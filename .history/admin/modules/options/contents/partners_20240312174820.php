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
                        <input type="text" name="home_partners[partners_title]" id="partners_title" class="form-control"
                           placeholder="Tiêu đề..."
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
                     <h2>Các thành tựu</h2>
                     <div class="form-group">
                        <div class="partners-list">
                           <?php 
                              if(!empty($arrPartners)):
                                 foreach($arrPartners as $key => $value):
                           ?>
                           <div class="partners-item">
                              <div class="row">
                                 <div class="col-11 row">
                                    <div class="col-lg-7 col-md-7 col-12 mb-2">
                                       <div class="row ckfinder-group">
                                          <div class="col-9">
                                             <label for="partners_imgs">Ảnh đối tác</label>
                                             <input type="text" name="home_partners[partners_imgs][]" id="partners_imgs"
                                                class="form-control image-link" placeholder="Ảnh đối tác..."
                                                value="<?php echo !empty($value['partners_imgs']) ? $value['partners_imgs'] : false ?>">
                                             <?php echo !empty($errors['partners_imgs']) ? form_error($key, $errors['partners_imgs'], '<span class="error">', '</span>') : false?>
                                          </div>
                                          <div class="col-3 pt-30">
                                             <button type="button"
                                                class="btn btn-success btn-block ckfinder-choose-image">
                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-12">
                                       <div class="form-group">
                                          <label for="partners_imgs">Liên kết</label>
                                          <input type="text" name="home_partners[partners_links][]" id="partners_links"
                                             class="form-control image-link" placeholder="Liên kết..."
                                             value="<?php echo !empty($value['partners_links']) ? $value['partners_links'] : false ?>">
                                          <?php echo !empty($errors['partners_links']) ? form_error($key, $errors['partners_links'], '<span class="error">', '</span>') : false?>
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
                        <button type="button" class="btn btn-warning" id="addPartners">Thêm đối tác</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<hr>