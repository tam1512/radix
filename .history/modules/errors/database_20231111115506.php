<?php if(!defined('_INCODE')) die('Access denied...'); ?>
<div class="error-wrap">
   <h3 class='text-uppercase'>Lỗi Cơ Sở Dữ Liệu</h3>
   <hr>
   <p>
      Code:
      <span style="color:red;"> <?php echo $e->getCode() ?> </span>
   </p>
   <p style="color:red;">
      <?php echo $e->getMessage() ?>
   </p>
   <p style="color:red;">
      <?php echo $e->getMessage() ?>
   </p>
   <p>
      File:
      <span style="color:red;"> <?php echo $e->getFile() ?> </span>
   </p>
   <p>
      Line:
      <span style="color:red;"> <?php echo $e->getLine() ?> </span>
   </p>
</div>