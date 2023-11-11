<?php if(!defined('_INCODE')) die('Access denied...'); ?>
<div class="error-wrap">
   <h3 class='text-uppercase'>Lỗi Cơ Sở Dữ Liệu</h3>
   <hr>
   Code:
   <?php echo $exception['error_code'] ?>
   </p>
   <?php echo $exception['error_message'] ?>
   </p>
   <p>
      File:
      <span style="color:red;"> <?php echo $exception['error_file'] ?> </span>
   </p>
   <p>
      Line:
      <span style="color:red;"> <?php echo $exception['error_line'] ?> </span>
   </p>
</div>