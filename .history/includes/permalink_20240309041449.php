<?php 
   //file lấy ra liên kết cố định
   function getLinkModule($module, $id, $table = null, $field = null) {
      $prefixLink = getPrefixLink($module);
      if(empty($table)) {
         $table = $module;
      }

      if(empty($field)) {
         $field = 'slug';
      }

      $dataQuery = firstRaw("SELECT $field FROM $table WHERE id = $id");
      if(!empty($dataQuery[$field]) && !empty($prefixLink)) {
         return _WEB_HOST_ROOT."/$prefixLink/".$dataQuery[$field]."-$id.html";
      }
      return false;
   }
   function getPrefixLink($module='') {
      $prefixArr = [
         'services' => 'dich-vu',
         'pages' => 'thong-tin',
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