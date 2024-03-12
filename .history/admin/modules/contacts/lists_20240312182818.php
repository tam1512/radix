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
    $checkPermission = checkPermission($permissionData, 'contacts', 'lists');
    $isEdit = checkPermission($permissionData, 'contacts', 'edit');
    $isDelete = checkPermission($permissionData, 'contacts', 'delete');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý liên hệ');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
   $data = [
      'title' => 'Danh sách contacts'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllContactTypes = getRaw("SELECT id, name FROM contact_types ORDER BY create_at DESC");
   $listStatus = [
      '1' => [
         'value'=> 'Chưa xử lý',
         'type' => 'warning'
      ],
      '2' => [
         'value' => 'Đang xử lý',
         'type' => 'primary'
      ],
      '3' => [
         'value' => 'Đã xử lý',
         'type' => 'success'
      ]
   ];
   $listTypes = [
      'fullname' => 'Họ và tên',
      'email' => 'Email'
   ];

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   $bodyGet = getBody('get');

   if(!empty($bodyGet['types'])) {
      $type = trim($bodyGet['types']);
   }

   if(!empty($bodyGet["keyword"])) {
      $keyword = trim($bodyGet["keyword"]);
      if(!empty($type)) {
         $filter .= " WHERE contacts.$type LIKE '%$keyword%'";   
      }else {
         $filter .= " WHERE contacts.fullname LIKE '%$keyword%'";   
      }
   }

   if(!empty($bodyGet["type_id"])) {
      $typeId = trim($bodyGet["type_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator contacts.type_id = $typeId"; 
   }

   if(!empty($bodyGet["status"])) {
      $status = trim($bodyGet["status"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator contacts.status = $status"; 
   }
}

// Xử lý phân trang

// Số lượng dự án
$countRowContacts = getRows("SELECT id FROM contacts $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$contactOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowContacts/$contactOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * contactOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $contactOnPage;
$listContactOnPage = getRaw("SELECT contacts.id, contacts.fullname, contacts.email, contacts.message, contacts.note, contacts.status, contacts.create_at, contacts.type_id, contact_types.name AS department_name FROM contacts INNER JOIN contact_types ON contact_types.id = contacts.type_id $filter ORDER BY contacts.create_at DESC LIMIT $offset, $contactOnPage");




//Xử lý query String
$queryStr = handleQueryString('contacts', $page);


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
            <div class="col-lg-4 col-md-4 col-12">
               <div class="form-group">
                  <select name="type_id" id="type_id" class="form-control">
                     <option value="0">Chọn phòng ban</option>
                     <?php
                        foreach($listAllContactTypes as $department) {
                           $isSelect = false;
                           if(!empty($typeId)) {
                              $isSelect = $department['id'] == $typeId ? 'selected' : false;
                           }
                           echo '<option value="'.$department['id'].'" '.$isSelect.'>'.$department['name'].'</option>';
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
               <div class="form-group">
                  <select name="status" id="status" class="form-control">
                     <option value="0">Chọn trạng thái</option>
                     <?php 
                        foreach($listStatus as $key=>$value){
                           $isSelect = false;
                           if(!empty($status)) {
                              $isSelect = $key == $status ? 'selected' : false;
                           }
                           echo '<option value="'.$key.'"'.$isSelect.'>'.$value['value'].'</option>';
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
               <div class="form-group">
                  <select name="types" id="types" class="form-control">
                     <option value="0">Chọn loại</option>
                     <?php 
                        foreach($listTypes as $key=>$value){
                           $isSelect = false;
                           if(!empty($type)) {
                              $isSelect = $key == $type ? 'selected' : false;
                           }
                           echo '<option value="'.$key.'"'.$isSelect.'>'.$value.'</option>';
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-6 col-md-4 col-12 mb-2">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên dự án..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-3">
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="contacts">
      </form>
      <br>
      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="18%">Thông tin</th>
               <th width="8%">Phòng ban</th>
               <th width="10%">Tình trạng</th>
               <th width="20%">Nội dung</th>
               <th width="20%">Ghi chú</th>
               <th width="10%">Thời gian</th>
               <?php if($isEdit || $isDelete): ?>
               <th width="5%">Hành động</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listContactOnPage)):
                  $count = 0;
                  foreach($listContactOnPage as $contact):
                     $count++;
                     $color = $contact['status'] == 1 ? 'rgb(133,201,232,0.5)' : false;
            ?>
            <tr style="background: <?php echo $color ?>">
               <td><?php echo $count ?></td>
               <td>
                  <div class="">
                     Họ và tên:
                     <a href="<?php echo getLinkAdmin('contacts', 'edit', ['id'=>$contact['id']]) ?>">
                        <?php echo $contact['fullname'] ?>
                     </a>
                  </div>
                  <div class="">
                     Email:
                     <a href="<?php echo getLinkAdmin('contacts', 'edit', ['id'=>$contact['id']]) ?>">
                        <?php echo $contact['email'] ?>
                     </a>
                  </div>
               </td>
               <td>
                  <a href="<?php echo getLinkAdmin('contacts', 'edit', ['type_id'=>$contact['type_id']]) ?>">
                     <?php echo $contact['department_name'] ?>
                  </a>
               </td>
               <td class="text-center">
                  <?php 
                     foreach($listStatus as $key=>$value) {
                           if($key == $contact['status']) {
                           echo '<button type="button" class="btn btn-'.$value['type'].'">'.$value['value'].'</button>';
                        }
                     }
                  ?>
               </td>
               <td>
                  <?php echo $contact['message'] ?>
               </td>
               <td>
                  <?php echo $contact['note'] ?>
               </td>
               <td><?php echo getDateFormat($contact["create_at"], 'd/m/Y H:i:s') ?></td>
               <?php if($isEdit || $isDelete): ?>
               <td class="text-center">
                  <?php if($isEdit): ?>
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('contacts', 'edit', ['id' => $contact['id']]) ?>">
                     <i class="fa fa-edit"></i>
                  </a>
                  <?php endif; if($isDelete): ?>
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('contacts', 'delete', ['id' => $contact['id']]) ?>">
                     <i class="fa fa-trash"></i>
                  </a>
                  <?php endif; ?>
               </td>
               <?php endif; ?>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="10" class="text-center alert alert-danger">Không có liên hệ</td>
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
                     echo _WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$prevPage;
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
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        }
                     }
                  } else {
                     for($i = $begin; $i <= $end; $i++) {
                        if($page == $i) {
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
                     echo _WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$nextPage;
                  ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
                  <?php 
                     echo _WEB_HOST_ROOT_ADMIN.'?module=contacts'.$queryStr.'&page='.$numPage;
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