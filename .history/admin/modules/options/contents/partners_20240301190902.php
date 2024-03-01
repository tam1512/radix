<div class="blogs px-1">
   <h3 class="text-center">Thiết lập Blogs</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_blogs_title-bg"><?php echo getOption('home_blogs_title-bg', 'label') ?></label>
                        <input type="text" name="home_blogs_title-bg" id="home_blogs_title-bg" class="form-control"
                           placeholder="<?php echo getOption('home_blogs_title-bg', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_blogs_title-bg'] : getOption('home_blogs_title-bg') ?>">
                        <?php echo !empty($errors['home_blogs_title-bg']) ? form_error('home_blogs_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_blogs_title"><?php echo getOption('home_blogs_title', 'label') ?></label>
                        <input type="text" name="home_blogs_title" id="home_blogs_title" class="form-control"
                           placeholder="<?php echo getOption('home_blogs_title', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_blogs_title'] : getOption('home_blogs_title') ?>">
                        <?php echo !empty($errors['home_blogs_title']) ? form_error('home_blogs_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_blogs_content"><?php echo getOption('home_blogs_content', 'label') ?></label>
                        <textarea type="text" name="home_blogs_content" id="home_blogs_content"
                           class="form-control editor"
                           placeholder="<?php echo getOption('home_blogs_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['home_blogs_content'] : getOption('home_blogs_content') ?></textarea>
                        <?php echo !empty($errors['home_blogs_content']) ? form_error('home_blogs_content', $errors, '<span class="error">', '</span>') : false ?>
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
                                 <div class="col-4">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[facts_item_desc][]" id="facts_item_desc"
                                          class="form-control" placeholder="Thành tựu..."
                                          value="<?php echo !empty($value['facts_item_desc']) ? $value['facts_item_desc'] : false ?>">
                                       <?php echo !empty($errors['facts_item_desc']) ? form_error($key, $errors['facts_item_desc'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-3">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[facts_item_icon][]" id="facts_item_icon"
                                          class="form-control" placeholder="Icon..."
                                          value="<?php echo !empty($value['facts_item_icon']) ? $value['facts_item_icon'] : false ?>">
                                       <?php echo !empty($errors['facts_item_icon']) ? form_error($key, $errors['facts_item_icon'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-2">
                                    <div class="form-group">
                                       <input type="number" name="home_facts[facts_item_number][]"
                                          id="facts_item_number" class="form-control" placeholder="Số lượng..."
                                          value="<?php echo !empty($value['facts_item_number']) ? $value['facts_item_number'] : false ?>">
                                       <?php echo !empty($errors['facts_item_number']) ? form_error($key, $errors['facts_item_number'], '<span class="error">', '</span>') : false?>
                                    </div>
                                 </div>
                                 <div class="col-2">
                                    <div class="form-group">
                                       <input type="text" name="home_facts[facts_item_unit][]" id="facts_item_unit"
                                          class="form-control" placeholder="Đơn vị tính..."
                                          value="<?php echo !empty($value['facts_item_unit']) ? $value['facts_item_unit'] : false ?>">
                                       <?php echo !empty($errors['facts_item_unit']) ? form_error($key, $errors['facts_item_unit'], '<span class="error">', '</span>') : false?>
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