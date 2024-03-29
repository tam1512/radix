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
      'parent' => 'Services',
      'parentVN' => 'Dịch vụ',
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
               <h1><?php echo !empty($serviceDetail['name']) ? $serviceDetail['name'] : false ?></h1>
               <p>
                  <?php echo !empty($serviceDetail['description']) ? html_entity_decode($serviceDetail['description']) : false ?>
               </p>
               <p></p>
            </div>
         </div>
         <div class="col-12">
            <!-- Single Blog -->
            <div class="single-blog bg-white p-5">
               <div class="blog-inner">
                  <?php echo !empty($serviceDetail['content']) ? html_entity_decode($serviceDetail['content']) : false  ?>
               </div>
            </div>
            <!-- End Single Blog -->
         </div>
      </div>
   </div>
</section>
<!--/ End Services -->
<?php 
   layout('footer', 'client', $data);
?>