<div class="footer_2 px-1">
   <h3 class="text-center"><?php echo getOption('home_facts', 'label') ?></h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_title">Tiêu đề</label>
                        <input type="text" name="home_facts[footer_2_title]" id="footer_2_title" class="form-control"
                           placeholder="Tiêu đề..."
                           value="<?php echo !empty($arrFactsContent['footer_2_title']) ? $arrFactsContent['footer_2_title'] : false ?>">
                        <?php echo !empty('footer_2_title') ? form_error('footer_2_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_title">Tiêu đề</label>
                        <input type="text" name="home_facts[footer_2_title]" id="footer_2_title" class="form-control"
                           placeholder="Tiêu đề..."
                           value="<?php echo !empty($arrFactsContent['footer_2_title']) ? $arrFactsContent['footer_2_title'] : false ?>">
                        <?php echo !empty('footer_2_title') ? form_error('footer_2_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_desc">Mô tả</label>
                        <textarea type="text" name="home_facts[footer_2_desc]" id="footer_2_desc"
                           class="form-control editor"
                           placeholder="Mô tả..."><?php echo !empty($arrFactsContent['footer_2_desc']) ? html_entity_decode($arrFactsContent['footer_2_desc']) : false ?></textarea>
                        <?php echo !empty('footer_2_desc') ? form_error('footer_2_desc', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_button_title">Nút liên hệ</label>
                        <input type="text" name="home_facts[footer_2_button_title]" id="footer_2_button_title"
                           class="form-control" placeholder="Nút liên hệ..."
                           value="<?php echo !empty($arrFactsContent['footer_2_button_title']) ? $arrFactsContent['footer_2_button_title'] : false ?>">
                        <?php echo !empty('footer_2_button_title') ? form_error('footer_2_button_title', $errors, '<span class="error">', '</span>') : false?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_2_button_link">Link nút</label>
                        <input type="text" name="home_facts[footer_2_button_link]" id="footer_2_button_link"
                           class="form-control" placeholder="Link nút..."
                           value="<?php echo !empty($arrFactsContent['footer_2_button_link']) ? $arrFactsContent['footer_2_button_link'] : false ?>">
                        <?php echo !empty('footer_2_button_link') ? form_error('footer_2_button_link', $errors, '<span class="error">', '</span>') : false?>
                     </div>
                  </div>
                  <div class="col-12">
                     <label for="">Các thành tựu</label>
                     <div class="form-group">
                        <div class="facts">
                           <?php 
                              if(!empty($arrFacts)):
                                 foreach($arrFacts as $key => $value):
                           ?>
                           <div class="footer_2_item">
                              <div class="row">
                                 <div class="col-4">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[footer_2_item_desc][]"
                                          id="footer_2_item_desc" class="form-control" placeholder="Thành tựu..."
                                          value="<?php echo !empty($value['footer_2_item_desc']) ? $value['footer_2_item_desc'] : false ?>">
                                       <?php echo !empty($errors['footer_2_item_desc']) ? form_error($key, $errors['footer_2_item_desc'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-3">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[footer_2_item_icon][]"
                                          id="footer_2_item_icon" class="form-control" placeholder="Icon..."
                                          value="<?php echo !empty($value['footer_2_item_icon']) ? $value['footer_2_item_icon'] : false ?>">
                                       <?php echo !empty($errors['footer_2_item_icon']) ? form_error($key, $errors['footer_2_item_icon'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-2">
                                    <div class="form-group">
                                       <input type="number" name="home_facts[footer_2_item_number][]"
                                          id="footer_2_item_number" class="form-control" placeholder="Số lượng..."
                                          value="<?php echo !empty($value['footer_2_item_number']) ? $value['footer_2_item_number'] : false ?>">
                                       <?php echo !empty($errors['footer_2_item_number']) ? form_error($key, $errors['footer_2_item_number'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-2">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[footer_2_item_unit][]"
                                          id="footer_2_item_unit" class="form-control" placeholder="Đơn vị tính..."
                                          value="<?php echo !empty($value['footer_2_item_unit']) ? $value['footer_2_item_unit'] : false ?>">
                                       <?php echo !empty($errors['footer_2_item_unit']) ? form_error($key, $errors['footer_2_item_unit'], '<span class="error">', '</span>') : false?>
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