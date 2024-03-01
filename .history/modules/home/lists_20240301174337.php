<?php
   $data = [
      'title' => 'Radix &#8739; Creative Business & Consulting HTML5 Template'
   ];

   layout('header', 'client', $data);
   
   require_once('contents/slider.php');
   require_once('contents/about.php');
   require_once('contents/services.php');
   require_once('contents/facts.php');
   require_once('contents/portfolios.php');
   require_once('contents/callToAction.php');
   require_once('contents/blogs.php');
?>
<!-- Partners -->
<section id="partners" class="partners section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg">Clients</span>
               <h1>Our Partners</h1>
               <p>
                  Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor.
                  Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus
                  magna, a vehicula turpis Proin
               </p>
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

<?php 
layout('footer', 'client', $data);
?>