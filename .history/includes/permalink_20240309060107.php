<?php 
   //file lấy ra liên kết cố định
   function getLinkModule($module, $id, $table = null, $field = null, $params=[]) {
      $prefixLink = getPrefixLink($module);
      if(empty($table)) {
         $table = $module;
      }

      if(empty($field)) {
         $field = 'slug';
      }

      $url = "";

      $dataQuery = firstRaw("SELECT $field FROM $table WHERE id = $id");
      if(!empty($dataQuery[$field]) && !empty($prefixLink)) {
         $url =  _WEB_HOST_ROOT."/$prefixLink/".$dataQuery[$field]."-$id.html";
      }

      if(!empty($params)) {
         $paramString = http_build_query($params);
         $url.="/?$paramString";
       } 
      return  $url;  
   }
   function getPrefixLink($module='') {
      $prefixArr = [
         'services' => 'dich-vu',
         'pages' => 'thong-tin',
         'portfolios' => 'du-an',
         'blog_categories' => 'bai-viet/danh-muc-bai-viet',
         'blogs' => 'bai-viet',
      ];
      if(!empty($prefixArr[$module])) {
         return $prefixArr[$module];
      }

      return false;
   }

?>