<?php
   $listComments = getRaw("SELECT * FROM comments WHERE blog_id = $id AND status = 1 ORDER BY create_at ASC");
   $countComments = !empty($listComments) ? count($listComments) : 0;
?>

<div class="blog-comments">
   <h2 class="title"><?php echo $countComments ?> Comments Found!</h2>
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
               <img
                  src="<?php echo !empty($comment['user_id']) && !empty(getAvatarById($comment['user_id'])) ? getAvatarById($comment['user_id']) : getAvatar($comment['email']) ?>"
                  alt="#">
            </div>
            <div class="body">
               <h4>
                  <?php echo !empty($comment['user_id']) && !empty(getUser($comment['user_id'])['name']) ? $comment['fullname']. ' <label class="badge badge-danger">'.getUser($comment['user_id'])['name'].'</lable>' : $comment['fullname'] ?>
               </h4>
               <div class="comment-info">
                  <p><span><?php echo getDateFormat($comment['create_at'], 'd/m/Y') ?> at<i
                           class="fa fa-clock-o"></i><?php echo getDateFormat($comment['create_at'], 'H:m') ?>,</span><a
                        href="<?php echo getLinkModule('blogs', $id, '', '', ['comment_id' => $comment['id']]).'#comment-form' ?>"><i
                           class="fa fa-comment-o"></i>replay</a></p>
               </div>
               <p><?php echo $comment['content'] ?></p>
            </div>
         </div>
         <?php 
            getCommentList($listComments, $comment['id'], $id);
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