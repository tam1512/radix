<?php 
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
  $checkPermission = checkPermission($permissionData, 'options', 'menu');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập Menu');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập Menu"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   if(isPost()) {
               
      $errors = [];

      $body = getBody('post');

      //page blogs
      if(isset($body['menu'])) {
         $updateStatus = update('options', ['opt_value' => $body['menu']], "opt_key = 'menu'");

         if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa menu thành công.');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
         redirect("admin/?module=options&action=menu");
      }
   }


   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');
?>
<form action="" method="post" id="frmEdit">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <div class="menu px-1">
      <h3 class="text-center"><?php echo getOption('menu', 'label') ?></h3>
      <div class="card border shadow-none mb-2">
         <div class="card-body">
            <!-- content -->
            <div class="d-flex align-items-start pb-3">
               <div class="flex-grow-1 align-self-center overflow-hidden">
                  <div class="row">
                     <div class="col-6">
                        <ul id="myEditor" class="sortableLists list-group">
                        </ul>
                     </div>
                     <div class="col-6">
                        <div class="card border-primary mb-3">
                           <div class="card-header bg-primary text-white">Tùy chỉnh thành phần menu</div>
                           <div class="card-body">
                              <div class="form-group">
                                 <label for="text">Text</label>
                                 <input type="text" class="form-control item-menu" name="text" id="text"
                                    placeholder="Text">
                              </div>
                              <div class="form-group">
                                 <label for="href">URL</label>
                                 <input type="text" class="form-control item-menu" id="href" name="href"
                                    placeholder="URL">
                              </div>
                              <div class="form-group">
                                 <label for="target">Target</label>
                                 <select name="target" id="target" class="form-control item-menu">
                                    <option value="_self">Self</option>
                                    <option value="_blank">Blank</option>
                                    <option value="_top">Top</option>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label for="title">Tooltip</label>
                                 <input type="text" name="title" class="form-control item-menu" id="title"
                                    placeholder="Tooltip">
                              </div>
                           </div>
                           <div class="card-footer">
                              <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i
                                    class="fas fa-sync-alt"></i> Update</button>
                              <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i>
                                 Add</button>
                           </div>
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary" id="save-menu">Lưu menu</button>
                     <input type="hidden" name="menu" id="json-menu">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<script type="text/javascript">
<?php 
      $menuJson = getOption('menu');
   ?>
var arrayJson = <?php echo !empty($menuJson) ? html_entity_decode($menuJson) : '[]' ?>;
</script>
<?php
   layout('footer', 'admin', $data);
?>