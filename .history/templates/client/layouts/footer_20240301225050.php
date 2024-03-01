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
                        <i class="fa fa-map-marker"></i>Address: <?php echo  ?>
                     </li>
                     <li>
                        <i class="fa fa-headphones"></i>Phone: +(123) 45678 910
                     </li>
                     <li>
                        <i class="fa fa-headphones"></i>Email:<a
                           href="mailto:info@youremail.com">Info@yourwebsite.com</a>
                     </li>
                  </ul>
               </div>
               <!--/ End About Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Links Widget -->
               <div class="single-widget links">
                  <h2>Quick Links</h2>
                  <ul class="list">
                     <li>
                        <a href="about-us.html"><i class="fa fa-caret-right"></i>About Our Company</a>
                     </li>
                     <li>
                        <a href="services.html"><i class="fa fa-caret-right"></i>Our Latest services</a>
                     </li>
                     <li>
                        <a href="projects-masonry.html"><i class="fa fa-caret-right"></i>Our Recent Project</a>
                     </li>
                     <li>
                        <a href="blogs-right-sidebar.html"><i class="fa fa-caret-right"></i>Latest Blog</a>
                     </li>
                     <li>
                        <a href="contact.html"><i class="fa fa-caret-right"></i>Help Desk</a>
                     </li>
                     <li>
                        <a href="contact.html"><i class="fa fa-caret-right"></i>Contact With Us</a>
                     </li>
                  </ul>
               </div>
               <!--/ End Links Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Twitter Widget -->
               <div class="single-widget twitter">
                  <h2>Recent Tweets</h2>
                  <div class="single-tweet">
                     <i class="fa fa-twitter"></i>
                     <p>
                        <a href="#">@Radix</a>Mauris sagittis nibh et nibh commodo
                        vehicula. Praesent blandit nulla nec tristique egestas.
                        Integer in volutpat turpis
                     </p>
                  </div>
                  <div class="single-tweet">
                     <i class="fa fa-twitter"></i>
                     <p>
                        <a href="#">@Radix</a>Maecenas vulputate, dui eget varius
                        sagittis, justo nunc efficitur sem, id vestibulum
                     </p>
                  </div>
                  <div class="single-tweet">
                     <i class="fa fa-twitter"></i>
                     <p>
                        <a href="#">@Radix</a>Praesent facilisis tortor nec diam
                        suscipit condimentum
                     </p>
                  </div>
               </div>
               <!--/ End Twitter Widget -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
               <!-- Newsletter Widget -->
               <div class="single-widget newsletter">
                  <h2>Newsletter</h2>
                  <p>
                     consectetur adipiscing elit. Vestibulum vel sapien et lacus
                     tempus varius. In finibus lorem vel.
                  </p>
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