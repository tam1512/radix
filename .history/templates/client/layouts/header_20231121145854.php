<?php 
   if(!defined('_INCODE')) die('Access denied...');
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
   <!-- Meta tag -->
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <meta name="Radix" content="Responsive Multipurpose Business Template">
   <meta name='copyright' content='Radix'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Title Tag -->
   <title><?php echo (!empty($data['title'])) ? $data['title'] : false ?></title>

   <!-- Favicon -->
   <link rel="icon" type="image/png" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>favicon.png">

   <?php
      head();
   ?>
</head>

<body>
   <!-- Preloader -->
   <div class="preloader">
      <div class="preloader-inner">
         <div class="single-loader one"></div>
         <div class="single-loader two"></div>
         <div class="single-loader three"></div>
         <div class="single-loader four"></div>
         <div class="single-loader five"></div>
         <div class="single-loader six"></div>
         <div class="single-loader seven"></div>
         <div class="single-loader eight"></div>
         <div class="single-loader nine"></div>
      </div>
   </div>
   <!-- End Preloader -->

   <!-- Get Pro Button -->
   <ul class="pro-features">
      <a class="get-pro" href="#">Get Pro</a>
      <li class="title">Pro Version Some Features</li>
      <li>Multipage & Onepage Homepage</li>
      <li>26+ HTML5 pages</li>
      <li>All Premium Features</li>
      <li>Documentation Included</li>
      <li>6+ Month Dedicated Support!</li>
      <div class="button">
         <a href="https://www.codeglim.com/downloads/radix-multipurpose-business-consulting-template/" target="_blank"
            class="btn">Buy Pro Version</a>
         <a href="https://www.codeglim.com/downloads/radix-multipurpose-business-consulting-template/" target="_blank"
            class="btn">View Details</a>
      </div>
   </ul>

   <!-- Start Header -->
   <header id="header" class="header">
      <!-- Topbar -->
      <div class="topbar">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-12">
                  <!-- Contact -->
                  <ul class="contact">
                     <li><i class="fa fa-headphones"></i> +(123) 45678910</li>
                     <li>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:info@yourmail.com">info@yourmail.com</a>
                     </li>
                     <li><i class="fa fa-clock-o"></i>Opening: 09am-5pm</li>
                  </ul>
                  <!--/ End Contact -->
               </div>
               <div class="col-lg-6 col-12">
                  <div class="topbar-right">
                     <!-- Search Form -->
                     <div class="search-form active">
                        <a class="icon" href="#"><i class="fa fa-search"></i></a>
                        <form class="form" action="#">
                           <input placeholder="Search & Enter" type="search" />
                        </form>
                     </div>
                     <!--/ End Search Form -->
                     <!-- Social -->
                     <ul class="social">
                        <li>
                           <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                           <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                           <a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                           <a href="#"><i class="fa fa-behance"></i></a>
                        </li>
                        <li>
                           <a href="#"><i class="fa fa-youtube"></i></a>
                        </li>
                     </ul>
                     <!--/ End Social -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--/ End Topbar -->
      <!-- Middle Bar -->
      <div class="middle-bar">
         <div class="container">
            <div class="row">
               <div class="col-lg-2 col-12">
                  <!-- Logo -->
                  <div class="logo">
                     <a href="index.html"><img src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/' ?>logo.png"
                           alt="logo" /></a>
                  </div>
                  <div class="link">
                     <a href="index.html"><span>R</span>adix</a>
                  </div>
                  <!--/ End Logo -->
                  <button class="mobile-arrow"><i class="fa fa-bars"></i></button>
                  <div class="mobile-menu"></div>
               </div>
               <div class="col-lg-10 col-12">
                  <!-- Main Menu -->
                  <div class="mainmenu">
                     <nav class="navigation">
                        <ul class="nav menu">
                           <li class="active"><a href="index.html">Home</a></li>
                           <li>
                              <a href="#">Pages<i class="fa fa-caret-down"></i></a>
                              <ul class="dropdown">
                                 <li><a href="about-us.html">About Us</a></li>
                                 <li><a href="team.html">Our Team</a></li>
                                 <li><a href="pricing.html">Pricing</a></li>
                              </ul>
                           </li>
                           <li><a href="services.html">Services</a></li>
                           <li><a href="portfolio.html">Portfolio</a></li>
                           <li>
                              <a href="#">Blogs<i class="fa fa-caret-down"></i></a>
                              <ul class="dropdown">
                                 <li><a href="blog.html">Blog layout</a></li>
                                 <li><a href="blog-single.html">Blog Single</a></li>
                              </ul>
                           </li>
                           <li><a href="contact.html">Contact</a></li>
                        </ul>
                     </nav>
                     <!-- Button -->
                     <div class="button">
                        <a href="contact.html" class="btn">Get a quote</a>
                     </div>
                     <!--/ End Button -->
                  </div>
                  <!--/ End Main Menu -->
               </div>
            </div>
         </div>
      </div>
      <!--/ End Middle Bar -->
   </header>
   <!--/ End Header -->