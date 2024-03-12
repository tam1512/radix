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
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'subscribe', 'lists');
    $isEdit = checkPermission($permissionData, 'subscribe', 'edit');
    $isDelete = checkPermission($permissionData, 'subscribe', 'delete');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý đăng ký');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
   $data = [
      'title' => 'Danh sách bình luận'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllUsers = getRaw("SELECT id, fullname, email FROM users ORDER BY create_at DESC");
   $listStatus = [
      '0' => [
         'value'=> 'Chưa xử lý',
         'type' => 'warning'
      ],
      '1' => [
         'value' => 'Đã xử lý',
         'type' => 'success'
      ]
   ];

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   $bodyGet = getBody('get');

   if(!empty($bodyGet["keyword"])) {
      $keyword = trim($bodyGet["keyword"]);
      $filter .= " WHERE subscribe.fullname LIKE '%$keyword%' AND subscribe.email LIKE '%$keyword%'";   
   }

   if(isset($bodyGet["status"]) && ($bodyGet["status"] == 0 || $bodyGet["status"] == 1)) {
      $status = trim($bodyGet["status"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator subscribe.status = $status"; 
   }
}

// Xử lý phân trang

// Số lượng bình luận
$countRowSubscribes = getRows("SELECT id FROM subscribe $filter");

// Số lượng bình luận muốn hiển thị trên 1 trang
$subscribeOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowSubscribes/$subscribeOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * subscribeOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $subscribeOnPage;

$listsubscribeOnPage = getRaw("SELECT * FROM subscribe $filter ORDER BY subscribe.create_at DESC LIMIT $offset, $subscribeOnPage");




//Xử lý query String
$queryStr = handleQueryString('subscribe', $page);


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
            <div class="col-4">
               <div class="form-group">
                  <select name="status" id="status" class="form-control">
                     <option value="">Chọn trạng thái</option>
                     <?php 
                        foreach($listStatus as $key=>$value){
                           $isSelect = false;
                           if(isset($status) && ($status == 0 || $status == 1)) {
                              $isSelect = $key == $status ? 'selected' : false;
                           }
                           echo '<option value="'.$key.'"'.$isSelect.'>'.$value['value'].'</option>';
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-6">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên bình luận..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-2">
               <button type="submit" class="btn btn-primary btn-blocl">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="subscribe">
      </form>
      <br>
      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="25%">Họ tên</th>
               <th width="30%">Email</th>
               <th width="10%">Trạng thái</th>
               <th width="10%">Thời gian</th>
               <?php if($isEdit || $isDelete): ?>
               <th width="5%">Hành động</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listsubscribeOnPage)):
                  $count = 0;
                  foreach($listsubscribeOnPage as $subscribe):
                     $count++;
                     $color = $subscribe['status'] == 0 ? 'rgb(133,201,232,0.5)' : false;
            ?>
            <tr style="background: <?php echo $color ?>">
               <td><?php echo $count ?></td>
               <td>
                  <?php echo $subscribe['fullname'] ?>
               </td>
               <td>
                  <?php echo $subscribe['email'] ?>
               </td>
               <td class="text-center">
                  <?php 
                     foreach($listStatus as $key=>$value) {
                           if($key == $subscribe['status']) {
                           echo '<button type="button" class="btn btn-'.$value['type'].'">'.$value['value'].'</button>';
                        }
                     }
                  ?>
               </td>
               <td><?php echo getDateFormat($subscribe["create_at"], 'd/m/Y H:i:s') ?></td>
               <?php if($isEdit || $isDelete): ?>
               <td class="text-center">
                  <?php if($isEdit): ?>
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('subscribe', 'edit', ['id' => $subscribe['id']]) ?>">
                     Sửa
                  </a>
                  <?php endif; if($isDelete): ?>
                  <a class="btn btn-danger mt-2" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('subscribe', 'delete', ['id' => $subscribe['id']]) ?>">
                     Xóa
                  </a>
                  <?php endif; ?>
               </td>
               <?php endif; ?>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="10" class="text-center alert alert-danger">Không có đăng ký nào</td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <nav aria-label="Page navigation users">
         <ul class="pagination pagination-sm justify-content-end <?php echo ($numPage <= 1) ? 'd-none' : false ?>">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
                  <?php     
                     if($page <= 1) {
                        $prevPage = 1;
                     } else {
                        $prevPage = $page - 1;
                     }
                     echo _WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$prevPage;
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
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        }
                     }
                  } else {
                     for($i = $begin; $i <= $end; $i++) {
                        if($page == $i) {
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
                     echo _WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$nextPage;
                  ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
                  <?php 
                     echo _WEB_HOST_ROOT_ADMIN.'?module=subscribe'.$queryStr.'&page='.$numPage;
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