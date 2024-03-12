<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
if(!defined('_INCODE')) die('Access denied...');
if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;
if($isRoot) {
  $checkPermission = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'options', 'general');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập chung');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

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

<div class="container-fluid">

   <?php 
            getMsg($msg, $msgType);
         ?>

   <form action="" method="post">
      <div class="row">
         <?php echo renderOptions('general') ?>
      </div>
      <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
   </form>
   <br>
</div>

<?php
   layout('footer', 'admin', $data);
?>