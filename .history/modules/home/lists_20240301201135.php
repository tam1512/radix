<?php
   $data = [
      'title' => 'Radix &#8739; Creative Business & Consulting HTML5 Template'
   ];

   layout('header', 'client', $data);
   
   require_once('contents/slider.php');
   require_once('contents/about.php');
   require_once('contents/services.php');
   require_once('contents/facts.php');
   require_once('contents/portfolios.php');
   require_once('contents/callToAction.php');
   require_once('contents/blogs.php');
   require_once('contents/partners.php');

   layout('footer', 'client', $data);
?>