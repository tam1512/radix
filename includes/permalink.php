<?php 
   //file lấy ra liên kết cố định

   function getPrefixLink($module='') {
      if($module=='services') {
         return 'dich-vu';
      }
      return false;
   }

?>