<?php 
   //file lấy ra liên kết cố định

   function getPrefixLink($module='') {
      $prefixArr = [
         'services' => 'dich-vu',
         'pages' => 'gioi-thieu',
         'portfolios' => 'du-an',
         'blog_categories' => 'danh-muc-bai-viet',
         'blogs' => 'bai-viet',
      ];
      if(!empty($prefixArr[$module])) {
         return $prefixArr[$module];
      }

      return false;
   }

?>