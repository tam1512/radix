<div class="about px-1">
   <h3 class="text-center"><?php echo getOption('home_facts', 'label') ?></h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="facts_title_sub">Tiêu đề phụ</label>
                        <input type="text" name="home_facts[facts_title_sub]" id="facts_title_sub" class="form-control"
                           placeholder="Tiêu đề phụ..."
                           value="<?php echo !empty($arrFactsContent['facts_title_sub']) ? $arrFactsContent['facts_title_sub'] : false ?>">
                        <?php echo !empty('facts_title_sub') ? form_error('facts_title_sub', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="facts_title">Tiêu đề</label>
                        <input type="text" name="home_facts[facts_title]" id="facts_title" class="form-control"
                           placeholder="Tiêu đề..."
                           value="<?php echo !empty($arrFactsContent['facts_title']) ? $arrFactsContent['facts_title'] : false ?>">
                        <?php echo !empty('facts_title') ? form_error('facts_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="facts_desc">Mô tả</label>
                        <textarea type="text" name="home_facts[facts_desc]" id="facts_desc" class="form-control editor"
                           placeholder="Mô tả..."><?php echo !empty($arrFactsContent['facts_desc']) ? html_entity_decode($arrFactsContent['facts_desc']) : false ?></textarea>
                        <?php echo !empty('facts_desc') ? form_error('facts_desc', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="facts_button_title">Nút liên hệ</label>
                        <input type="text" name="home_facts[facts_button_title]" id="facts_button_title"
                           class="form-control" placeholder="Nút liên hệ..."
                           value="<?php echo !empty($arrFactsContent['facts_button_title']) ? $arrFactsContent['facts_button_title'] : false ?>">
                        <?php echo !empty('facts_button_title') ? form_error('facts_button_title', $errors, '<span class="error">', '</span>') : false?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="facts_button_link">Link nút</label>
                        <input type="text" name="home_facts[facts_button_link]" id="facts_button_link"
                           class="form-control" placeholder="Link nút..."
                           value="<?php echo !empty($arrFactsContent['facts_button_link']) ? $arrFactsContent['facts_button_link'] : false ?>">
                        <?php echo !empty('facts_button_link') ? form_error('facts_button_link', $errors, '<span class="error">', '</span>') : false?>
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
                           <div class="facts_item">
                              <div class="row">
                                 <div class="col-lg-4 col-md-4 col-6">
                                    <div class="form-group">
                                       <label for="facts_item_desc">Thành tựu</label>
                                       <input type="text" name="home_facts[facts_item_desc][]" id="facts_item_desc"
                                          class="form-control" placeholder="Thành tựu..."
                                          value="<?php echo !empty($value['facts_item_desc']) ? $value['facts_item_desc'] : false ?>">
                                       <?php echo !empty($errors['facts_item_desc']) ? form_error($key, $errors['facts_item_desc'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-6">
                                    <div class="form-group">
                                       <label for="facts_item_icon">Icon</label>
                                       <input type="text" name="home_facts[facts_item_icon][]" id="facts_item_icon"
                                          class="form-control" placeholder="Icon..."
                                          value="<?php echo !empty($value['facts_item_icon']) ? $value['facts_item_icon'] : false ?>">
                                       <?php echo !empty($errors['facts_item_icon']) ? form_error($key, $errors['facts_item_icon'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-5">
                                    <div class="form-group">
                                       <label for="facts_item_number">Số lượng</label>
                                       <input type="number" name="home_facts[facts_item_number][]"
                                          id="facts_item_number" class="form-control" placeholder="Số lượng..."
                                          value="<?php echo !empty($value['facts_item_number']) ? $value['facts_item_number'] : false ?>">
                                       <?php echo !empty($errors['facts_item_number']) ? form_error($key, $errors['facts_item_number'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-5">
                                    <div class="form-group">
                                       <label for="facts_item_unit">Đơn vị tính</label>
                                       <input type="text" name="home_facts[facts_item_unit][]" id="facts_item_unit"
                                          class="form-control" placeholder="Đơn vị tính..."
                                          value="<?php echo !empty($value['facts_item_unit']) ? $value['facts_item_unit'] : false ?>">
                                       <?php echo !empty($errors['facts_item_unit']) ? form_error($key, $errors['facts_item_unit'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-2 md-2">
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