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
    $isDetail = true;
    $isDuplicate = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'services', 'lists');
    $isEdit = checkPermission($permissionData, 'services', 'edit');
    $isDelete = checkPermission($permissionData, 'services', 'delete');
    $isDetail= checkPermission($permissionData, 'services', 'detail');
    $isDuplicate = checkPermission($permissionData, 'services', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý dịch vụ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
   $data = [
      'title' => 'Danh sách dịch vụ'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);


   $listAllUsers = getRaw("SELECT id, fullname, email FROM users ORDER BY create_at DESC");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      $filter .= " WHERE name LIKE '%$keyword%'";   
   }

   if(!empty(getBody()["user_id"])) {
      $userId = trim(getBody()["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator user_id = $userId"; 
   }
}

// Xử lý phân trang

// Số lượng dịch vụ
$countRowServices = getRows("SELECT id FROM services $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$serviceOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowServices/$serviceOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * serviceOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $serviceOnPage;
$listserviceOnPage = getRaw("SELECT services.id, name, icon, users.fullname, services.create_at, user_id FROM services INNER JOIN users ON services.user_id = users.id $filter ORDER BY services.create_at DESC LIMIT $offset, $serviceOnPage");



//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=services', '', $queryStr);
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
      <form action="" method="get">
         <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
               <div class="form-group">
                  <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Chọn người đăng" data-width="100%">
                     <option value="0">Chọn người đăng</option>
                     <?php 
                        if(!empty($listAllUsers)):
                           foreach($listAllUsers as $user):
                     ?>
                     <option value="<?php echo $user['id'] ?>"
                        <?php echo (!empty($userId) && $user['id'] == $userId) ? 'selected' : false ?>>
                        <?php echo $user['fullname'].'('.$user['email'].')' ?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-6">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên dịch vụ..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-3">
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="services">
      </form>
      <br>
      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="10%">Ảnh</th>
               <th width="25%">Tên dịch vụ</th>
               <th width="15%">Đăng bởi</th>
               <th width="15%">Thời gian</th>
               <?php if($isDetail): ?>
               <th width="10%">Xem</th>
               <?php endif; if($isEdit): ?>
               <th width="10%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="10%">Xóa</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listserviceOnPage)):
                  $count = 0;
                  foreach($listserviceOnPage as $service):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <?php
                   echo isIcon($service['icon']) ? isIcon($service['icon']) : '<img src="'.$service['icon'].'" alt="img_service" width="80%">' 
                   ?>
               </td>
               <td>
                  <?php echo $service['name'] ?>
                  <?php if($isDuplicate): ?>
                  <a href="<?php echo getLinkAdmin('services', 'duplicate', ['id' => $service['id']]) ?>"
                     class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                  <?php endif; ?>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('services', "", ['user_id'=>$service['user_id']])?>"><?php echo $service['fullname']  ?></a>
               </td>
               <td><?php echo getDateFormat($service["create_at"], 'd/m/Y H:i:s') ?></td>
               <?php if($isDetail): ?>
               <td class="text-center"><a class="btn btn-success" target="_blank"
                     href="<?php echo getLinkModule('services', $service['id']) ?>">Xem</a></td>
               <?php endif; if($isEdit): ?>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('services', 'edit', ['id' => $service['id']]) ?>"><i
                        class="fa fa-edit"></i></a>
               </td>
               <?php endif; if($isDelete): ?>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('services', 'delete', ['id' => $service['id']]) ?>"><i
                        class="fa fa-trash"></i></a>
               </td>
               <?php endif; ?>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="8" class="text-center alert alert-danger">Không có dịch vụ</td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <nav aria-label="Page navigation users">
         <ul class="pagination pagination-sm justify-content-end <?php echo ($numPage == 1) ? 'd-none' : false ?>">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo _WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=services'.$queryStr.'&page='.$numPage;
            ?>">
                  Trang cuối
               </a>
            </li>
         </ul>
      </nav>
   </div><!-- /.container-fluid -->
</section>
<?php
   layout('footer', 'admin', $data);
?>