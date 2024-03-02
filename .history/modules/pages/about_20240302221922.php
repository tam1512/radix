<?php 
   $jsonAbout = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'page_about'")['opt_value'];
   $pageAbout = json_decode($jsonAbout, true);

   if(!empty($pageAbout)) {
      foreach($pageAbout as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrAboutProgress[$k][$key] =$v ;
            }
         } else {
            $arrAbout[$key] = $value;
         }
      }
   }

   
   $isPage = false;
   if(empty($data)) {
      $data = [
         'title' => $pageAbout['about_title_page'],
         'name' => 'About'
      ];
      $isPage = true;

      layout('header', 'client', $data);
      layout('breadcrumb', 'client', $data);
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
                  <?php echo (!empty($arrAbout['about_desc']) ? html_entity_decode($arrAbout['about_desc']) : false) ?>
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
               <?php echo (!empty($arrAbout['about_content']) ? html_entity_decode($arrAbout['about_content']) : false) ?>
            </div>
            <!--/ End About Content -->
         </div>
      </div>
      <?php endif; ?>
      <?php if(!empty($arrAboutProgress)): ?>
      <div class="row">
         <div class="col-12">
            <div class="progress-main">
               <div class="row">
                  <?php foreach($arrAboutProgress as $key => $value): ?>
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.4s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>
                           <?php echo (!empty($value['about_progress_name']) ? $value['about_progress_name'] : false) ?>
                        </h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar"
                              style="width: <?php echo (!empty($value['progress-range']) ? $value['progress-range'] : false) ?>%"
                              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                              <span
                                 class="percent"><?php echo (!empty($value['progress-range']) ? $value['progress-range'] : false) ?>%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
                  <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<!--/ End About Us -->

<?php 
   if($isPage) {
      require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
      layout('footer', 'client', $data);
   }
?>