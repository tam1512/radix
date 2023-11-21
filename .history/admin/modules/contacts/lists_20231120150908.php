<?php 
   $data = [
      'title' => 'Danh sách contacts'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllDepartments = getRaw("SELECT id, name FROM departments ORDER BY create_at DESC");
   $listStatus = [
      '1' => [
         'value'=> 'Chưa xử lý',
         'type' => 'danger'
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

   if(!empty($bodyGet["department_id"])) {
      $departmentId = trim($bodyGet["department_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator contacts.department_id = $departmentId"; 
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
$listContactOnPage = getRaw("SELECT contacts.id, contacts.fullname, contacts.email,contacts.message, contacts.create_at, contacts.department_id, departments.name AS department_name FROM contacts INNER JOIN departments ON departments.id = contacts.department_id $filter ORDER BY contacts.create_at DESC LIMIT $offset, $contactOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=contacts', '', $queryStr);
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
            <div class="col-4">
               <div class="form-group">
                  <select name="department_id" id="department_id" class="form-control">
                     <option value="0">Chọn phòng ban</option>
                     <?php
                        foreach($listAllDepartments as $department) {
                           $isSelect = false;
                           if(!empty($departmentId)) {
                              $isSelect = $department['id'] == $departmentId ? 'selected' : false;
                           }
                           echo '<option value="'.$department['id'].'" '.$isSelect.'>'.$department['name'].'</option>'
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-4">
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
            <div class="col-4">
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
            <div class="col-6">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên dự án..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-2">
               <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="contacts">
      </form>
      <br>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="25%">Tên</th>
               <th width="10%">Email</th>
               <th width="15%">Phòng ban</th>
               <th width="10%">Message</th>
               <th width="15%">Thời gian</th>
               <th width="10%">Tình trạng</th>
               <th width="10%">Sửa</th>
               <th width="10%">Xóa</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listContactOnPage)):
                  $count = 0;
                  foreach($listContactOnPage as $contact):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <a href="<?php echo getLinkAdmin('contacts', 'edit', ['id'=>$contact['id']]) ?>">
                     <?php echo $contact['email'] ?>
                  </a>
               </td>
               <td>
                  <a href="<?php echo getLinkAdmin('contacts', 'edit', ['id'=>$contact['id']]) ?>">
                     <?php echo $contact['fullname'] ?>
                  </a>
               </td>
               <td>
                  <a href="<?php echo getLinkAdmin('contacts', 'edit', ['department_id'=>$contact['deparment_id']]) ?>">
                     <?php echo $contact['deparment_name'] ?>
                  </a>
               </td>
               <td>
                  <?php echo $contact['message'] ?>
               </td>
               <td><?php echo getDateFormat($contact["create_at"], 'd/m/Y H:i:s') ?></td>
               <td class="text-center">
                  <?php 
                     foreach($listStatus as $key=>$value) {
                        if($key == $status) {
                           echo '<button type="button" class="btn btn-'.$value['type'].'">'.$value['value'].'</button>';
                        }
                     }
                  ?>
               </td>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('contacts', 'edit', ['id' => $contact['id']]) ?>">Sửa</a>
               </td>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('contacts', 'delete', ['id' => $contact['id']]) ?>">Xóa</a>
               </td>
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
         <ul class="pagination pagination-sm justify-content-end <?php echo ($numPage == 1) ? 'd-none' : false ?>">
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