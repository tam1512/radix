<?php 
   if(isPost()) {
      $body = getBody('post');

      $errors = [];
      $fullname = trim($body['fullname']);
      $email = trim($body['email']);
      $website = empty(trim($body['website'])) ? '' : trim($body['website']);
      $content = trim($body['content']);

      if(empty($fullname)) {
         $errors['fullname']['required'] = 'Không được để trống họ tên';
      }

      if(empty($email)) {
         $errors['email']['required'] = 'Không được để trống họ tên';
      } else if (!isEmail($email)) {
         $errors['email']['invalid'] = 'Email không đúng định dạng';
      }

      if(empty($content)) {
         $errors['content']['required'] = 'Không được để trống nội dung comment';
      }

      if(empty($errors)) {
         $dataInsert = [
            'fullname' => $fullname,
            'email' => $email,
            'website' => $website,
            'content' => $content,
            'parent_id' => 0,
            'user_id' => null,
            'blog_id' => $id,
            'status' => 0,
            'create_at' => date('Y-m-d H:i:s')
         ];

         $insertStatus = insert('comments', $dataInsert);

         if($insertStatus) {
            setFlashData('msg', 'Thêm bình luận thành công.');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau');
            setFlashData('msg_type', 'danger');
         }
         redirect('?module=blogs&action=detail&id='.$id.'#comment-form');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('old', $body);
         redirect('?module=blogs&action=detail&id='.$id.'#comment-form');
      }

   }

   $message = getFlashData('msg');
   $msgType = getFlashData('msg_type');
   $errors = getFlashData('errors');
   $old = getFlashData('old');

?>
<div class="comments-form" id="comment-form">
   <h2 class="title">Leave a comment</h2>
   <?php getMsg($message, $msgType) ?>
   <!-- Contact Form -->
   <form class="form" method="post">
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