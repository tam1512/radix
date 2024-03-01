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
<!-- Portfolio -->
<section id="portfolio" class="portfolio section">
   <div class="container">
      <div class="row">
         <div class="col-12 wow fadeInUp">
            <div class="section-title">
               <span class="title-bg"><?php echo !empty($titleBg) ? $titleBg : false ?></span>
               <h1><?php echo !empty($title) ? $title : false ?></h1>
               <?php echo !empty($content) ? html_entity_decode($content) : false ?>
               <p></p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <!-- portfolio Nav -->
            <div class="portfolio-nav">
               <ul class="tr-list list-inline" id="portfolio-menu">
                  <li data-filter="*" class="cbp-filter-item active">
                     All Works
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <?php 
                     if(!empty($arrCates)): 
                        foreach($arrCates as $cate):
                  ?>
                  <li data-filter=".<?php echo $cate['name'] ?>" class="cbp-filter-item">
                     <?php echo $cate['name'] ?>
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <?php 
                        endforeach;
                     endif;
                  ?>
               </ul>
            </div>
            <!--/ End portfolio Nav -->
         </div>
      </div>
      <div class="portfolio-inner">
         <div class="row">
            <div class="col-12">
               <div id="portfolio-item">
                  <?php 
                     if(!empty($arrPortfolios)):
                        foreach($arrPortfolios as $portfolio):
                           $listCate = '';
                           foreach($portfolio['categories'] as $key=>$item) {
                              $listCate .= ' '.$item;
                           }
                  ?>
                  <!-- Single portfolio -->
                  <div class="cbp-item<?php echo $listCate ?>">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo $portfolio['thumbnail'] ?>" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4><a href="#"><?php echo $portfolio['name'] ?></a></h4>
                           <p>
                              <?php echo $portfolio['description'] ?>
                           </p>
                           <div class="button">
                              <a class="primary" data-fancybox="gallery" href="<?php echo $portfolio['thumbnail'] ?>"><i
                                    class="fa fa-search"></i></a>
                              <a href="#"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
                  <?php 
                        endforeach;
                     endif;
                  ?>
                  <!-- Single portfolio -->
                  <div class="cbp-item website package development">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p2.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4>
                              <a href="portfolio-single.html">Responsive Design</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA" class="primary cbp-lightbox"><i
                                    class="fa fa-play"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
                  <!-- Single portfolio -->
                  <div class="cbp-item website animation">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p3.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4>
                              <a href="portfolio-single.html">Bootstrap Based</a>
                           </h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a class="primary" data-fancybox="gallery"
                                 href="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p3.jpg"><i
                                    class="fa fa-search"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
                  <!-- Single portfolio -->
                  <div class="cbp-item development printing">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p4.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4><a href="portfolio-single.html">Clean Design</a></h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA" class="primary cbp-lightbox"><i
                                    class="fa fa-play"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
                  <!-- Single portfolio -->
                  <div class="cbp-item development package">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p5.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4><a href="portfolio-single.html">Animation</a></h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a class="primary" data-fancybox="gallery"
                                 href="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p5.jpg"><i
                                    class="fa fa-search"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
                  <!-- Single portfolio -->
                  <div class="cbp-item website animation printing">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p6.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4><a href="portfolio-single.html">Parallax</a></h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA" class="primary cbp-lightbox"><i
                                    class="fa fa-play"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
               </div>
            </div>
            <div class="col-12">
               <div class="button">
                  <a class="btn primary"
                     href="<?php echo !empty($btnLink) ? $btnLink : false ?>"><?php echo !empty($btn) ? $btn : false ?></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End portfolio -->