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
    $isEdit = true;
    $isDelete = true;
    $isAdd = true;
    $isDuplicate = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'contact_types', 'lists');
    $isEdit = checkPermission($permissionData, 'contact_types', 'edit');
    $isDelete = checkPermission($permissionData, 'contact_types', 'delete');
    $isAdd = checkPermission($permissionData, 'contact_types', 'add');
    $isDuplicate = checkPermission($permissionData, 'contact_types', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Loại liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
   $data = [
      'title' => 'Phòng ban liên hệ'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

// Xử lý tìm kiếm
$filter = '';
$body = getBody('get');
if(!empty($body["keyword"])) {
   $keyword = trim($body["keyword"]);
   $filter .= " WHERE name LIKE '%$keyword%'";   
}

if(!empty($body["view"])) {
   $view = $body["view"];
}

if(!empty($body["id"])) {
   $id = $body["id"];
}


// Xử lý phân trang

// Số lượng dịch vụ
$countRowContactTypes = getRows("SELECT id FROM contact_types $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$typeOnPage = _USER_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowContactTypes/$typeOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * departmentOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $typeOnPage;
$listContactTypesOnPage = getRaw("SELECT id, name, create_at, user_id, (SELECT count(contacts.id) FROM contacts WHERE contacts.type_id = contact_types.id) as contacts_count FROM contact_types $filter ORDER BY create_at DESC LIMIT $offset, $typeOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=contact_types', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '&'.$queryStr;
   }
} 

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <?php 
         getMsg($msg, $msgType);
      ?>
      <div class="row">
         <?php if($isAdd || $isEdit): ?>
         <div class="col-lg-6 col-md-6 col-12">
            <?php
               if(!empty($view) && !empty($id) && $isEdit) {
                  require_once("$view.php");
               } else if($isAdd) {
                  require_once('add.php');
               }  
            ?>
            <br>
            <hr>
         </div>
         <?php endif; ?>
         <div class="<?php echo (!$isAdd && !$isEdit) ? 'col-12' : 'col-lg-6 col-md-6 col-12' ?>">
            <form action="" method="get">
               <div class="row">
                  <h4 class="col-12">Danh sách phòng ban</h4>
                  <div class="col-8">
                     <input type="text" class="form-control" name="keyword" placeholder="Nhập tên phòng ban..."
                        value="<?php echo !empty($keyword) ? $keyword : false ?>">
                  </div>
                  <div class="col-4">
                     <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  </div>
                  <hr>
               </div>
               <input type="hidden" name="module" value="contact_types">
            </form>
            <hr>
            <table class="table table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="5%">STT</th>
                     <th width="40%">Tên</th>
                     <th width="15%">Thời gian</th>
                     <?php if($isEdit): ?>
                     <th width="5%">Sửa</th>
                     <?php endif; if($isDelete): ?>
                     <th width="5%">Xóa</th>
                     <?php endif; ?>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     if(!empty($listContactTypesOnPage)):
                        $count = 0;
                        foreach($listContactTypesOnPage as $type):
                           $count++;
                  ?>
                  <tr>
                     <td><?php echo $count ?></td>
                     <td>
                        <a
                           href="<?php echo $isEdit ? getLinkAdmin('contact_types', '', ['id' => $type['id'], 'view' => 'edit']) : '#' ?>">
                           <?php echo $type['name']?>
                        </a>
                        <p><?php echo '('.$type['contacts_count'].')'?></p>
                        <?php if($isDuplicate): ?>
                        <a href="<?php echo getLinkAdmin('contact_types', 'duplicate', ['id' => $type['id']]) ?>"
                           class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                        <?php endif; ?>
                     </td>
                     <td><?php echo getDateFormat($type["create_at"], 'd/m/Y H:i:s') ?></td>
                     <?php if($isEdit): ?>
                     <td class="text-center">
                        <a class="btn btn-warning"
                           href="<?php echo getLinkAdmin('contact_types', '', ['id' => $type['id'], 'view' => 'edit']) ?>"><i
                              class="fa fa-edit"></i></a>
                     </td>
                     <?php endif; if($isDelete): ?>
                     <td class="text-center">
                        <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                           href="<?php echo getLinkAdmin('contact_types', 'delete', ['id' => $type['id']]) ?>"><i
                              class="fa fa-trash"></i></a>
                     </td>
                     <?php endif; ?>
                  </tr>
                  <?php 
                     endforeach; else:
                  ?>
                  <tr>
                     <td colspan="6" class="text-center alert alert-danger">Không có phòng ban</td>
                  </tr>
                  <?php endif; ?>
               </tbody>
            </table>
            <nav aria-label="Page navigation users">
               <ul
                  class="pagination pagination-sm justify-content-end <?php echo ($numPage == 1 || $numPage == 0) ? 'd-none' : false ?>">
                  <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
                     <a class="page-link" href="
                        <?php     
                           if($page <= 1) {
                              $prevPage = 1;
                           } else {
                              $prevPage = $page - 1;
                           }
                           echo _WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$prevPage;
                        ?>">
                        Trước
                     </a>
                  </li>

                  <?php 
                     if(!empty($numPage)) {
                        // Tính toán số phân trang bắt đầu để giới hạn trong limit page
                        $begin = $page - 2;
                        if($begin < 1) {
                           $begin = 1;
                        }
                        $end = $begin + $limitPagination - 1;
                        if($end >= $numPage) {
                           $end = $numPage;
                           $begin = $end - $limitPagination + 1;
                        }

                        if($numPage <= $limitPagination) {
                           for($i = 1; $i <= $numPage; $i++) {
                              if($page == $i) {
                                 echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                              } else {
                                 echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                              }
                           }
                        } else {
                           for($i = $begin; $i <= $end; $i++) {
                              if($page == $i) {
                                 echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                              } else {
                                 echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                              }
                           }
                        }
                     }   
                  ?>

                  <li class="page-item">
                     <a class="page-link" href="
                        <?php 
                           if($page >= $numPage) {
                              $nextPage = 1;
                           } else {
                              $nextPage = $page + 1;
                           }
                           echo _WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$nextPage;
                        ?>">
                        Sau
                     </a>
                  </li>
                  <li class="page-item">
                     <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
                        <?php 
                           echo _WEB_HOST_ROOT_ADMIN.'?module=contact_types'.$queryStr.'&page='.$numPage;
                        ?>">
                        Trang cuối
                     </a>
                  </li>
               </ul>
            </nav>
         </div>
      </div>
      <br>

   </div><!-- /.container-fluid -->
</section>
<?php
   layout('footer', 'admin', $data);
?>