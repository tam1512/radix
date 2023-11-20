<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập chung"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">

         <?php 
            // getMsg($msg, $msgType);
         ?>

         <!-- <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="name">Tên nhóm người dùng</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên nhóm người dùng..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="permission">Phân quyền</label>
                     <input type="text" id="permission" name="permission" class="form-control"
                        placeholder="Phân quyền..." value="<?php echo old('permission', $old) ?>">
                     <?php echo form_error('permission', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Thêm</button>
            <hr>
         </form> -->
      </div>
   </div>
</div>

<?php
   layout('footer', 'admin', $data);
?>