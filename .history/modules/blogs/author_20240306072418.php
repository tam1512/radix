<?php 

   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];
   } else {
      redirect("modules/errors/404.php");
      die();
   }

   $arrBlogs = getRaw('SELECT * FROM blogs WHERE user_id = ' . $id);
   $listCategories = getRaw('SELECT id, name FROM blog_categories');
   

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


      //pagination
      $blogOnPage = _BLOG_ON_FRONT_PAGE;
      $countRowBlogs = count($arrBlogs);
      $numPage = ceil($countRowBlogs/$blogOnPage);
      $limitPagination = _LIMIT_PAGINATION;

      $page = 1;
      if(isGet()) {
         $page = !empty(getBody('get')['page']) ? getBody('get')['page'] : 1;
         if($page < 1 && $page > $numPage) {
            $page = 1;
         }
      }

      $offset = ($page - 1) * $blogOnPage;
      $listBlogOnPage = getRaw("SELECT * FROM blogs WHERE user_id = $id LIMIT $offset, $blogOnPage");
   }
   $arrBlogShow = [];   
   if(!empty($listBlogOnPage)) {
      $arrBlogShow = $listBlogOnPage;
   } else {
      $arrBlogShow = $arrBlogs;
   }
?>
<!-- Blogs Area -->
<section class="blogs-main <?php echo $isPage ? 'archives' : false ?> section">
   <div class="container">
      <?php if(!$isPage): ?>
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
      <?php endif ?>
      <div class="row">
         <?php if(!$isPage): ?>
         <div class="col-12">
            <div class="row blog-slider">
               <?php 
               endif;
                  if(!empty($arrBlogShow)):
                     foreach($arrBlogShow as $item):
               ?>
               <div class="col-lg-4 <?php echo $isPage ? 'col-md-6' : false ?> col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo $item['thumbnail'] ?>" alt="#" />
                     </div>
                     <div class="blog-bottom">
                        <div class="blog-inner">
                           <h4>
                              <a
                                 href="<?php echo getLinkClient('blogs', 'detail', ["id" => $item['id']]) ?>"><?php echo $item['title'] ?></a>
                           </h4>
                           <?php echo html_entity_decode($item['description']) ?>
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i>
                                 <?php 
                                    foreach($listCategories as $cate) {
                                       if($cate['id'] == $item['category_id']) {
                                          echo '<a href="'.getLinkClient('blogs', 'author', ["id" => $cate['id']]).'">'.$cate['name'].'</a>';
                                          break;
                                       }
                                    }
                                 ?>
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
               <?php 
                     endforeach; 
                  endif;
               if(!$isPage):
               ?>
            </div>
         </div>
         <?php endif; ?>
      </div>
      <?php if($isPage): ?>
      <div class="row">
         <div class="col-12">
            <!-- Start Pagination -->
            <div class="pagination-main">
               <ul class="pagination">
                  <li class="prev">
                     <a href="
                        <?php 
                           if($page <= 1) {
                              $prevPage = 1;
                           } else {
                              $prevPage = $page - 1;
                           }
                           echo getLinkClient('blogs', 'author', ['id'=>$id, 'page'=>$prevPage]);
                        ?>">
                        <i class="fa fa-angle-double-left"></i>
                     </a>
                  </li>
                  <?php 
                     if(!empty($numPage)) {
                        $begin = $page - 2;
                        if($begin < 1) {
                           $begin = 1;
                        }
                        $end = $begin + $limitPagination - 1;
                        if($end >= $numPage) {
                           $end = $numPage;
                           $begin = $end - $limitPagination + 1;
                        }

                        if($numPage <= $limitPagination) {
                           for($i = 1; $i <= $numPage; $i++) {
                              if($page == $i) {
                                 echo '<li class="active"><a href="'.getLinkClient('blogs', 'author', ['id' => $id, 'page' => $i]).'">'.$i.'</a></li>';
                              } else {
                                 echo '<li><a href="'.getLinkClient('blogs', 'author', ['id' => $id, 'page' => $i]).'">'.$i.'</a></li>';
                              }
                           }
                        } else {
                           for($i = $begin; $i <= $end; $i++) {
                              if($page == $i) {
                                 echo '<li class="active"><a href="'.getLinkClient('blogs', 'author', ['id' => $id, 'page' => $i]).'">'.$i.'</a></li>';
                              } else {
                                 echo '<li><a href="'.getLinkClient('blogs', 'author', ['id' => $id, 'page' => $i]).'">'.$i.'</a></li>';
                              }
                           }
                        }
                     }
                  ?>
                  <li class="next">
                     <a href="
                        <?php
                           if($page >= $numPage) {
                              $nextPage = 1;
                           } else {
                              $nextPage = $page + 1;
                           }
                           echo getLinkClient('blogs', 'author', ['id' => $id, 'page' => $nextPage]);
                        ?>">
                        <i class="fa fa-angle-double-right"></i>
                     </a>
                  </li>
               </ul>
            </div>
            <!--/ End Pagination -->
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<!--/ End Blogs Area -->
<?php 
   if($isPage) {
      require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
      layout('footer', 'client', $data);
   }
?>