<div class="slider px-1">
   <h3 class="text-center"><?php echo getOption('home_slide', 'label') ?></h3>
   <?php
      if(!empty($arrSlider)):
         foreach($arrSlider as $key => $value):
   ?>
   <div class="card border shadow-none mb-2 slider-item">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_title">Tiêu đề (để trong thẻ &lt;span&gt;&lt;/span&gt; để làm nổi
                           bậc)</label>
                        <input type="text" name="home_slide[slider_title][]" id="slider_title" class="form-control"
                           placeholder="Tiêu đề..." value="<?php echo $value['slider_title'] ?>">
                        <?php echo !empty($errors['slider_title']) ? form_error($key, $errors['slider_title'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_btn">Nút xem thêm</label>
                        <input type="text" name="home_slide[slider_btn][]" id="slider_btn" class="form-control"
                           placeholder="Nút xem thêm..." value="<?php echo $value['slider_btn'] ?>">
                        <?php echo !empty($errors['slider_btn']) ? form_error($key, $errors['slider_btn'], '<span class="error">', '</span>') : false?>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_btn_link">Link nút xem thêm</label>
                        <input type="text" name="home_slide[slider_btn_link][]" id="slider_btn_link"
                           class="form-control" placeholder="Link nút xem thêm..."
                           value="<?php echo $value['slider_btn_link'] ?>">
                        <?php echo !empty($errors['slider_btn_link']) ? form_error($key, $errors['slider_btn_link'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_youtube_link">Link Youtube</label>
                        <input type="text" name="home_slide[slider_youtube_link][]" id="slider_youtube_link"
                           class="form-control" placeholder="Link Youtube..."
                           value="<?php echo $value['slider_youtube_link'] ?>">
                        <?php echo !empty($errors['slider_youtube_link']) ? form_error($key, $errors['slider_youtube_link'], '<span class="error">', '</span>') : false?>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_image_1">Ảnh 1</label>
                        <div class="row ckfinder-group">
                           <div class="col-9">
                              <input type="text" name="home_slide[slider_image_1][]" id="slider_image_1"
                                 class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                 value="<?php echo $value['slider_image_1'] ?>">
                              <?php echo !empty($errors['slider_image_1']) ? form_error($key, $errors['slider_image_1'], '<span class="error">', '</span>') : false ?>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                                 <i class="fa fa-upload" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_image_2">Ảnh 2</label>
                        <div class="row ckfinder-group">
                           <div class="col-9">
                              <input type="text" name="home_slide[slider_image_2][]" id="slider_image_2"
                                 class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                 value="<?php echo $value['slider_image_2'] ?>">
                              <?php echo !empty($errors['slider_image_2']) ? form_error($key, $errors['slider_image_2'], '<span class="error">', '</span>') : false?>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                                 <i class="fa fa-upload" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_bg">Ảnh nền</label>
                        <div class="row ckfinder-group">
                           <div class="col-9">
                              <input type="text" name="home_slide[slider_bg][]" id="slider_bg"
                                 class="form-control image-link" placeholder="Đường dẫn ảnh..."
                                 value="<?php echo $value['slider_bg'] ?>">
                              <?php echo !empty($errors['slider_bg']) ? form_error($key, $errors['slider_bg'], '<span class="error">', '</span>') : false?>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                                 <i class="fa fa-upload" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_desc">Mô tả</label>
                        <textarea type="text" name="home_slide[slider_desc][]" id="slider_desc" class="form-control"
                           placeholder="Mô tả..."><?php echo $value['slider_desc'] ?></textarea>
                        <?php echo !empty($errors['slider_desc']) ? form_error($key, $errors['slider_desc'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="slider_position">Vị trí</label>
                        <select name="home_slide[slider_position][]" id="slider_position" class="form-control">
                           <option value="0">Chọn vị trí</option>
                           <option value="left"
                              <?php echo !empty($value['slider_position']) && $value['slider_position'] == "left" ? "selected" : false ?>>
                              Left
                           </option>
                           <option value="right"
                              <?php echo !empty($value['slider_position']) && $value['slider_position'] == "right" ? "selected" : false ?>>
                              Right
                           </option>
                           <option value="center"
                              <?php echo !empty($value['slider_position']) && $value['slider_position'] == "center" ? "selected" : false ?>>
                              Center
                           </option>
                        </select>
                        <?php echo !empty($errors['slider_position']) ? form_error($key, $errors['slider_position'], '<span class="error">', '</span>') : false ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="flex-shrink-0 ms-2">
               <ul class="list-inline mb-0">
                  <li class="list-inline-item">
                     <button type="button" class="text-muted px-1 btn remove">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                     </button>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <?php 
      endforeach;
   endif;
   ?>
</div>
<div class="px-1">
   <button type="button" class="btn btn-warning btn-small" id="addSlide">Thêm slide</button>
</div>
<hr>