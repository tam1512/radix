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
               </div>
            </div>
         </div>
      </div>
   </div>
</div>