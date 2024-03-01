<?php 
   $content = getOption('home_cta_content');
   $btn = getOption('home_cta_btn');
   $btnLink = getOption('home_cta_btn_link');
?>

<!-- Call To Action -->
<section class="call-to-action section" data-stellar-background-ratio="0.5">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 col-12 wow fadeInUp">
            <div class="call-to-main">
               <?php echo !empty($content) ? html_entity_decode($content) : false ?>
               <a href="<?php echo !empty($btnLink) ? $btnLink : false ?>"
                  class="btn"><?php echo !empty($btn) ? $btn : false ?></a>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Call To Action -->