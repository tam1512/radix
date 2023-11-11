<?php if(!defined('_INCODE')) die('Access denied...'); ?>
<div class="error-wrap" style="width: 60%; margin: 20px auto; padding: 30px 40px; text-align: center">
   <h3 class='text-uppercase'>Vui lòng kiểm tra và xử lý các lỗi sau</h3>
   <hr>
   <p style="color:red;">
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