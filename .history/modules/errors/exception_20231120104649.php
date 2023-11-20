<?php 
   if(!defined('_INCODE')) die('Access denied...'); 
   layout('header', 'admin', $data);
?>
<div class="error-wrap">
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
<?php
  layout('footer', 'admin', $data);
 ?>