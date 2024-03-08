<?php 
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
$listDeContactTypesOnPage = getRaw("SELECT id, name, create_at, user_id, (SELECT count(contacts.id) FROM contacts WHERE contacts.department_id = contact_types.id) as contacts_count FROM contact_types $filter ORDER BY create_at DESC LIMIT $offset, $typeOnPage");

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
         <div class="col-6">
            <?php
               if(!empty($view) && !empty($id)) {
                  require_once("$view.php");
               } else {
                  require_once('add.php');
               }  
            ?>
         </div>
         <div class="col-6">
            <form action="" method="get">
               <div class="row">
                  <h4>Danh sách phòng ban</h4>
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
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th width="5%">STT</th>
                     <th width="40%">Tên</th>
                     <th width="15%">Thời gian</th>
                     <th width="5%">Sửa</th>
                     <th width="5%">Xóa</th>
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
                           href="<?php echo getLinkAdmin('contact_types', '', ['id' => $type['id'], 'view' => 'edit']) ?>">
                           <?php echo $type['name']?>
                        </a>
                        <p><?php echo '('.$type['contacts_count'].')'?></p>
                        <a href="<?php echo getLinkAdmin('contact_types', 'duplicate', ['id' => $type['id']]) ?>"
                           class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                        <a href="<?php echo getLinkAdmin('contact_types', 'seen', ['id' => $type['id']]) ?>"
                           class="btn btn-success btn-sm btn-duplicate ml-2">Xem</a>
                     </td>
                     <td><?php echo getDateFormat($type["create_at"], 'd/m/Y H:i:s') ?></td>
                     <td class="text-center">
                        <a class="btn btn-warning"
                           href="<?php echo getLinkAdmin('contact_types', '', ['id' => $type['id'], 'view' => 'edit']) ?>"><i
                              class="fa fa-edit"></i></a>
                     </td>
                     <td class="text-center">
                        <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                           href="<?php echo getLinkAdmin('contact_types', 'delete', ['id' => $type['id']]) ?>"><i
                              class="fa fa-trash"></i></a>
                     </td>
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