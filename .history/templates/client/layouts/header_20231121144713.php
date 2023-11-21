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
   <link rel="icon" type="image/png" href="images/favicon.png">

   <?php
      head();
   ?>
</head>