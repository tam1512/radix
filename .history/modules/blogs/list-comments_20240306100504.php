<?php
   $listComments = getRaw("SELECT * FROM comments ORDER BY create_at DESC")
?>

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