<?php 
   $arrBlogs = getRaw('SELECT * FROM blogs');
   $arrBlogsCates = getRaw('SELECT * FROM blog_categories');
   

   $titlePage = getOption('page_blogs_title_page');
   $titleBg = getOption('page_blogs_title-bg');
   $title = getOption('page_blogs_title');
   $content = getOption('page_blogs_content');

   $isPage = false;
   if(empty($data)) {
      $data = [
         'title' => $titlePage,
         'name' => 'Blogs'
      ];
      $isPage = true;

      layout('header', 'client', $data);
      layout('breadcrumb', 'client', $data);
   }
?>
<!-- Blogs Area -->
<section class="blogs-main section">
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
            <div class="row blog-slider">
               <?php 
                  if(!empty($arrBlogs)):
                     foreach($arrBlogs as $item):
               ?>
               <div class="col-lg-4 col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo $item['thumbnail'] ?>" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a href="#"><?php echo $item['title'] ?></a>
                           </h4>
                           <?php echo html_entity_decode($item['description']) ?>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i>
                                 <a href="#">
                                    <?php 
                                       foreach($arrBlogsCates as $cate) {
                                          if($cate['id'] == $item['category_id']) {
                                             echo $cate['name'];
                                             break;
                                          }
                                       }
                                    ?>
                                 </a>
                              </span>
                              <span><i
                                    class="fa fa-calendar"></i><?php echo getDateFormat($item['create_at'], 'd-m-Y') ?></span>
                              <span><i class="fa fa-eye"></i><a href="#"><?php echo $item['view_count'] ?></a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <?php endforeach; endif;?>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Blogs Area -->