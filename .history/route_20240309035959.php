<?php 
   $route['/'] = 'index.php?module=home';  

   $route['bai-viet'] = 'index.php?module=blogs';  
   $route['bai-viet/.+-(.+)'] = 'index.php?module=blogs&action=detail&id=$1';  

   $route['dich-vu'] = 'index.php?module=services';  
   $route['dich-vu/.+-(.+).html'] = 'index.php?module=services&action=detail&id=$1';  

   $route['du-an'] = 'index.php?module=portfoilos';  
   $route['du-an/.+-(.+).html'] = 'index.php?module=portfoilos&action=detail&id=$1';  

   $route['gioi-thieu/chung-toi.html'] = 'index.php?module=pages&action=about';  
   $route['gioi-thieu/doi-ngu.html'] = 'index.php?module=pages&action=team';  
?>