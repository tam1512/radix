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
                        <i class="fa fa-headphones"></i>Email:<a
                           href="mailto:<?php echo !empty($email) ? $email : false ?>"><?php echo !empty($email) ? $email : false ?></a>
                     </li>
                  </ul>
               </div>
               <!--/ End About Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Links Widget -->
               <div class="single-widget links">
                  <h2><?php echo !empty($titleFooter2) ? $titleFooter2 : false ?></h2>
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
                  <form>
                     <input placeholder="Your Name" type="text" />
                     <input placeholder="your email" type="email" />
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
                        <a href="#"><i class="fa fa-facebook"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-behance"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-youtube"></i></a>
                     </li>
                  </ul>
                  <!--/ End Social -->
                  <!-- Copyright -->
                  <div class="copyright">
                     <p>
                        &copy; 2020 All Right Reserved. Design & Development By
                        <a target="_blank" href="http://themelamp.com">ThemeLamp.com</a>, Theme Provided By
                        <a target="_blank" href="https://codeglim.com">CodeGlim.com</a>
                     </p>
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