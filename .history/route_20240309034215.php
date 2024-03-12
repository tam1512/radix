<?php 
   $route['/'] = 'index.php?module=home';  
   $route['bai-viet'] = 'index.php?module=blogs';  
   $route['bai-viet/.+-(.+)'] = 'index.php?module=blogs&action=detail&id=$1';  
   $route['dich-vu/.+-(.+).html'] = 'index.php?module=services&action=detail&id=$1';  
?>