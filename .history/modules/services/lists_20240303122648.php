<?php 
   $arrServices = getRaw('SELECT * FROM services');
   $titlePage = getOption('page_services_title_page');
   $titleBg = getOption('page_services_title-bg');
   $title = getOption('page_services_title');
   $content = getOption('page_services_content');

   $isPage = false;
   if(empty($data)) {
      $data = [
         'title' => $titlePage,
         'name' => 'Service'
      ];
      $isPage = true;

      layout('header', 'client', $data);
      layout('breadcrumb', 'client', $data);
   }
?>
<!-- Services -->
<section id="services" class="services <?php echo $isPage ? 'archives' : false ?> section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg"><?php echo !empty($titleBg) ? $titleBg : false ?></span>
               <h1><?php echo !empty($title) ? $title : false ?></h1>
               <p>
                  <?php echo !empty($content) ? html_entity_decode($content) : false ?>
               </p>
               <p></p>
            </div>
         </div>
      </div>
      <div class="row">
         <?php if(!$isPage): ?>
         <div class="col-12">
            <div class="service-slider">
               <?php 
               endif;
                  if(!empty($arrServices)):
                     foreach($arrServices as $service):
                        if($isPage) {
                           echo '<div class="col-lg-4 col-md-6 col-12">';
                        }
               ?>
               <!-- Single Service -->
               <div class="single-service">
                  <?php echo !empty($service['icon']) ? html_entity_decode($service['icon']) : false ?>
                  <!-- service-single.html -->
                  <h2><a
                        href="<?php echo !empty($service['slug']) ? $service['slug'] : false ?>"><?php echo !empty($service['name']) ? $service['name'] : false ?></a>
                  </h2>
                  <p>
                     <?php echo !empty($service['description']) ? $service['description'] : false ?>
                  </p>
               </div>
               <!-- End Single Service -->
               <?php 
                        if($isPage) {
                           echo '</div>';
                        }
                     endforeach; 
                  endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Services -->
<?php 
   if($isPage) {
      require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
      layout('footer', 'client', $data);
   }
?>