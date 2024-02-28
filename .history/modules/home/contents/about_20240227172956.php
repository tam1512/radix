<?php 
   $jsonAbout = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_about'")['opt_value'];
   $homeAbout = json_decode($jsonAbout, true);

   if(!empty($homeAbout)) {
      foreach($homeAbout as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrAboutProgress[$k][$key] =$v ;
            }
         } else {
            $arrAbout[$key] = $value;
         }
      }
   }

?>

<!-- About Us -->
<section class="about-us section">
   <div class="container">
      <?php if(!empty($arrAbout)): ?>
      <div class="row">
         <div class="col-12">
            <div class="section-title wow fadeInUp">
               <span
                  class="title-bg"><?php echo (!empty($arrAbout['about_title_bg']) ? $arrAbout['about_title_bg'] : false) ?></span>
               <h1><?php echo (!empty($arrAbout['about_title']) ? $arrAbout['about_title'] : false) ?></h1>
               <p>
                  <?php echo (!empty($arrAbout['about_desc']) ? $arrAbout['about_desc'] : false) ?>
               </p>
               <p></p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-6 col-12 wow fadeInLeft" data-wow-delay="0.6s">
            <!-- Video -->
            <div class="about-video">
               <div class="single-video overlay">
                  <a href="<?php echo (!empty($arrAbout['about_youtube_link']) ? $arrAbout['about_youtube_link'] : false) ?>"
                     class="video-popup mfp-fade"><i class="fa fa-play"></i></a>
                  <img src="<?php echo (!empty($arrAbout['about_image']) ? $arrAbout['about_image'] : false) ?>"
                     alt="#" />
               </div>
            </div>
            <!--/ End Video -->
         </div>
         <div class="col-lg-6 col-12 wow fadeInRight" data-wow-delay="0.8s">
            <!-- About Content -->
            <div class="about-content">
               <?php echo (!empty($arrAbout['about_content']) ? $arrAbout['about_content'] : false) ?>
            </div>
            <!--/ End About Content -->
         </div>
      </div>
      <?php endif; ?>
      <div class="row">
         <div class="col-12">
            <div class="progress-main">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.4s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>Communication</h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 78%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                              <span class="percent">78%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.6s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>Business Develop</h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                              <span class="percent">80%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.8s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>Creative Work</h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                              <span class="percent">90%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="1s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>Bootstrap 4</h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="25"
                              aria-valuemin="0" aria-valuemax="100">
                              <span class="percent">95%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End About Us -->