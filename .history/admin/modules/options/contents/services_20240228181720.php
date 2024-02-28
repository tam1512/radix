<div class="services px-1">
   <h3 class="text-center">Thiết lập dịch vụ</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_services_title-bg"><?php echo getOption('home_services_title-bg', 'label') ?></label>
                        <input type="text" name="home_services_title-bg" id="home_services_title-bg"
                           class="form-control"
                           placeholder="<?php echo getOption('home_services_title-bg', 'label') ?>..."
                           value="<?php echo $oldServices['home_services_title-bg'] ?>">
                        <?php echo !empty($errors['home_services_title-bg']) ? form_error('home_services_title-bg', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_services_title"><?php echo getOption('home_services_title', 'label') ?></label>
                        <input type="text" name="home_services_title" id="home_services_title" class="form-control"
                           placeholder="<?php echo getOption('home_services_title', 'label') ?>..."
                           value="<?php echo $oldServices['home_services_title'] ?>">
                        <?php echo !empty($errors['home_services_title']) ? form_error('home_services_title', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label
                           for="home_services_content"><?php echo getOption('home_services_content', 'label') ?></label>
                        <textarea type="text" name="home_services_content" id="home_services_content"
                           class="form-control"
                           placeholder="<?php echo getOption('home_services_content', 'label') ?>..."><?php echo $oldServices['home_services_content'] ?></textarea>
                        <?php echo !empty($errors['home_services_content']) ? form_error('home_services_content', $errors, '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>