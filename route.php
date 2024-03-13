<?php 
   $route['/'] = 'index.php?module=home';  

   $route['bai-viet.html'] = 'index.php?module=blogs';  
   $route['bai-viet/danh-muc-bai-viet/.+-(.+).html'] = 'index.php?module=blogs&action=category&id=$1';  
   $route['bai-viet/.+-(.+).html'] = 'index.php?module=blogs&action=detail&id=$1';  

   $route['dich-vu.html'] = 'index.php?module=services';  
   $route['dich-vu/.+-(.+).html'] = 'index.php?module=services&action=detail&id=$1';

   $route['du-an.html'] = 'index.php?module=portfolios';  
   $route['du-an/.+-(.+).html'] = 'index.php?module=portfolios&action=detail&id=$1';  

   $route['gioi-thieu.html'] = 'index.php?module=pages&action=about';  
   $route['gioi-thieu/chung-toi.html'] = 'index.php?module=pages&action=about';  
   $route['gioi-thieu/doi-ngu.html'] = 'index.php?module=pages&action=team';  
   
   $route['lien-he.html'] = 'index.php?module=contact';  

   $route['tim-kiem.html'] = 'index.php?module=search';  

   $route['thong-tin/.+-(.+).html'] = 'index.php?module=page&action=detail&id=$1';  
?>