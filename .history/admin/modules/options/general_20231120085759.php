<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập chung"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   updateOptions();

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">

         <?php 
            // getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <?php echo renderOptions('general') ?>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Cập nhật</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
   layout('footer', 'admin', $data);
?>