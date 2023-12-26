<!-- Hero Area -->

<section id="hero-area" class="hero-area">
   <?php 
      $jsonSlider = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_slide'")['opt_value'];
      $arrSlider = json_decode($jsonSlider, true);
   ?>
   <!-- Slider -->
   <div class="slider-area">
      <?php 
         if(!empty($arrSlider)):
            foreach($arrSlider as $slide):
               if($slide['slider_position'] == 'left'):
      ?>
      <!-- Single Slider -->
      <div class="single-slider" style="background-image: url('<?php echo $slide['slider_bg'] ?>')">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 col-md-6 col-12">
                  <!-- Slider Text -->
                  <div class="slider-text">
                     <h1>
                        <?php echo html_entity_decode($slide['slider_title']) ?>
                     </h1>
                     <p>
                        <?php echo $slide['slider_desc'] ?>
                     </p>
                     <div class="button">
                        <a href="<?php echo $slide['slider_btn_link'] ?>"
                           class="btn"><?php echo $slide['slider_btn'] ?></a>
                        <a href="<?php echo $slide['slider_youtube_link'] ?>" class="btn video video-popup mfp-fade"><i
                              class="fa fa-play"></i>Play Now</a>
                     </div>
                  </div>
                  <!--/ End Slider Text -->
               </div>
               <div class="col-lg-5 col-md-6 col-12">
                  <!-- Image Gallery -->
                  <div class="image-gallery">
                     <div class="single-image">
                        <img src="<?php echo $slide['slider_image_1'] ?>" alt="#" />
                     </div>
                     <div class="single-image two">
                        <img src="<?php echo $slide['slider_image_2'] ?>" alt="#" />
                     </div>
                  </div>
                  <!--/ End Image Gallery -->
               </div>
            </div>
         </div>
      </div>
      <!--/ End Single Slider -->
      <?php 
         elseif($slide['slider_position'] == 'right'):
      ?>
      <!-- Single Slider -->
      <div class="single-slider slider-right" style="background-image: url('<?php echo $slide['slider_bg'] ?>')">
         <div class="container">
            <div class="row">
               <div class="col-lg-5 col-md-6 col-12">
                  <!-- Image Gallery -->
                  <div class="image-gallery">
                     <div class="single-image">
                        <img src="<?php echo $slide['slider_image_1'] ?>" alt="#" />
                     </div>
                     <div class="single-image two">
                        <img src="<?php echo $slide['slider_image_2'] ?>" alt="#" />
                     </div>
                  </div>
                  <!--/ End Image Gallery -->
               </div>
               <div class="col-lg-7 col-md-6 col-12">
                  <!-- Slider Text -->
                  <div class="slider-text text-right">
                     <h1>
                        <?php echo html_entity_decode($slide['slider_title']) ?>
                     </h1>
                     <p>
                        <?php echo $slide['slider_desc'] ?>
                     </p>
                     <div class="button">
                        <a href="<?php echo $slide['slider_btn_link'] ?>"
                           class="btn"><?php echo $slide['slider_btn'] ?></a>
                        <a href="<?php echo $slide['slider_youtube_link'] ?>" class="btn video video-popup mfp-fade"><i
                              class="fa fa-play"></i>Play Now</a>
                     </div>
                  </div>
                  <!--/ End Slider Text -->
               </div>
            </div>
         </div>
      </div>
      <!--/ End Single Slider -->
      <?php 
         elseif($slide['slider_position'] == 'center'):
      ?>
      <!-- Single Slider -->
      <div class="single-slider slider-center" style="background-image: url('<?php echo $slide['slider_bg'] ?>')">
         <div class="container">
            <div class="row">
               <div class="col-lg-10 offset-lg-1 col-12">
                  <!-- Slider Text -->
                  <div class="slider-text text-center">
                     <h1>
                        <?php echo html_entity_decode($slide['slider_title']) ?>
                     </h1>
                     <p>
                        <?php echo $slide['slider_desc'] ?>
                     </p>
                     <div class="button">
                        <a href="<?php echo $slide['slider_btn_link'] ?>"
                           class="btn"><?php echo $slide['slider_btn'] ?></a>
                        <a href="<?php echo $slide['slider_youtube_link'] ?>" class="btn video video-popup mfp-fade"><i
                              class="fa fa-play"></i>Play Now</a>
                     </div>
                  </div>
                  <!--/ End Slider Text -->
               </div>
            </div>
         </div>
      </div>
      <!--/ End Single Slider -->
      <?php 
               endif;
            endforeach;
         endif;
      ?>
   </div>
   <!--/ End Slider -->
</section>
<!--/ End Hero Area -->