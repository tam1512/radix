<div class="footer_3 px-1">
   <h3 class="text-center">Thiết lập cột 1</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="footer_3_title"><?php echo getOption('footer_3_title', 'label') ?></label>
                        <input type="text" name="footer_3_title" id="footer_3_title" class="form-control"
                           placeholder="<?php echo getOption('footer_3_title', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['footer_3_title'] : getOption('footer_3_title') ?>">
                        <?php echo !empty($errors['footer_3_title']) ? form_error('footer_3_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>