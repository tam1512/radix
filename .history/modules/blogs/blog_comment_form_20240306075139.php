<?php 
   if(isPost()) {
      $body = getBody('post');

   }

?>
<div class="comments-form">
   <h2 class="title">Leave a comment</h2>
   <!-- Contact Form -->
   <form class="form" method="post" action="mail/mail.php">
      <div class="row">
         <div class="col-lg-4 col-12">
            <div class="form-group">
               <input type="text" name="fullname" placeholder="Full Name"
                  value="<?php echo form_infor('fullname', $old) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>

            </div>
         </div>
         <div class="col-lg-4 col-12">
            <div class="form-group">
               <input type="email" name="email" placeholder="Your Email"
                  value="<?php echo form_infor('email', $old) ?>">
               <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-lg-4 col-12">
            <div class="form-group">
               <input type="url" name="website" placeholder="Website" value="<?php echo form_infor('website', $old) ?>">
               <?php echo form_error('website', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <textarea name="content" rows="5"
                  placeholder="Type Your Message Here"><?php echo form_infor('content', $old) ?></textarea>
               <?php echo form_error('content', $errors, '<span class="error">', '</span>') ?>
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