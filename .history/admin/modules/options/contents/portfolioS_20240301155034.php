<div class="portfolios px-1">
   <h3 class="text-center">Thiết lập dự án</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_portfolios_title-bg"><?php echo getOption('home_portfolios_title-bg', 'label') ?></label>
                        <input type="text" name="home_portfolios_title-bg" id="home_portfolios_title-bg"
                           class="form-control"
                           placeholder="<?php echo getOption('home_portfolios_title-bg', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_portfolios_title-bg'] : getOption('home_portfolios_title-bg') ?>">
                        <?php echo !empty($errors['home_portfolios_title-bg']) ? form_error('home_portfolios_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_portfolios_title"><?php echo getOption('home_portfolios_title', 'label') ?></label>
                        <input type="text" name="home_portfolios_title" id="home_portfolios_title" class="form-control"
                           placeholder="<?php echo getOption('home_portfolios_title', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_portfolios_title'] : getOption('home_portfolios_title') ?>">
                        <?php echo !empty($errors['home_portfolios_title']) ? form_error('home_portfolios_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_portfolios_content"><?php echo getOption('home_portfolios_content', 'label') ?></label>
                        <textarea type="text" name="home_portfolios_content" id="home_portfolios_content"
                           class="form-control editor"
                           placeholder="<?php echo getOption('home_portfolios_content', 'label') ?>..."><?php echo !empty($oldService) ? $oldService['home_portfolios_content'] : getOption('home_portfolios_content') ?></textarea>
                        <?php echo !empty($errors['home_portfolios_content']) ? form_error('home_portfolios_content', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_portfolios_btn"><?php echo getOption('home_portfolios_btn', 'label') ?></label>
                        <input type="text" name="home_portfolios_btn" id="home_portfolios_btn" class="form-control"
                           placeholder="<?php echo getOption('home_portfolios_btn', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_portfolios_btn'] : getOption('home_portfolios_btn') ?>">
                        <?php echo !empty($errors['home_portfolios_btn']) ? form_error('home_portfolios_btn', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_portfolios_btn_link"><?php echo getOption('home_portfolios_btn_link', 'label') ?></label>
                        <input type="text" name="home_portfolios_btn_link" id="home_portfolios_btn_link"
                           class="form-control"
                           placeholder="<?php echo getOption('home_portfolios_btn_link', 'label') ?>..."
                           value="<?php echo !empty($oldService) ? $oldService['home_portfolios_btn_link'] : getOption('home_portfolios_btn_link') ?>">
                        <?php echo !empty($errors['home_portfolios_btn_link']) ? form_error('home_portfolios_btn_link', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>