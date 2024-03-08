<?php 
   //Sử dụng gravatar để lấy ảnh trung gian

   $arrBlogs = getRaw('SELECT * FROM blogs');
   $arrBlogsCates = getRaw('SELECT * FROM blog_categories');

   //có thể sử dụng array_column để lấy ra key hiện tại dự vào key của phần tử trong mảng

   $prevId = null;
   $nextId = null;

   $blogDefault = [];
   if(!empty(getBody('get')['id'])) {
      $id = getBody('get')['id'];

      $blogCheck = firstRaw("SELECT id FROM blogs WHERE id = $id");
      if(empty($blogCheck)) {
         redirect("modules/errors/404.php");
      }

      //tăng view
      setView($id);

      foreach($arrBlogs as $key => $item) {
         if($id == $item['id']) {
            if(!empty($arrBlogs[$key-1]['id'])) {
               $prevId = $arrBlogs[$key-1]['id'];
            } else {
               $prevId = $arrBlogs[0]['id'];
            }
            if(!empty($arrBlogs[$key+1]['id'])) {
               $nextId = $arrBlogs[$key+1]['id'];
            } else {
               $nextId = $arrBlogs[0]['id'];
            }
            $blogDefault = $item;
            break;
         }
      }

      foreach($arrBlogsCates as $item) {
         if($blogDefault['category_id'] == $item['id']) {
            $blogDefault['cate_name'] = $item['name'];
         }
      }
      $idAuthor = $blogDefault['user_id'];
      $authorBlog = firstRaw("SELECT * FROM users WHERE id = $idAuthor");
      $countBlogsOfAuthor = getRows("SELECT id FROM blogs WHERE id = $idAuthor");

      $listGroups = getRaw("SELECT id, name FROM groups");

      $key = array_search($authorBlog['group_id'], array_column($listGroups, 'id'));

      $nameGroup = $listGroups[$key]['name'];

   } else {
      redirect("modules/errors/404.php");
   }

   $titlePage = getOption('page_blogs_title_page');
   $data = [
      'title' => $titlePage,
      'name' => 'Ours Blogs',
      'parent' => 'Blogs',
      'parentVN' => 'Bài viết',
      'category' => $blogDefault['cate_name'],
      'category_id' => $blogDefault['category_id'],
   ];

   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);
?>
<!-- Blogs Area -->
<section class="blogs-main archives single section">
   <div class="container">
      <div class="row">
         <div class="col-lg-10 offset-lg-1 col-12">
            <?php if(!empty($blogDefault)): ?>
            <div class="row">
               <div class="col-12">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-head">
                        <img src="<?php echo !empty($blogDefault['thumbnail']) ? $blogDefault['thumbnail'] : false  ?>"
                           alt="#">
                     </div>
                     <div class="blog-inner">
                        <div class="blog-top">
                           <div class="meta">
                              <span><i class="fa fa-bolt"></i><a
                                    href="<?php echo getLinkClient("blogs", "category", ["id" => $blogDefault['category_id']]) ?>"><?php echo !empty($blogDefault['cate_name']) ? $blogDefault['cate_name'] : false  ?></a></span>
                              <span><i
                                    class="fa fa-calendar"></i><?php echo !empty($blogDefault['create_at']) ? getDateFormat($blogDefault['create_at'], 'd-m-Y') : false  ?></span>
                              <span><i class="fa fa-eye"></i><a
                                    href="#"><?php echo !empty($blogDefault['view_count']) ? $blogDefault['view_count'] : 0  ?></a></span>
                           </div>
                           <ul class="social-share">
                              <li>
                                 <a href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=".getLinkClient("blogs", "detail", ['id' => $id])  ?>"
                                    target="_blank">
                                    <i class="fa fa-facebook"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="<?php echo "http://twitter.com/share?text=".$blogDefault['title']."&url=".getLinkClient('blogs', 'detail', ['id' => $id]) ?>"
                                    target="_blank">
                                    <i class="fa fa-twitter"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="<?php echo "https://www.linkedin.com/cws/share?url=".getLinkClient('blogs', 'detail', ['id' => $id]) ?>"
                                    target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="<?php echo "http://pinterest.com/pin/create/button/?url=".getLinkClient('blogs', 'detail', ['id' => $id]) ?>"
                                    target="_blank">
                                    <i class="fa fa-pinterest"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="<?php echo "https://plus.google.com/share?url=".getLinkClient('blogs', 'detail', ['id' => $id]) ?>"
                                    target="_blank">
                                    <i class="fa fa-google-plus"></i>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <h2><a href="#"><?php echo !empty($blogDefault['title']) ? $blogDefault['title'] : false  ?></a>
                        </h2>
                        <?php echo !empty($blogDefault['content']) ? html_entity_decode($blogDefault['content']) : false  ?>
                        <div class="bottom-area">
                           <!-- Next Prev -->
                           <ul class="arrow">
                              <li class="prev"><a
                                    href="<?php echo getLinkClient('blogs', 'detail', ['id'=>$prevId]) ?>"><i
                                       class="fa fa-angle-double-left"></i>Previews Posts</a>
                              </li>
                              <li class="next"><a
                                    href="<?php echo getLinkClient('blogs', 'detail', ['id'=>$nextId]) ?>">Next
                                    Posts<i class="fa fa-angle-double-right"></i></a></li>
                           </ul>
                           <!--/ End Next Prev -->
                        </div>
                     </div>
                  </div>
                  <!-- End Single Blog -->
               </div>
               <div class="col-12">
                  <div class="author-details">
                     <div class="author-left">
                        <img src="<?php echo $authorBlog['avatar'] ?>" alt="#">
                        <h4>About Author<span><?php echo $nameGroup ?></span></h4>
                        <p><a href="#"><i class="fa fa-pencil"></i><?php echo $countBlogsOfAuthor ?> posts</a></p>
                     </div>
                     <div class="author-content">
                        <?php echo $authorBlog['about_content'] ?>
                        <ul class="social-share">
                           <li><a href="<?php echo $authorBlog['contact_facebook'] ?>"><i
                                    class="fa fa-facebook"></i></a></li>
                           <li><a href="<?php echo $authorBlog['contact_twitter'] ?>"><i class="fa fa-twitter"></i></a>
                           </li>
                           <li><a href="<?php echo $authorBlog['contact_linkedin'] ?>"><i
                                    class="fa fa-linkedin"></i></a></li>
                           <li><a href="<?php echo $authorBlog['contact_pinterest'] ?>"><i
                                    class="fa fa-pinterest"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="blog-comments">
                     <h2 class="title">37 Comments Found!</h2>
                     <div class="comments-body">
                        <!-- Single Comments -->
                        <div class="single-comments">
                           <div class="main">
                              <div class="head">
                                 <img src="images/client1.jpg" alt="#">
                              </div>
                              <div class="body">
                                 <h4>Lufia Roshan</h4>
                                 <div class="comment-info">
                                    <p><span>03 May, 2018 at<i class="fa fa-clock-o"></i>12:20PM,</span><a href="#"><i
                                             class="fa fa-comment-o"></i>replay</a></p>
                                 </div>
                                 <p>some form, by injected humour, or randomised words Mirum est notare quam littera
                                    gothica, quam nunc putamus parum claram, anteposuerit litterarum formas</p>
                              </div>
                           </div>
                           <div class="comment-list">
                              <div class="head">
                                 <img src="images/client2.jpg" alt="#">
                              </div>
                              <div class="body">
                                 <h4>Josep Bambo</h4>
                                 <div class="comment-info">
                                    <p><span>03 May, 2018 at<i class="fa fa-clock-o"></i>12:40PM,</span><a href="#"><i
                                             class="fa fa-comment-o"></i>replay</a></p>
                                 </div>
                                 <p>sagittis ex consectetur sed. Ut viverra elementum libero, nec tincidunt orci
                                    vehicula quis</p>
                              </div>
                           </div>
                        </div>
                        <!--/ End Single Comments -->
                        <!-- Single Comments -->
                        <div class="single-comments">
                           <div class="main">
                              <div class="head">
                                 <img src="images/client3.jpg" alt="#">
                              </div>
                              <div class="body">
                                 <h4>Trolia Ula</h4>
                                 <div class="comment-info">
                                    <p><span>05 May, 2018 at<i class="fa fa-clock-o"></i>08:00AM,</span><a href="#"><i
                                             class="fa fa-comment-o"></i>replay</a></p>
                                 </div>
                                 <p>Lorem Ipsum available, but the majority have suffered alteration in some form, by
                                    injected humour, or randomised words Mirum est notare quam littera gothica</p>
                              </div>
                           </div>
                        </div>
                        <!--/ End Single Comments -->
                        <!-- Single Comments -->
                        <div class="single-comments">
                           <div class="main">
                              <div class="head">
                                 <img src="images/client4.jpg" alt="#">
                              </div>
                              <div class="body">
                                 <h4>James Romans</h4>
                                 <div class="comment-info">
                                    <p><span>06 May, 2018 at<i class="fa fa-clock-o"></i>02:00PM,</span><a href="#"><i
                                             class="fa fa-comment-o"></i>replay</a></p>
                                 </div>
                                 <p>Lorem Ipsum available, but the majority have suffered alteration in some form, by
                                    injected humour, or randomised words Mirum est notare quam</p>
                              </div>
                           </div>
                        </div>
                        <!--/ End Single Comments -->
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="comments-form">
                     <h2 class="title">Leave a comment</h2>
                     <!-- Contact Form -->
                     <form class="form" method="post" action="mail/mail.php">
                        <div class="row">
                           <div class="col-lg-4 col-12">
                              <div class="form-group">
                                 <input type="text" name="name" placeholder="Full Name" required="required">
                              </div>
                           </div>
                           <div class="col-lg-4 col-12">
                              <div class="form-group">
                                 <input type="email" name="email" placeholder="Your Email" required="required">
                              </div>
                           </div>
                           <div class="col-lg-4 col-12">
                              <div class="form-group">
                                 <input type="url" name="website" placeholder="Website" required="required">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group">
                                 <textarea name="message" rows="5" placeholder="Type Your Message Here"></textarea>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group button">
                                 <button type="submit" class="btn primary">Submit Comment</button>
                              </div>
                           </div>
                        </div>
                     </form>
                     <!--/ End Contact Form -->
                  </div>
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