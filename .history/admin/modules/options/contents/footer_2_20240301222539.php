<div class="footer_2 px-1">
   <h3 class="text-center"><?php echo getOption('footer_2', 'label') ?></h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_title">Tiêu đề</label>
                        <input type="text" name="footer_2[footer_2_title]" id="footer_2_title" class="form-control"
                           placeholder="Tiêu đề..."
                           value="<?php echo !empty($arrFooter2['footer_2_title']) ? $arrFooter2['footer_2_title'] : false ?>">
                        <?php echo !empty('footer_2_title') ? form_error('footer_2_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <label for="">Các liên kết nhanh</label>
                     <div class="form-group">
                        <div class="footer_2_list">
                           <?php 
                              if(!empty($arrQuickLinks)):
                                 foreach($arrQuickLinks as $key => $value):
                           ?>
                           <div class="footer_2_item">
                              <div class="row">
                                 <div class="col-5">
                                    <div class="form-group">
                                       <input type="text" name="footer_2[footer_2_qick_link_content][]"
                                          id="footer_2_qick_link_content" class="form-control"
                                          placeholder="Nội dung liên kết..."
                                          value="<?php echo !empty($value['footer_2_qick_link_content']) ? $value['footer_2_qick_link_content'] : false ?>">
                                       <?php echo !empty($errors['footer_2_qick_link_content']) ? form_error($key, $errors['footer_2_qick_link_content'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-5">
                                    <div class="form-group">
                                       <input type="text" name="footer_2[footer_2_qick_link][]" id="footer_2_qick_link"
                                          class="form-control" placeholder="Link liên kết..."
                                          value="<?php echo !empty($value['footer_2_qick_link']) ? $value['footer_2_qick_link'] : false ?>">
                                       <?php echo !empty($errors['footer_2_qick_link']) ? form_error($key, $errors['footer_2_qick_link'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-2">
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
                        <button type="button" class="btn btn-warning" id="addFact">Thêm thành tựu</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<hr>