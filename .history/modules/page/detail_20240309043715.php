<?php 
   //Sử dụng gravatar để lấy ảnh trung gian

   $pageDefault = [];
   var_dump(getBody('get')['id']);
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $pageDefault = firstRaw("SELECT * FROM pages WHERE id = $id");
      if(empty($pageDefault)) {
         redirect("modules/errors/404.php");
      }

      $data = [
         'title' => $pageDefault['title'],
         'name' => $pageDefault['title'],
      ];

   } else {
      redirect("modules/errors/404.php");
   }
   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);
?>
<!-- Blogs Area -->
<section class="blogs-main archives single section">
   <div class="container">
      <div class="row">
         <div class="col-lg-10 offset-lg-1 col-12">
            <?php if(!empty($pageDefault)): ?>
            <div class="row">
               <div class="col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-inner">
                        <div class="blog-top">
                           <div class="meta">
                              <span>
                                 <i class="fa fa-calendar"></i>
                                 <?php echo !empty($pageDefault['create_at']) ? getDateFormat($pageDefault['create_at'], 'd-m-Y') : false  ?>
                              </span>
                           </div>
                        </div>
                        <h2><a href="#"><?php echo !empty($pageDefault['title']) ? $pageDefault['title'] : false  ?></a>
                        </h2>
                        <?php echo !empty($pageDefault['content']) ? html_entity_decode($pageDefault['content']) : false  ?>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
            </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>
<!--/ End Blogs Area -->
<?php 
   layout('footer', 'client', $data);
?>