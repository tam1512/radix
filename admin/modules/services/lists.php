<?php 
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

// Số lượng user
$countRowServices = getRows("SELECT id FROM services");

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
            <div class="col-3 d-flex">
               <div class="form-group d-flex">
                  <select name="select" id="select" class="form-control" readonly disabled>
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
                  <input type="hidden" name="user_id" id="user_id">
                  <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#chooseUser">
                     <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                  </button>
               </div>


               <!-- Modal -->
               <!-- data-backdrop="static" -->
               <div class="modal fade" id="chooseUser" data-keyboard="false" tabindex="-1"
                  aria-labelledby="chooseUserLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="chooseUserLabel">Danh sách người đăng</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <!-- <form action="" method="POST"> -->
                           <div class="row justify-content-center mb-8">
                              <div class="col-6">
                                 <input type="text" class="form-control" id="keyword_modal" name="keyword_modal"
                                    placeholder="Nhập tên hoặc email...">
                              </div>
                              <div class="col-3">
                                 <button type="button" id="btnSearchModal" class="btn btn-success">Tìm kiếm</button>
                              </div>
                           </div>
                           <hr>
                           <!-- </form> -->
                           <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <th width="5%">STT</th>
                                    <th>Tên người đăng</th>
                                    <th>Email</th>
                                    <th width="15%">Chọn</th>
                                 </tr>
                              </thead>
                              <tbody id="content_modal">
                                 <?php 
                                    if(!empty($listAllUsers)):
                                       $count = 0;
                                       foreach($listAllUsers as $user):
                                          $count++;
                                 ?>
                                 <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                       <?php
                                          echo $user['fullname']
                                       ?>
                                    </td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td class="text-center">
                                       <a class="btn btn-success"
                                          href="<?php echo !empty($keyword) ? getLinkAdmin('services', '', ['keyword'=>$keyword, 'user_id'=>$user["id"]]) : getLinkAdmin('services', '', ['user_id'=>$user["id"]]) ?>">Chọn</a>
                                    </td>
                                 </tr>
                                 <?php 
                                    endforeach; else:
                                 ?>
                                 <tr>
                                    <td colspan="4" class="text-center alert alert-danger">Không có người đăng</td>
                                 </tr>
                                 <?php endif; ?>
                              </tbody>
                           </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
                           <a href="<?php echo getLinkAdmin('services') ?>" type="button" class="btn btn-danger">Hủy
                              chọn</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-6">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên dịch vụ..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-3">
               <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="services">
      </form>
      <br>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="10%">Ảnh</th>
               <th width="20%">Tên dịch vụ</th>
               <th width="20%">Đăng bởi</th>
               <th width="15%">Thời gian</th>
               <th width="10%">Xem</th>
               <th width="10%">Sửa</th>
               <th width="10%">Xóa</th>
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
                   echo isIcon($service['icon']) ? $service['icon'] : '<img src="'.$service['icon'].'" alt="img_service" width="80%">' 
                   ?>
               </td>
               <td><?php echo $service['name'] ?></td>
               <td><a
                     href="<?php echo getLinkAdmin('services', "", ['user_id'=>$service['user_id']])?>"><?php echo $service['fullname']  ?></a>
               </td>
               <td><?php echo getDateFormat($service["create_at"], 'd/m/Y H:i:s') ?></td>
               <td class="text-center"><a class="btn btn-success" href="#">Xem</a></td>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('services', 'edit', ['id' => $service['id']]) ?>">Sửa</a>
               </td>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('services', 'delete', ['id' => $service['id']]) ?>">Xóa</a>
               </td>
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
<script src="<?php echo _WEB_HOST_ROOT.'/templates/admin/assets/js/services/hidden_select.js' ?>"></script>
<script src="<?php echo _WEB_HOST_ROOT.'/templates/admin/assets/js/services/modal_search.js' ?>"></script>
<?php
   layout('footer', 'admin', $data);
?>