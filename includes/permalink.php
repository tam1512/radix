<?php 
   //file lấy ra liên kết cố định

   function getPrefixLink($module='') {
      $prefixArr = [
         'services' => 'dich-vu',
         'pages' => 'trang',
         'portfolios' => 'du-an',
         'blog_categories' => 'danh-muc-blog'
      ];
      if(!empty($prefixArr[$module])) {
         return $prefixArr[$module];
      }

      return false;
   }

?>