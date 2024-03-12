<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Hiển thị danh sách người dùng, phân trang, tìm kiếm
 */
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
   $checkPermission = checkPermission($permissionData, 'groups', 'permission');
}

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Nhóm người dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
 
$groupId = trim(getBody()['id']);
$defaultGroup = firstRaw("SELECT name, permission, root FROM groups WHERE id = $groupId");

if(isGet()) {
   if(!empty($groupId)) {
      setFlashData('defaultGroup', $defaultGroup);
   } else {
      redirect("admin/?module=groups");
   }
}

$data = [
   'title' => 'Phân Quyền: '.$defaultGroup['name']
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý phân Quyền
 $modules = getRaw("SELECT * FROM modules");

 if(isPost()) {
   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $groupId = trim($body['id']);

   $permission = !empty($body['permission']) ? $body['permission'] : false;


   if(empty($permission)) {
      $errors['permission']['required'] = "Chưa phân Quyền.";
   }
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'permission' => json_encode($permission),
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('groups', $dataUpdate, "id=$groupId");
      if($updateStatus) {
            setFlashData('msg', 'Phân Quyền người dùng thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=groups');
      
   } else {
      setFlashData('msg', $errors['permission']['required']);
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=groups&action=permission&id=$groupId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultGroup = getFlashData('defaultGroup');
if(!empty($defaultGroup)) {
   $old = $defaultGroup;
}
if(!empty($old['permission'])) {
   $permisstion = json_decode($old['permission'], true);
}
 ?>

<div class="container-fluid">
   <div class="row">
      <div class="col">
         <?php 
            getMsg($msg, $msgType);
         ?>
         <form action="" method="post">
            <table class="table table-bordered table-responsive permission-list">
               <tr>
                  <th>Module</th>
                  <th>Chức năng</th>
               </tr>
               <?php 
                  if(!empty($modules)): 
                     foreach($modules as $module):
               ?>
               <tr>
                  <td><?php echo $module['title'] ?></td>
                  <td>
                     <div class="row">
                        <?php 
                        $actions = json_decode($module['actions'], true);
                        if(!empty($actions)):
                           $count = 0;
                           foreach($actions as $key => $value):
                              $count++;
                     ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-center mb-3">
                           <input type="checkbox" name="<?php echo "permission[".$module['name']."][]" ?>"
                              id="<?php echo "permission[".$module['name']."][$key]" ?>" value="<?php echo $key ?>" <?php 
                           echo (!empty($permisstion[$module['name']]) && in_array($key, $permisstion[$module['name']])) || $defaultGroup['root'] == 1 ? "checked" : false 
                           ?>>
                           <label class="mb-0 ml-2" for="<?php echo "permission[".$module['name']."][$key]" ?>">
                              <?php echo $value ?>
                           </label>
                        </div>
                        <?php
                           endforeach;
                        endif;
                     ?>
                     </div>
                  </td>
               </tr>
               <?php 
                     endforeach;
                  endif;
               ?>
            </table>
            <input type="hidden" name="id" value="<?php echo $groupId ?>">
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a href="<?php echo getLinkPrevPage() ?>" class="btn btn-success" type="submit">Quay lại</a>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>