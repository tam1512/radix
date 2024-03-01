<div class="services px-1">
   <h3 class="text-center">Thiết lập hành động</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_cta_content"><?php echo getOption('home_cta_content', 'label') ?></label>
                        <textarea type="text" name="home_cta_content" id="home_cta_content" class="form-control editor"
                           placeholder="<?php echo getOption('home_cta_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['home_cta_content'] : getOption('home_cta_content') ?></textarea>
                        <?php echo !empty($errors['home_cta_content']) ? form_error('home_cta_content', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>