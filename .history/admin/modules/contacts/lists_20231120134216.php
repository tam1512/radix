<?php 
   $data = [
      'title' => 'Danh sách contacts'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllDepartments = getRaw("SELECT id, name FROM departments ORDER BY create_at DESC");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   $bodyGet = getBody('get');

   if(!empty($bodyGet["keyword"])) {
      $keyword = trim($bodyGet["keyword"]);
      $filter .= " WHERE contacts.fullname LIKE '%$keyword%'";   
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
$listcontactOnPage = getRaw("SELECT contacts.id, contacts.title, thumbnail, view_count, users.fullname, contacts.create_at, contacts.user_id, users.email AS user_email, contacts.category_id AS department_id, departments.name AS cate_name FROM contacts INNER JOIN users ON contacts.user_id = users.id INNER JOIN departments ON departments.id = contacts.category_id $filter ORDER BY contacts.create_at DESC LIMIT $offset, $contactOnPage");

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
            <div class="col-3 d-flex">
               <div class="form-group d-flex mw-210">
                  <select name="select" id="select" class="form-control" readonly disabled>
                     <option value="0">Chọn phòng ban</option>
                     <?php 
                        if(!empty($listAllDepartments)):
                           foreach($listAllDepartments as $department):
                     ?>
                     <option value="<?php echo $department['id'] ?>"
                        <?php echo (!empty($departmentId) && $department['id'] == $departmentId) ? 'selected' : false ?>>
                        <?php echo $department['name'] ?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
                  <input type="hidden" name="department_id" id="department_id">
                  <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#chooseCate">
                     <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                  </button>
               </div>


               <!-- Modal -->
               <!-- data-backdrop="static" -->
               <div class="modal fade" id="chooseCate" data-keyboard="false" tabindex="-1"
                  aria-labelledby="chooseCateLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="chooseCateLabel">Danh sách danh mục</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row justify-content-center mb-8">
                              <div class="col-6">
                                 <input type="text" class="form-control" id="keyword_modal" name="keyword_modal"
                                    placeholder="Nhập tên danh mục...">
                              </div>
                              <div class="col-3">
                                 <button type="button" id="btnSearchModal" class="btn btn-success">Tìm kiếm</button>
                              </div>
                           </div>
                           <hr>
                           <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <th width="5%">STT</th>
                                    <th>Tên danh mục</th>
                                    <th width="15%">Chọn</th>
                                 </tr>
                              </thead>
                              <tbody id="content_modal">
                                 <?php 
                                    if(!empty($listAllDepartments)):
                                       if(empty($userId)) {
                                          $userId = '';
                                       }
                                       $count = 0;
                                       foreach($listAllDepartments as $department):
                                          $count++;
                                 ?>
                                 <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                       <?php
                                          echo $department['name']
                                       ?>
                                    </td>
                                    <td class="text-center">
                                       <a class="btn btn-success"
                                          href="<?php echo !empty($keyword) ? getLinkAdmin('contacts', '', ['keyword'=>$keyword, 'department_id'=>$department["id"], 'user_id' => $userId]) : getLinkAdmin('contacts', '', ['department_id'=>$department["id"], 'user_id' => $userId]) ?>">Chọn</a>
                                    </td>
                                 </tr>
                                 <?php 
                                    endforeach; else:
                                 ?>
                                 <tr>
                                    <td colspan="4" class="text-center alert alert-danger">Không có danh mục</td>
                                 </tr>
                                 <?php endif; ?>
                              </tbody>
                           </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
                           <a href="<?php echo getLinkAdmin('contacts') ?>" type="button" class="btn btn-danger">Hủy
                              chọn</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-4">
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
               <th width="10%">Ảnh</th>
               <th width="25%">Tên</th>
               <th width="15%">Đăng bởi</th>
               <th width="15%">Danh mục</th>
               <th width="15%">Thời gian</th>
               <th width="10%">Xem</th>
               <th width="10%">Sửa</th>
               <th width="10%">Xóa</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listcontactOnPage)):
                  $count = 0;
                  foreach($listcontactOnPage as $blog):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <?php
                   echo isIcon($blog['thumbnail']) ? $blog['thumbnail'] : '<img src="'.$blog['thumbnail'].'" alt="thumbnail" width="80%">' 
                   ?>
               </td>
               <td>
                  <a
                     href="<?php echo getLinkAdmin('contacts', 'edit', ['id'=>$blog['id']]) ?>"><?php echo $blog['title'] ?></a>
                  <a href="<?php echo getLinkAdmin('contacts', 'duplicate', ['id' => $blog['id']]) ?>"
                     class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                  <span class="btn btn-success btn-sm btn-duplicate">Lượt xem : <?php echo $blog["view_count"] ?></span>
                  <a href="<?php echo getLinkAdmin('contacts', 'seen', ['id' => $blog['id']]) ?>"
                     class="btn btn-primary btn-sm btn-duplicate">Xem</a>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('contacts', "", ['user_id'=>$blog['user_id']])?>"><?php echo $blog['fullname']  ?></a>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('contacts', "", ['department_id'=>$blog['department_id']])?>"><?php echo $blog['cate_name']  ?></a>
               </td>
               <td><?php echo getDateFormat($blog["create_at"], 'd/m/Y H:i:s') ?></td>
               <td class="text-center"><a class="btn btn-success" href="#">Xem</a></td>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('contacts', 'edit', ['id' => $blog['id']]) ?>">Sửa</a>
               </td>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('contacts', 'delete', ['id' => $blog['id']]) ?>">Xóa</a>
               </td>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="8" class="text-center alert alert-danger">Không có blog</td>
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