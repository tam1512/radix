<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập header"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   updateOptions();

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');
?>

<div class="container">
   <?php 
            getMsg($msg, $msgType);
         ?>

   <form action="" method="post">
      <div class="row">
         <?php echo renderOptions('header', 2) ?>
      </div>
      <button class="btn btn-primary" type="submit">Cập nhật</button>
      <hr>
   </form>
</div>

<?php
   layout('footer', 'admin', $data);
?>