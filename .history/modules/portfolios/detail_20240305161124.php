<?php 
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $portfolioDetail = firstRaw('SELECT * FROM portfolios WHERE id = '.$id);
      $listCateId = getRaw("SELECT category_id FROM portfolio_category_mapping WHERE portfolio_id = $id");
      $listCategories = getRaw("SELECT id, name FROM portfolio_categories");
      $listImages = getRaw("SELECT image FROM portfolio_images WHERE portfolio_id = $id");

      $isHaveImages = false;
      if(!empty($listImages)) {
         $isHaveImages = true;
      }


      $facebook = getOption('general_facebook');
      $twitter = getOption('general_twitter');
      $linkedin = getOption('general_linkedin');
      $behance = getOption('general_behance');

      $cateStr = '';

      foreach($listCateId as $key=>$value) {
         foreach($listCategories as $item) {
            if($value['category_id'] == $item['id']) {
               $listCateId[$key] =[
                  'id' => $item['id'],
                  'name' => $item['name'] 
               ];
               break;
            }
         }
      }

      if(!empty($listCateId)) {
         foreach($listCateId as $item) {
            $cateStr .= '<a
            href="#">'.$item['name'].'</a>, ';
         }
         $cateStr = rtrim($cateStr,' ,');
      }


   } else {
      redirect("modules/errors/404.php");
   }

   $titlePage = $portfolioDetail['name'];
   $data = [
      'title' => $titlePage,
      'name' => $titlePage,
      'parent' => 'Portfolios',
      'parentVN' => 'Dự án'
   ];

   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);
?>
<!-- portfolios -->
<section id="portfolios" class="blogs-main archives single section">
   <div class="container">
      <div class="row">
         <div class="col-12 col-lg-10 offset-lg-1  ">
            <div class="single-blog">
               <div class="blog-head">
                  <img
                     src="<?php echo !empty($portfolioDetail['thumbnail']) ? $portfolioDetail['thumbnail'] : false  ?>"
                     alt="#">
               </div>
               <div class="blog-inner">
                  <div class="blog-top">
                     <div class="meta">
                        <span>
                           <i class="fa fa-bolt"></i>
                           <?php echo $cateStr ?>
                        </span>
                        <span>
                           <i class="fa fa-calendar"></i>
                           <?php echo !empty($portfolioDetail['create_at']) ? getDateFormat($portfolioDetail['create_at'], 'd-m-Y') : false  ?>
                        </span>
                     </div>
                     <ul class="social-share">
                        <li>
                           <a href="<?php echo !empty($facebook) ? $facebook : false  ?>">
                              <i class="fa fa-facebook"></i>
                           </a>
                        </li>
                        <li>
                           <a href="<?php echo !empty($twitter) ? $twitter : false  ?>">
                              <i class="fa fa-twitter"></i>
                           </a>
                        </li>
                        <li>
                           <a href="<?php echo !empty($linkedin) ? $linkedin : false  ?>">
                              <i class="fa fa-linkedin"></i>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <i class="fa fa-pinterest"></i>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <i class="fa fa-google-plus"></i>
                           </a>
                        </li>
                     </ul>
                  </div>
                  <h2>
                     <a href="#">
                        <?php echo !empty($portfolioDetail['name']) ? $portfolioDetail['name'] : false  ?>
                     </a>
                  </h2>
                  <?php echo !empty($portfolioDetail['content']) ? html_entity_decode($portfolioDetail['content']) : false  ?>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <?php 
            $isHaveVideo = false;
            if(!empty($portfolioDetail['video'])):
               $isHaveVideo = true;
          ?>
         <div class="<?php echo $isHaveImages ? 'col-lg-6': 'col-lg-12' ?> col-12 mt-5">
            <h3>Video</h3>
            <hr>
            <iframe width="100%" height="315"
               src="https://www.youtube.com/embed/<?php echo getKeyYoutube($portfolioDetail['video']) ?>"
               title="YouTube video player" frameborder="0"
               allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
               allowfullscreen></iframe>
         </div>
         <?php endif; ?>
         <?php if($isHaveImages): ?>
         <div class="<?php echo $isHaveVideo ? 'col-lg-6' : 'col-lg-12' ?> col-12 mt-5">
            <h3>Ảnh dự án</h3>
            <hr>
            <div class="row">
               <?php foreach($listImages as $item): ?>
               <div class="col-lg-4 col-6 mb-4">
                  <a href="<?php echo $item['image'] ?>" data-fancybox="gallery">
                     <img width="100%" height="100%" src="<?php echo $item['image'] ?>" alt="">
                  </a>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
         <?php endif; ?>
      </div>
   </div>
</section>
<!--/ End portfolios -->
<?php 
   layout('footer', 'client', $data);
?>