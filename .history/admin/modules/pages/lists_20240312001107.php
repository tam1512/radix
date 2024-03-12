<?php 
   $data = [
      'title' => 'Danh sách trang'
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
      $filter .= " WHERE title LIKE '%$keyword%'";   
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

// Số lượng trang
$countRowPages = getRows("SELECT id FROM pages $filter");

// Số lượng trang muốn hiển thị trên 1 trang
$pageOnPage = _PAGE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowPages/$pageOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * pageOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $pageOnPage;
$listpageOnPage = getRaw("SELECT pages.id, title, users.fullname, pages.create_at, user_id FROM pages INNER JOIN users ON pages.user_id = users.id $filter ORDER BY pages.create_at DESC LIMIT $offset, $pageOnPage");



//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=pages', '', $queryStr);
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
            <div class="col-3">
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
               <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="pages">
      </form>
      <br>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="35%">Tiêu đề</th>
               <th width="15%">Đăng bởi</th>
               <th width="15%">Thời gian</th>
               <th width="10%">Xem</th>
               <th width="10%">Sửa</th>
               <th width="10%">Xóa</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listpageOnPage)):
                  $count = 0;
                  foreach($listpageOnPage as $pageItem):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <?php echo $pageItem['title'] ?>
                  <a href="<?php echo getLinkAdmin('pages', 'duplicate', ['id' => $pageItem['id']]) ?>"
                     class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('pages', "", ['user_id'=>$pageItem['user_id']])?>"><?php echo $pageItem['fullname']  ?></a>
               </td>
               <td><?php echo getDateFormat($pageItem["create_at"], 'd/m/Y H:i:s') ?></td>
               <td class="text-center"><a class="btn btn-success" target="_blank"
                     href="<?php echo getLinkModule('pages', $pageItem['id']) ?>">Xem</a></td>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('pages', 'edit', ['id' => $pageItem['id']]) ?>">Sửa</a>
               </td>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('pages', 'delete', ['id' => $pageItem['id']]) ?>">Xóa</a>
               </td>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="8" class="text-center alert alert-danger">Không có trang</td>
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
               echo _WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=pages'.$queryStr.'&page='.$numPage;
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