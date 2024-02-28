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
                        <label for="home_services_title-bg">Tiêu đề nền</label>
                        <input type="text" name="home_services_title-bg" id="home_services_title-bg"
                           class="form-control" placeholder="Tiêu đề nền..."
                           value="<?php echo $oldServices['home_services_title-bg'] ?>">
                        <?php echo !empty($errors['home_services_title-bg']) ? form_error($key, $errors['home_services_title-bg'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_services_title">Tiêu đề</label>
                        <input type="text" name="home_services_title" id="home_services_title" class="form-control"
                           placeholder="Tiêu đề..." value="<?php echo $oldServices['home_services_title'] ?>">
                        <?php echo !empty($errors['home_services_title']) ? form_error($key, $errors['home_services_title'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="home_services_content">Nội dung</label>
                        <textarea type="text" name="home_services_content" id="home_services_content"
                           class="form-control"
                           placeholder="Nội dung..."><?php echo $oldServices['home_services_content'] ?></textarea>
                        <?php echo !empty($errors['home_services_content']) ? form_error($key, $errors['home_services_content'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>