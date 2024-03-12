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
    $checkPermission = checkPermission($permissionData, 'blogs', 'lists');
    $isEdit = checkPermission($permissionData, 'blogs', 'edit');
    $isDelete = checkPermission($permissionData, 'blogs', 'delete');
    $isDetail = checkPermission($permissionData, 'blogs', 'detail');
    $isDuplicate = checkPermission($permissionData, 'blogs', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý bài viết');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }
   $data = [
      'title' => 'Danh sách blogs'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);


   $listAllUsers = getRaw("SELECT id, fullname, email FROM users ORDER BY create_at DESC");
   $listAllCates = getRaw("SELECT id, name FROM blog_categories ORDER BY create_at DESC");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   $bodyGet = getBody('get');

   if(!empty($bodyGet["keyword"])) {
      $keyword = trim($bodyGet["keyword"]);
      $filter .= " WHERE blogs.title LIKE '%$keyword%'";   
   }

   if(!empty($bodyGet["user_id"])) {
      $userId = trim($bodyGet["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator blogs.user_id = $userId"; 
   }

   if(!empty($bodyGet["cate_id"])) {
      $cateId = trim($bodyGet["cate_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator blogs.category_id = $cateId"; 
   }
}

// Xử lý phân trang

// Số lượng dự án
$countRowBlogs = getRows("SELECT id FROM blogs $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$blogOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowBlogs/$blogOnPage);

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
$listBlogOnPage = getRaw("SELECT blogs.id, blogs.title, thumbnail, view_count, users.fullname, blogs.create_at, blogs.user_id, users.email AS user_email, blogs.category_id AS cate_id, blog_categories.name AS cate_name FROM blogs INNER JOIN users ON blogs.user_id = users.id INNER JOIN blog_categories ON blog_categories.id = blogs.category_id $filter ORDER BY blogs.create_at DESC LIMIT $offset, $blogOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=blogs', '', $queryStr);
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
            <div class="col-3">
               <div class="form-group">
                  <select name="cate_id" id="cate_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Chọn danh mục" data-width="100%">
                     <option value="0">Chọn danh mục</option>
                     <?php 
                        if(!empty($listAllCates)):
                           foreach($listAllCates as $cate):
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
         <input type="hidden" name="module" value="blogs">
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
                     href="<?php echo getLinkAdmin('blogs', 'edit', ['id'=>$blog['id']]) ?>"><?php echo $blog['title'] ?></a>
                  <a href="<?php echo getLinkAdmin('blogs', 'duplicate', ['id' => $blog['id']]) ?>"
                     class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                  <span class="btn btn-success btn-sm btn-duplicate">Lượt xem : <?php echo $blog["view_count"] ?></span>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('blogs', "", ['user_id'=>$blog['user_id']])?>"><?php echo $blog['fullname']  ?></a>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('blogs', "", ['cate_id'=>$blog['cate_id']])?>"><?php echo $blog['cate_name']  ?></a>
               </td>
               <td><?php echo getDateFormat($blog["create_at"], 'd/m/Y H:i:s') ?></td>
               <td class="text-center"><a class="btn btn-success" target="_blank"
                     href="<?php echo getLinkModule('blogs', $blog['id']) ?>">Xem</a></td>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('blogs', 'edit', ['id' => $blog['id']]) ?>">Sửa</a>
               </td>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('blogs', 'delete', ['id' => $blog['id']]) ?>">Xóa</a>
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
               echo _WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=blogs'.$queryStr.'&page='.$numPage;
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