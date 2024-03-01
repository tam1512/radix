<?php 
   $arrPortfolios = getRaw('SELECT * FROM portfolios');
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
                  <li data-filter=".animation" class="cbp-filter-item">
                     Animation
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <li data-filter=".website" class="cbp-filter-item">
                     Website
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <li data-filter=".package" class="cbp-filter-item">
                     Package
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <li data-filter=".development" class="cbp-filter-item">
                     Development
                     <div class="cbp-filter-counter"></div>
                  </li>
                  <li data-filter=".printing" class="cbp-filter-item">
                     Printing
                     <div class="cbp-filter-counter"></div>
                  </li>
               </ul>
            </div>
            <!--/ End portfolio Nav -->
         </div>
      </div>
      <div class="portfolio-inner">
         <div class="row">
            <div class="col-12">
               <div id="portfolio-item">
                  <!-- Single portfolio -->
                  <div class="cbp-item website animation printing">
                     <div class="portfolio-single">
                        <div class="portfolio-head">
                           <img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p1.jpg" alt="#" />
                        </div>
                        <div class="portfolio-hover">
                           <h4><a href="portfolio-single.html">Creative Work</a></h4>
                           <p>
                              Maecenas sapien erat, porta non porttitor non, dignissim
                              et enim. Aenean ac enim
                           </p>
                           <div class="button">
                              <a class="primary" data-fancybox="gallery"
                                 href="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>portfolio/p1.jpg"><i
                                    class="fa fa-search"></i></a>
                              <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--/ End portfolio -->
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