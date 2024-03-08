<?php 
   $titlePage = getOption('page_contact_title_page');
   $titleBg = getOption('page_contact_title-bg');
   $title = getOption('page_contact_title');
   $content = getOption('page_contact_content');
   $listDepartments = getRaw("SELECT * FROM departments");

   $address = getOption('general_address');
   $hotline = getOption('general_hotline');
   $email = getOption('general_email');

   $facebook = getOption('general_facebook');
   $twitter = getOption('general_twitter');
   $linkedin = getOption('general_linkedin');
   $behance = getOption('general_behance');

   $data = [
      'title' => $titlePage,
      'name' => 'Contact'
   ];

   layout('header', 'client', $data);
   layout('breadcrumb', 'client', $data);

   if(isPost()) {
      $body = getBody('post');

      $errors = [];
      $fullname = trim(strip_tags($body['fullname']));
      $email = trim(strip_tags($body['email']));
      $type_id = trim($body['type_id']);
      $message = trim(strip_tags($body['message']));
     

      if(empty($fullname)) {
         $errors['fullname']['required'] = 'Không được để trống họ tên';
      }

      if(empty($email)) {
         $errors['email']['required'] = 'Không được để trống họ tên';
      } else if (!isEmail($email)) {
         $errors['email']['invalid'] = 'Email không đúng định dạng';
      }

      if(empty($department_id)) {
         $errors['department_id']['required'] = 'Vui lòng chọn loại liên hệ';
      }

      if(empty($message)) {
         $errors['message']['required'] = 'Không được để trống nội dung liên hệ';
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
?>
<!-- Start Contact -->
<section id="contact-us" class="contact-us section">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="section-title">
               <span class="title-bg"><?php echo !empty($titleBg) ? $titleBg : false ?></span>
               <h1><?php echo !empty($title) ? $title : false ?></h1>
               <?php echo !empty($content) ? html_entity_decode($content) : false ?>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="contact-main">
               <div class="row">
                  <!-- Contact Form -->
                  <div class="col-lg-8 col-12">
                     <div class="form-main">
                        <div class="text-content">
                           <h2>Send Message Us</h2>
                        </div>
                        <form class="form" method="post" action="mail/mail.php">
                           <div class="row">
                              <div class="col-lg-6 col-12">
                                 <div class="form-group">
                                    <input type="text" name="name" placeholder="Full Name" required="required">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-12">
                                 <div class="form-group">
                                    <input type="email" name="email" placeholder="Your Email" required="required">
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="form-group">
                                    <select name="subject">
                                       <?php 
                                          if(!empty($listDepartments)):
                                             foreach($listDepartments as $item):
                                       ?>
                                       <option class="option" value="<?php echo $item['id'] ?>">
                                          <?php echo $item['name'] ?></option>
                                       <?php 
                                             endforeach;
                                          endif;
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group">
                                    <textarea name="message" rows="6" placeholder="Type Your Message"></textarea>
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group button">
                                    <button type="submit" class="btn primary">Submit Message</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <!--/ End Contact Form -->
                  <!-- Contact Address -->
                  <div class="col-lg-4 col-12">
                     <div class="contact-address">
                        <!-- Address -->
                        <div class="contact">
                           <h2>Our Contact Address</h2>
                           <ul class="address">
                              <li><i class="fa fa-paper-plane"></i><span>Address: </span>
                                 <?php echo !empty($address) ? $address : false ?></li>
                              <li><i class="fa fa-phone"></i><span>Phone:
                                 </span><?php echo !empty($hotline) ? $hotline : false ?></li>
                              <li class="email"><i class="fa fa-envelope"></i><span>Email: </span><a
                                    href="mailto:<?php echo !empty($email) ? $email : false ?>"><?php echo !empty($email) ? $email : false ?></a>
                              </li>
                           </ul>
                        </div>
                        <!--/ End Address -->
                        <!-- Social -->
                        <ul class="social">
                           <li><a href="<?php echo !empty($facebook) ? $facebook : false ?>"><i
                                    class="fa fa-facebook"></i>Like Us facebook</a></li>
                           <li><a href="<?php echo !empty($twitter) ? $twitter : false ?>"><i
                                    class="fa fa-twitter"></i>Follow Us twitter</a></li>
                           <li><a href="#"><i class="fa fa-google-plus"></i>Follow Us google-plus</a></li>
                           <li><a href="<?php echo !empty($linkedin) ? $linkedin : false ?>"><i
                                    class="fa fa-linkedin"></i>Follow Us linkedin</a></li>
                           <li><a href="<?php echo !empty($behance) ? $behance : false ?>"><i
                                    class="fa fa-behance"></i>Follow Us behance</a></li>
                        </ul>
                        <!--/ End Social -->
                     </div>
                  </div>
                  <!--/ End Contact Address -->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--/ End Contact -->
<?php 
   require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
   layout('footer', 'client', $data);
?>