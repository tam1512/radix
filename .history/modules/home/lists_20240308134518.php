<?php
   $data = [
      'title' => 'Radix &#8739; Creative Business & Consulting HTML5 Template',
      'home' => true
   ];
   
   layout('header', 'client', $data);
   
   require_once('contents/slider.php');
   require_once(_WEB_PATH_ROOT.'/modules/pages/about.php');
   require_once(_WEB_PATH_ROOT.'/modules/services/lists.php');
   require_once('contents/facts.php');
   require_once(_WEB_PATH_ROOT.'/modules/portfolios/lists.php');
   require_once('contents/callToAction.php');
   require_once(_WEB_PATH_ROOT.'/modules/blogs/lists.php');
   require_once('contents/partners.php');

   layout('footer', 'client', $data);
?>