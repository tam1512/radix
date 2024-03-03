<?php 
   $titlePage = getOption('page_contact_title_page');
   $titleBg = getOption('page_contact_title-bg');
   $title = getOption('page_contact_title');
   $content = getOption('page_contact_content');
   $jsonMessageType = getOption('page_contact_message_type');
   $arrMessageType = json_decode($jsonMessageType, true);

   $address = getOption('general_address');
   $hotline = getOption('general_hotline');
   $email = getOption('general_email');

   $facebook = getOption('general_facebook');
   $twitter = getOption('general_twitter');
   $linkedin = getOption('general_linkedin');
   $behance = getOption('general_behance');

   $isPage = false;
   if(empty($data)) {
      $data = [
         'title' => $titlePage,
         'name' => 'Contact'
      ];
      $isPage = true;

      layout('header', 'client', $data);
      layout('breadcrumb', 'client', $data);
   }
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
                                          if(!empty($arrMessageType)):
                                             foreach($arrMessageType as $item):
                                       ?>
                                       <option class="option" value="<?php echo $item ?>"><?php echo $item ?></option>
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
                           <li class="active"><a href="#"><i class="fa fa-facebook"></i>Like Us facebook</a></li>
                           <li><a href="#"><i class="fa fa-twitter"></i>Follow Us twitter</a></li>
                           <li><a href="#"><i class="fa fa-google-plus"></i>Follow Us google-plus</a></li>
                           <li><a href="#"><i class="fa fa-linkedin"></i>Follow Us linkedin</a></li>
                           <li><a href="#"><i class="fa fa-behance"></i>Follow Us behance</a></li>
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
   if($isPage) {
      require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
      layout('footer', 'client', $data);
   }
?>