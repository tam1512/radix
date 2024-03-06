<?php 
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $portfolioDetail = firstRaw('SELECT * FROM portfolios WHERE id = '.$id);
      $listCateId = getRaw("SELECT category_id FROM portfolio_category_mapping WHERE portfolio_id = $id");
      $listCategories = getRaw("SELECT id, name FROM portfolio_categories");

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
      }
      
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
<section id="portfolios" class="blogs-main services archives section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="single-blog">
               <div class="blog-head">
                  <img
                     src="<?php echo !empty($portfolioDetail['thumbnail']) ? $portfolioDetail['thumbnail'] : false  ?>"
                     alt="#">
               </div>
               <div class="blog-inner">
                  <div class="blog-top">
                     <div class="meta">
                        <span><i class="fa fa-bolt"></i></span>
                        <span><i
                              class="fa fa-calendar"></i><?php echo !empty($blogDefault['create_at']) ? getDateFormat($blogDefault['create_at'], 'd-m-Y') : false  ?></span>
                        <span><i class="fa fa-eye"></i><a
                              href="#"><?php echo !empty($blogDefault['view_count']) ? $blogDefault['view_count'] : false  ?></a></span>
                     </div>
                     <ul class="social-share">
                        <li><a href="<?php echo !empty($facebook) ? $facebook : false  ?>"><i
                                 class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo !empty($twitter) ? $twitter : false  ?>"><i
                                 class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php echo !empty($linkedin) ? $linkedin : false  ?>"><i
                                 class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                     </ul>
                  </div>
                  <h2><a href="#"><?php echo !empty($blogDefault['title']) ? $blogDefault['title'] : false  ?></a>
                  </h2>
                  <?php echo !empty($blogDefault['content']) ? html_entity_decode($blogDefault['content']) : false  ?>
                  <div class="bottom-area">
                     <!-- Next Prev -->
                     <ul class="arrow">
                        <li class="prev"><a
                              href="<?php echo getLinkClient('pages', 'blog-single', ['id'=>$prevId]) ?>"><i
                                 class="fa fa-angle-double-left"></i>Previews Posts</a>
                        </li>
                        <li class="next"><a
                              href="<?php echo getLinkClient('pages', 'blog-single', ['id'=>$nextId]) ?>">Next
                              Posts<i class="fa fa-angle-double-right"></i></a></li>
                     </ul>
                     <!--/ End Next Prev -->
                  </div>
               </div>
            </div>
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
      <div class="row mt-5">
         <?php 
            $isHaveVideo = false;
            if(!empty($portfolioDetail['video'])):
               $isHaveVideo = true;
          ?>
         <div class="col-6">
            <h3>Video</h3>
            <hr>
            <iframe width="560" height="315"
               src="https://www.youtube.com/embed/<?php echo getKeyYoutube($portfolioDetail['video']) ?>"
               title="YouTube video player" frameborder="0"
               allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
               allowfullscreen></iframe>
         </div>
         <?php endif; ?>
         <div class="<?php echo $isHaveVideo ? 'col-6' : 'col-12' ?>">
            <h3>Ảnh dự án</h3>
            <hr>
            <div class="row">
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
               <div class="col-4 mb-4">
                  <a href="http://radix.local/uploads/images/portfolio/p1.jpg" data-fancybox="gallery">
                     <img src="http://radix.local/uploads/images/portfolio/p1.jpg" alt="">
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End portfolios -->
<?php 
   layout('footer', 'client', $data);
?>