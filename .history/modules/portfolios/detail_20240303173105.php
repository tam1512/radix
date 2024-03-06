<?php 
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $portfolioDetail = firstRaw('SELECT * FROM portfolios WHERE id = '.$id);
   } else {
      redirect("modules/errors/404.php");
   }

   $titlePage = $portfolioDetail['name'];
   $data = [
      'title' => $titlePage,
      'name' => $titlePage,
      'parent' => 'Portfolios'
   ];

   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);
?>
<!-- portfolios -->
<section id="portfolios" class="services archives section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg"><?php echo !empty($data['parent']) ? $data['parent'] : false ?></span>
               <h1><?php echo !empty($portfolioDetail['name']) ? $portfolioDetail['name'] : false ?></h1>
               <p>
                  <?php echo !empty($portfolioDetail['description']) ? html_entity_decode($portfolioDetail['description']) : false ?>
               </p>
               <p></p>
            </div>
         </div>
         <div class="col-12">
            <!-- Single Blog -->
            <div class="single-blog bg-white p-5">
               <div class="blog-inner">
                  <?php echo !empty($portfolioDetail['content']) ? html_entity_decode($portfolioDetail['content']) : false  ?>
               </div>
            </div>
            <!-- End Single Blog -->
         </div>
      </div>
   </div>
</section>
<!--/ End portfolios -->
<?php 
   layout('footer', 'client', $data);
?>