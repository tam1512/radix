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
      'parent' => 'Services'
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
      </div>
   </div>
</section>
<!--/ End Services -->
<?php 
   layout('footer', 'client', $data);
?>