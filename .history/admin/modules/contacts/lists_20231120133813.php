<?php 
   $data = [
      'title' => 'Danh sách contacts'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllDepartments = getRaw("SELECT id, name FROM blog_categories ORDER BY create_at DESC");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   $bodyGet = getBody('get');

   if(!empty($bodyGet["keyword"])) {
      $keyword = trim($bodyGet["keyword"]);
      $filter .= " WHERE contacts.title LIKE '%$keyword%'";   
   }

   if(!empty($bodyGet["user_id"])) {
      $userId = trim($bodyGet["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator contacts.user_id = $userId"; 
   }

   if(!empty($bodyGet["cate_id"])) {
      $cateId = trim($bodyGet["cate_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator contacts.category_id = $cateId"; 
   }
}

// Xử lý phân trang

// Số lượng dự án
$countRowcontacts = getRows("SELECT id FROM contacts $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$blogOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowcontacts/$blogOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * blogOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $blogOnPage;
$listBlogOnPage = getRaw("SELECT contacts.id, contacts.title, thumbnail, view_count, users.fullname, contacts.create_at, contacts.user_id, users.email AS user_email, contacts.category_id AS cate_id, blog_categories.name AS cate_name FROM contacts INNER JOIN users ON contacts.user_id = users.id INNER JOIN blog_categories ON blog_categories.id = contacts.category_id $filter ORDER BY contacts.create_at DESC LIMIT $offset, $blogOnPage");

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
                                       if(empty($cateId)) {
                                          $cateId = '';
                                       }
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
                                          href="<?php echo !empty($keyword) ? getLinkAdmin('contacts', '', ['keyword'=>$keyword, 'user_id'=>$user["id"], 'cate_id'=>$cateId]) : getLinkAdmin('contacts', '', ['user_id'=>$user["id"], 'cate_id'=>$cateId]) ?>">Chọn</a>
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
                           <a href="<?php echo getLinkAdmin('contacts') ?>" type="button" class="btn btn-danger">Hủy
                              chọn</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-3 d-flex">
               <div class="form-group d-flex mw-210">
                  <select name="select" id="select" class="form-control" readonly disabled>
                     <option value="0">Chọn danh mục</option>
                     <?php 
                        if(!empty($listAllDepartments)):
                           foreach($listAllDepartments as $cate):
                     ?>
                     <option value="<?php echo $cate['id'] ?>"
                        <?php echo (!empty($cateId) && $cate['id'] == $cateId) ? 'selected' : false ?>>
                        <?php echo $cate['name'] ?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
                  <input type="hidden" name="cate_id" id="cate_id">
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
                                       foreach($listAllDepartments as $cate):
                                          $count++;
                                 ?>
                                 <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                       <?php
                                          echo $cate['name']
                                       ?>
                                    </td>
                                    <td class="text-center">
                                       <a class="btn btn-success"
                                          href="<?php echo !empty($keyword) ? getLinkAdmin('contacts', '', ['keyword'=>$keyword, 'cate_id'=>$cate["id"], 'user_id' => $userId]) : getLinkAdmin('contacts', '', ['cate_id'=>$cate["id"], 'user_id' => $userId]) ?>">Chọn</a>
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
               if(!empty($listBlogOnPage)):
                  $count = 0;
                  foreach($listBlogOnPage as $blog):
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
                     href="<?php echo getLinkAdmin('contacts', "", ['cate_id'=>$blog['cate_id']])?>"><?php echo $blog['cate_name']  ?></a>
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