<?php 
   $titlePage = getOption('page_contact_title_page');
   $titleBg = getOption('page_contact_title-bg');
   $title = getOption('page_contact_title');
   $content = getOption('page_contact_content');
   $listTypes = getRaw("SELECT * FROM contact_types");

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
      if(isset($body['btn-submit-contact'])) {

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
   
         if(empty($type_id)) {
            $errors['type_id']['required'] = 'Vui lòng chọn loại liên hệ';
         }
   
         if(empty($message)) {
            $errors['message']['required'] = 'Không được để trống nội dung liên hệ';
         }

         if(empty($errors)) {
            $dataInsert = [
               'fullname' => $fullname,
               'email' => $email,
               'type_id' => $type_id,
               'message' => $message,
               'status' => 1,
               'create_at' => date('Y-m-d H:i:s')
            ];
   
            $insertStatus = insert('contacts', $dataInsert);
   
            if($insertStatus) {
               setFlashData('msg', 'Liên hệ đã được thêm. Vui lòng chờ quản trị viên duyệt');
               setFlashData('msg_type', 'success');
   
               $linkWeb = getLinkClient();
               $siteName = getOption("general_name_site");
   
               //Gửi email cho khách hàng
               $subjectCustomer = "[$siteName] Cảm ơn bạn đã gửi liên hệ đến chúng tôi";
               $contentCustomer = '<p>Chào <b>'.$fullname.'</b></p>';
               $contentCustomer .= '<p>Cảm ơn bạn đã gửi liên hệ cho chúng tôi. Dưới đây là thông tin liên hệ của bạn:</p>';
               $contentCustomer .= '<p>Họ và tên: '.$fullname.'</p>';
               $contentCustomer .= '<p>Email: '.$email.'</p>';
               $contentCustomer .= '<p>Nội dung: '.$message.'</p>';
               $contentCustomer .= '<p>Thời gian gửi: '.$dataInsert['create_at'].'</p>';
               $contentCustomer .= '<p>Loại liên hệ: '.getContactType($type_id)['name'].'</p>';
               $contentCustomer .= '<p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất</p>';
               $contentCustomer .= '<p>Trân trọng</p>';
   
               sendMail($email, $subjectCustomer, $contentCustomer);
   
               //Gửi email cho quản trị viên
               $subjectAdmin = "[$siteName] $fullname gửi liên hệ";
               $contentAdmin = '<p>Họ và tên: '.$fullname.'</p>';
               $contentAdmin .= '<p>Email: '.$email.'</p>';
               $contentAdmin .= '<p>Nội dung: '.$message.'</p>';
               $contentAdmin .= '<p>Thời gian gửi: '.$dataInsert['create_at'].'</p>';
               $contentAdmin .= '<p>Loại liên hệ: '.getContactType($type_id)['name'].'</p>';
               $contentAdmin .= '<p>Liên hệ được gửi từ: <a href="'.$linkWeb.'">'.$linkWeb.'</></p>';
   
               sendMail(getOption('general_email'), $subjectAdmin, $contentAdmin);
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau');
               setFlashData('msg_type', 'danger');
            }
            redirect(getLinkClient('contact').'#form-contact', true);
         } else {
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
            setFlashData('msg_type', 'danger');
            setFlashData('errors', $errors);
            setFlashData('old', $body);
            redirect(getLinkClient('contact').'#form-contact', true);
         }
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
                  <div class="col-lg-8 col-12" id="form-contact">
                     <div class="form-main">
                        <div class="text-content">
                           <h2>Send Message Us</h2>
                        </div>
                        <?php getMsg($message, $msgType) ?>
                        <form class="form" method="post">
                           <div class="row">
                              <div class="col-lg-6 col-12">
                                 <div class="form-group">
                                    <input type="text" name="fullname" placeholder="Full Name"
                                       value="<?php echo form_infor('fullname', $old) ?>">
                                    <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-12">
                                 <div class="form-group">
                                    <input type="email" name="email" placeholder="Your Email"
                                       value="<?php echo form_infor('email', $old) ?>">
                                    <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="form-group">
                                    <select name="type_id">
                                       <?php 
                                          if(!empty($listTypes)):
                                             foreach($listTypes as $item):
                                       ?>
                                       <option class="option" value="<?php echo $item['id'] ?>"
                                          <?php !empty($old['type_id']) && $old['type_id'] == $item['id'] ? 'selected' : false ?>>
                                          <?php echo $item['name'] ?></option>
                                       <?php 
                                             endforeach;
                                          endif;
                                       ?>
                                    </select>
                                    <?php echo form_error('type_id', $errors, '<span class="error">', '</span>') ?>
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group">
                                    <textarea name="message" rows="6"
                                       placeholder="Type Your Message"><?php echo form_infor('fullname', $old) ?></textarea>
                                    <?php echo form_error('message', $errors, '<span class="error">', '</span>') ?>
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group button">
                                    <button type="submit" class="btn primary" name="btn-submit-contact">Submit
                                       Message</button>
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