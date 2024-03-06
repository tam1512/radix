<?php 
   // echo '<pre>';
   // print_r($listComments);
   // echo '</pre>';
   // die();

   $body = getBody('get');
   if(!empty($body['comment_id'])) {
      $commentId = $body['comment_id'];
      $keyComment = array_search($commentId, array_column($listComments, 'id'));
      $commentCurrent = $listComments[$keyComment];
   }

   if(isPost()) {
      $body = getBody('post');

      $errors = [];
      if(!empty($userInfor)) {
         $fullname = $userInfor['fullname'];
         $email = $userInfor['email'];
      } else {
         $fullname = trim($body['fullname']);
         $email = trim($body['email']);
      }
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
            'user_id' => $userId,
            'blog_id' => $id,
            'status' => 0,
            'create_at' => date('Y-m-d H:i:s')
         ];

         if(!empty($commentCurrent)) {
            $dataInsert['parent_id'] = $commentCurrent['id'];
            $dataInsert['status'] = 1;
         }

         $insertStatus = insert('comments', $dataInsert);

         if($insertStatus) {

            if(empty($userIndfor)) {
               $commentInfor = [
                  "fullname" => $fullname,
                  "email" => $email,
                  "website" => $website,
               ];
               setcookie('commentInfor', json_encode($commentInfor), time()+24*60*60*365);
            }

            if(!empty($commentCurrent)) {
               setFlashData('msg', 'Trả lời bình luận của '.$commentCurrent['fullname'].' thành công.');
            } else {
               setFlashData('msg', 'Bình luận đã được thêm. Vui lòng chờ quản trị viên duyệt');
            }
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

   $commentInfor = [];
   if(!empty($_COOKIE['commentInfor'])) {
      $commentInfor = json_decode($_COOKIE['commentInfor'], true);
   }

   if(empty($old)) {
      $old = $commentInfor;
   }

?>
<div class="comments-form" id="comment-form">
   <h2 class="title">
      <?php 
      if(!empty($userInfor)) {
         echo 'Bạn đang đăng nhập với tài khoản <b>'.$userInfor['fullname'].'<b> - <a href="'.getLinkAdmin('auth', 'logout').'">Đăng xuất</a>';
      } else {
         echo !empty($commentCurrent['fullname']) ? 'Reply to '.$commentCurrent['fullname'].'<a class="text-danger" href="'.getLinkClient('blogs', 'detail', ['id' => $id]).'"><i class="fa fa-times"></i>Cancel</a>' : 'Leave a comment';
      }
      ?>
   </h2>
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