<?php 
   $arrPortfolios = getRaw('SELECT * FROM portfolios');
   $arrCates = getRaw('SELECT * FROM portfolio_categories');
   $mapping = getRaw('SELECT * FROM portfolio_category_mapping');
   
   //1 mảng đầy đủ thông tin của portfolios + categories: id => name
   foreach($arrPortfolios as $key => $value) {
      foreach($mapping as $itemMap) {
         if($itemMap['portfolio_id'] == $value['id']) {
            foreach($arrCates as $cate) {
               if($itemMap['category_id'] == $cate['id']) {
                  $arrPortfolios[$key]['categories'][$cate['id']] = $cate['name'];
                  break;
               }
            }
         }
      }
   }

   $titleBg = getOption('home_portfolios_title-bg');
   $title = getOption('home_portfolios_title');
   $content = getOption('home_portfolios_content');
   $btn = getOption('home_portfolios_btn');
   $btnLink = getOption('home_portfolios_btn_link');
?>
<!-- Blogs Area -->
<section class="blogs-main section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg">News</span>
               <h1>Latest Blogs</h1>
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
            <div class="row blog-slider">
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog1.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">Recognizing the need is the primary</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Marketing</a></span>
                              <span><i class="fa fa-calendar"></i>03 May, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">333k</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog2.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">How to grow your business with blank table!</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Business</a></span>
                              <span><i class="fa fa-calendar"></i>28 April, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">5m</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog3.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">10 ways to improve your startup Business</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Brand</a></span>
                              <span><i class="fa fa-calendar"></i>15 April, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">10m</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog4.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">Recognizing the need is the primary</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Online</a></span>
                              <span><i class="fa fa-calendar"></i>25 March, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">38k</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog5.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">How to grow your business with blank table!</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Marketing</a></span>
                              <span><i class="fa fa-calendar"></i>10 March, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">100k</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>blogs/blog6.jpg" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="blog-single.html">10 ways to improve your startup Business</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac tincidunt tortor sedelon bond
                           </p>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a href="#">Website</a></span>
                              <span><i class="fa fa-calendar"></i>21 February, 2018</span>
                              <span><i class="fa fa-eye"></i><a href="#">320k</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Blogs Area -->