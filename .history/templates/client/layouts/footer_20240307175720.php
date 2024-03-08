<?php
if(!defined('_INCODE')) die('Access denied...');

$jsonFooter2 = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'footer_2'")['opt_value'];
$footer2 = json_decode($jsonFooter2, true);

if(!empty($footer2)) {
   foreach($footer2 as $key => $value) {
      if(is_array($value)) {
         foreach($value as $k => $v) {
            $arrQuickLinks[$k][$key] =$v ;
         }
      } else {
         $arrFooter2[$key] = $value;
      }
   }
}


$titleFooter1 = getOption('footer_1_title');
$contentFooter1 = getOption('footer_1_content');
$titleFooter4 = getOption('footer_4_title');
$contentFooter4 = getOption('footer_4_content');
$titleFooter3 = getOption('footer_3_title');
$twitterFooter3 = getOption('footer_1_twitter');
$linkTwitter = "https://twitter.com/".$twitterFooter3;

$address = getOption('general_address');
$hotline = getOption('general_hotline');
$email = getOption('general_email');


$linkFacebook = getOption('general_facebook');
$linkTwitter = getOption('general_Twitter');
$linkLinkedin = getOption('general_linkedin');
$linkBehance = getOption('general_behance');
$linkYoutube = getOption('general_youtube');

$copyrightContent = getOption('copyright_content');

if(isPost()) {
   $body = getBody('post');

   $errors = [];
   if(!empty($userInfor)) {
      $fullname = $userInfor['fullname'];
      $email = $userInfor['email'];
      $website = "";
   } else {
      $fullname = trim($body['fullname']);
      $email = trim($body['email']);
      $website = empty(trim($body['website'])) ? '' : trim($body['website']);
   }
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


?>
<!-- Footer -->
<footer id="footer" class="footer wow fadeIn">
   <!-- Top Arrow -->
   <div class="top-arrow">
      <a href="#header" class="btn"><i class="fa fa-angle-up"></i></a>
   </div>
   <!--/ End Top Arrow -->
   <!-- Footer Top -->
   <div class="footer-top">
      <div class="container">
         <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
               <!-- About Widget -->
               <div class="single-widget about">
                  <h2><?php echo !empty($titleFooter1) ? $titleFooter1 : false ?></h2>
                  <?php echo !empty($contentFooter1) ? html_entity_decode($contentFooter1) : false ?>
                  <ul class="list">
                     <li>
                        <i class="fa fa-map-marker"></i>Address: <?php echo !empty($address) ? $address : false ?>
                     </li>
                     <li>
                        <i class="fa fa-headphones"></i>Phone: <?php echo !empty($hotlline) ? $hotlline : false ?>
                     </li>
                     <li>
                        <i class="fa fa-envelope"></i>Email:<a
                           href="mailto:<?php echo !empty($email) ? $email : false ?>"><?php echo !empty($email) ? $email : false ?></a>
                     </li>
                  </ul>
               </div>
               <!--/ End About Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Links Widget -->
               <div class="single-widget links">
                  <h2><?php echo !empty($arrFooter2['footer_2_title']) ? $arrFooter2['footer_2_title'] : false ?></h2>
                  <ul class="list">
                     <?php 
                        if(!empty($arrQuickLinks)):
                           foreach($arrQuickLinks as $item):
                     ?>
                     <li>
                        <a
                           href="<?php echo !empty($item['footer_2_qick_link']) ? $item['footer_2_qick_link'] : false ?>"><i
                              class="fa fa-caret-right"></i><?php echo !empty($item['footer_2_qick_link_content']) ? $item['footer_2_qick_link_content'] : false ?></a>
                     </li>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </ul>
               </div>
               <!--/ End Links Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Twitter Widget -->
               <div class="single-widget twitter">
                  <h2><?php echo !empty($titleFooter3) ? $titleFooter3 : false ?></h2>
                  <a class="twitter-timeline" data-lang="en" data-height="300" data-theme="dark"
                     href="<?php echo $linkTwitter ?>?ref_src=twsrc%5Etfw">Tweets by <?php echo $twitterFooter3 ?></a>
                  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
               </div>
               <!--/ End Twitter Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Newsletter Widget -->
               <div class="single-widget newsletter">
                  <h2><?php echo !empty($titleFooter4) ? $titleFooter4 : false ?></h2>
                  <?php echo !empty($contentFooter4) ? html_entity_decode($contentFooter4) : false ?>
                  <?php getMsg($message, $msgType) ?>
                  <form action='post'>
                     <input placeholder="Your Name" name="fullname" type="text"
                        value="<?php echo form_infor('fullname', $old) ?>">
                     <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>S
                     <input placeholder="your email" nam="email" type="email"
                        value="<?php echo form_infor('email', $old) ?>">
                     <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                     <button type="submit" class="button primary">
                        Subscribe Now!
                     </button>
                  </form>
               </div>
               <!--/ End Newsletter Widget -->
            </div>
         </div>
      </div>
   </div>
   <!--/ End Footer Top -->
   <!-- Footer Bottom -->
   <div class="footer-bottom">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="bottom-top">
                  <!-- Social -->
                  <ul class="social">
                     <li>
                        <a href="<?php echo !empty($linkFacebook) ? $linkFacebook : false ?>"><i
                              class="fa fa-facebook"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo !empty($linkTwitter) ? $linkTwitter : false ?>"><i
                              class="fa fa-twitter"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo !empty($linkLinkedin) ? $linkLinkedin : false ?>"><i
                              class="fa fa-linkedin"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo !empty($linkBehance) ? $linkBehance : false ?>"><i
                              class="fa fa-behance"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo !empty($linkYoutube) ? $linkYoutube : false ?>"><i
                              class="fa fa-youtube"></i></a>
                     </li>
                  </ul>
                  <!--/ End Social -->
                  <!-- Copyright -->
                  <div class="copyright">
                     <?php echo !empty($copyrightContent) ? html_entity_decode($copyrightContent) : false ?>
                  </div>
                  <!--/ End Copyright -->
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--/ End Footer Bottom -->
</footer>
<!--/ End footer -->
<?php 
   foot();
?>
</body>

</html>