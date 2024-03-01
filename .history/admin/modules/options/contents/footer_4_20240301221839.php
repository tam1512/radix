<div class="footer_4 px-1">
   <h3 class="text-center">Thiết lập cột 4</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_4_title"><?php echo getOption('footer_4_title', 'label') ?></label>
                        <input type="text" name="footer_4_title" id="footer_4_title" class="form-control"
                           placeholder="<?php echo getOption('footer_4_title', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['footer_4_title'] : getOption('footer_4_title') ?>">
                        <?php echo !empty($errors['footer_4_title']) ? form_error('footer_4_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_4_content"><?php echo getOption('footer_4_content', 'label') ?></label>
                        <input type="text" name="footer_4_content" id="footer_4_content" class="form-control"
                           placeholder="<?php echo getOption('footer_4_content', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['footer_4_content'] : getOption('footer_4_content') ?>">
                        <?php echo !empty($errors['footer_4_content']) ? form_error('footer_4_content', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>