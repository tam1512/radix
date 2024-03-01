<div class="copyright px-1">
   <h3 class="text-center">Thiết lập copyright</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="copyright_content"><?php echo getOption('copyright_content', 'label') ?></label>
                        <textarea type="text" name="copyright_content" id="copyright_content"
                           class="form-control editor"
                           placeholder="<?php echo getOption('copyright_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['copyright_content'] : getOption('copyright_content') ?></textarea>
                        <?php echo !empty($errors['copyright_content']) ? form_error('copyright_content', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>