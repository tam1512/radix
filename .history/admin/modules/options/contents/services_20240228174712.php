<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

   updateOptions();
?>

<div class="container">
   <form action="" method="post">
      <div class="row">
         <?php echo renderOptions('general') ?>
      </div>
      <button class="btn btn-primary" type="submit">Cập nhật</button>
      <hr>
   </form>
</div>
<div class="services px-1">
   <h3 class="text-center">Thiết lập dịch vụ</h3>
   <div class="card border shadow-none mb-2">
      <div class="card-body">
         <!-- content -->
         <div class="d-flex align-items-start border-bottom pb-3">
            <div class="flex-grow-1 align-self-center overflow-hidden">
               <div class="row">
                  <?php echo renderOptions('general') ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<hr>