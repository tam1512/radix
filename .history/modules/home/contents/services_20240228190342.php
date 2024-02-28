<?php 
   $arrServices = getRaw('SELECT * FROM services');
   $titleBg = getOption('home_services_title-bg', 'value');
   $title = getOption('home_services_title', 'value');
   $content = getOption('home_services_content', 'value');
?>
<!-- Services -->
<section id="services" class="services section">
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
         <div class="col-12">
            <div class="service-slider">
               <?php 
                  if(!empty($arrServices)):
                     foreach($arrServices as $service):
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
               <?php endforeach; endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Services -->