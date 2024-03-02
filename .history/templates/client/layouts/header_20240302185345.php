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

   <!-- Start Header -->
   <header id="header" class="header">
      <!-- Topbar -->
      <div class="topbar">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-12">
                  <!-- Contact -->
                  <ul class="contact">
                     <li><i class="fa fa-headphones"></i><?php echo getOption('general_hotline')?></li>
                     <li>
                        <i class="fa fa-envelope"></i>
                        <a
                           href="mailto:<?php echo getOption('general_email')?>"><?php echo getOption('general_email')?></a>
                     </li>
                     <li><i class="fa fa-clock-o"></i>Opening: <?php echo getOption('header_time')?></li>
                  </ul>
                  <!--/ End Contact -->
               </div>
               <div class="col-lg-6 col-12">
                  <div class="topbar-right">
                     <!-- Search Form -->
                     <div class="search-form active">
                        <a class="icon" href="#"><i class="fa fa-search"></i></a>
                        <form class="form" action="#">
                           <input placeholder="<?php echo getOption("header_placeholder_search") ?>..." type="search" />
                        </form>
                     </div>
                     <!--/ End Search Form -->
                     <!-- Social -->
                     <ul class="social">
                        <li>
                           <a href="<?php echo getOption("general_twitter") ?>" target="blank"><i
                                 class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                           <a href="<?php echo getOption("general_facebook") ?>" target="blank"><i
                                 class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                           <a href="<?php echo getOption("general_linkedin") ?>" target="blank"><i
                                 class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                           <a href="<?php echo getOption("general_behance") ?>" target="blank"><i
                                 class="fa fa-behance"></i></a>
                        </li>
                        <li>
                           <a href="<?php echo getOption("general_youtube") ?>" target="blank"><i
                                 class="fa fa-youtube"></i></a>
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
                     <a href="<?php echo _WEB_HOST_ROOT ?>">
                        <?php if(!empty(getOption('general_logo'))): ?>
                        <img src="<?php echo getOption('general_logo')?>" alt="logo" />
                        <?php else: ?>
                        <h1 class="mt-2"><?php echo getOption('general_name_site') ?></h1>
                        <?php endif; ?>
                     </a>
                  </div>
                  <div class="link">
                     <a href="<?php echo _WEB_HOST_ROOT ?>"><?php echo customNameSite() ?></a>
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
                           <li class="active"><a href="<?php echo _WEB_HOST_ROOT ?>">Home</a></li>
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
                           <li><a href="blog.html">Blogs</a></li>
                           <li><a href="contact.html">Contact</a></li>
                        </ul>
                     </nav>
                     <!-- Button -->
                     <div class="button">
                        <a href="<?php echo !empty(getOption('header_quote_link')) ? getOption('header_quote_link') : "#" ?>"
                           class="btn"><?php echo !empty(getOption('header_quote_text')) ? getOption('header_quote_text') : "get a quote"?></a>
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