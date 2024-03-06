<?php
   $listComments = getRaw("SELECT * FROM comments WHERE blog_id = $id AND status = 1 ORDER BY create_at ASC");
   $countComments = !empty($listComments) ? count($listComments) : 0;
?>

<div class="blog-comments">
   <h2 class="title"><?php echo $countComment ?></h2>
   <div class="comments-body">
      <?php 
         if(!empty($listComments)):
            foreach($listComments as $comment):
               if(empty($comment['parent_id'])):
      ?>
      <!-- Single Comments -->
      <div class="single-comments">
         <div class="main">
            <div class="head">
               <img src="<?php echo getAvatar($comment['email']) ?>" alt="#">
            </div>
            <div class="body">
               <h4><?php echo $comment['fullname'] ?></h4>
               <div class="comment-info">
                  <p><span><?php echo getDateFormat($comment['create_at'], 'd/m/Y') ?> at<i
                           class="fa fa-clock-o"></i><?php echo getDateFormat($comment['create_at'], 'H:m') ?>,</span><a
                        href="#"><i class="fa fa-comment-o"></i>replay</a></p>
               </div>
               <p><?php echo $comment['content'] ?></p>
            </div>
         </div>
         <?php 
            foreach($listComments as $item):
               if($comment['id'] == $item['parent_id']):
         ?>
         <div class="comment-list">
            <div class="head">
               <img src="<?php echo getAvatar($item['email']) ?>" alt="#">
            </div>
            <div class="body">
               <h4><?php echo $item['fullname'] ?></h4>
               <div class="comment-info">
                  <p><span><?php echo getDateFormat($item['create_at'], 'd/m/Y') ?> at<i
                           class="fa fa-clock-o"></i><?php echo getDateFormat($item['create_at'], 'H:m') ?>,</span><a
                        href="#"><i class="fa fa-comment-o"></i>replay</a></p>
               </div>
               <p><?php echo $item['content'] ?></p>
            </div>
         </div>
         <?php 
               endif;
            endforeach;
         ?>
      </div>
      <!--/ End Single Comments -->
      <?php
               endif;
            endforeach;
         else:
      ?>
      <div class="single-comments">
         <div class="alert alert-success text-center">Không có bình luận. Hãy là người đầu tiên bình luận.</div>
      </div>
      <?php endif ?>
   </div>
</div>