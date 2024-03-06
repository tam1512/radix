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
      $countBlogsOfAuthor = getRows("SELECT id FROM blogs WHERE user_id = $idAuthor");

      $listGroups = getRaw("SELECT id, name FROM groups");

      $key = array_search($authorBlog['group_id'], array_column($listGroups, 'id'));

      $nameGroup = $listGroups[$key]['name'];


      if(!empty(isLogin()['user_id'])) {
         $userId = isLogin()['user_id'];
         $userInfor = firstRaw("SELECT fullname, email, groups.name FROM users JOIN groups ON users.group_id = groups.id WHERE users.id = $userId AND users.status = 1");
      } else {
         $userId = null;
      }

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
                        <p><a href="<?php echo getLinkClient('blogs', 'author', ['id' => $authorBlog['id']]) ?>"><i
                                 class="fa fa-pencil"></i><?php echo $countBlogsOfAuthor ?> posts</a></p>
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
                  <?php require_once("list-comments.php") ?>
               </div>
               <div class="col-12">
                  <?php require_once("blog_comment_form.php") ?>
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