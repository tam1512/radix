<?php 
   $jsonPartners = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_partners'")['opt_value'];
   $homePartners = json_decode($jsonPartners, true);

   if(!empty($homePartners)) {
      foreach($homePartners as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrPartners[$k][$key] =$v ;
            }
         } else {
            $arrPartnersContent[$key] = $value;
         }
      }
   }

?>
<!-- Partners -->
<section id="partners" class="partners section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span
                  class="title-bg"><?php echo !empty($arrPartnersContent['partners_title_bg']) ? $arrPartnersContent['partners_title_bg'] : false ?></span>
               <h1>
                  <?php echo !empty($arrPartnersContent['partners_title']) ? $arrPartnersContent['partners_title'] : false ?>
               </h1>
               <?php echo !empty($arrPartnersContent['partners_desc']) ? html_entity_decode($arrPartnersContent['partners_desc']) : false ?>
               <p></p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="partners-inner">
               <div class="row no-gutters">
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-1.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-2.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-3.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-4.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-5.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-6.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-7.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-8.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-5.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-6.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-7.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
                  <!-- Single Partner -->
                  <div class="col-lg-2 col-md-3 col-12">
                     <div class="single-partner">
                        <a href="#" target="_blank"><img
                              src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>partner-3.png" alt="#" /></a>
                     </div>
                  </div>
                  <!--/ End Single Partner -->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Partners -->