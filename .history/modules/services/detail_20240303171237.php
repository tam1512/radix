<?php 
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $serviceDetail = firstRaw('SELECT * FROM services WHERE id = '.$id);
   } else {
      redirect("modules/errors/404.php");
   }

   $titlePage = $serviceDetail['name'];
   $data = [
      'title' => $titlePage,
      'name' => $titlePage,
      'parent' => 'Services'
   ];

   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);
?>
<!-- Services -->
<section id="services" class="services archives section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg"><?php echo !empty($data['parent']) ? $data['parent'] : false ?></span>
               <h1><?php echo !empty($serviceDetail['description']) ? $serviceDetail['description'] : false ?></h1>
               <p>
                  <?php echo !empty($serviceDetail['content']) ? html_entity_decode($serviceDetail['content']) : false ?>
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
                        href="<?php echo getLinkClient('services', 'detail', ['id' => $service['id']]) ?>"><?php echo !empty($service['name']) ? $service['name'] : false ?></a>
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
   layout('footer', 'client', $data);
?>