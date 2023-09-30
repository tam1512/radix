<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Hiển thị danh sách người dùng, phân trang, tìm kiếm
 */
 if(!isLogin()) {
   redirect("?module=auth&action=login");
 }

 $data = [
  'title' => 'Quản lý người dùng'
 ];

 layout('header', $data);
 
 // lấy ra userId
 $userId = $_COOKIE['userId'];
 $permisstion_id = firstRaw("SELECT per_id FROM users WHERE id = $userId")['per_id'];

 echo '<div class="container"> <br>'; 

$listAllUsers = getRaw("SELECT * FROM users ORDER BY createAt");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["status"])) {
      $status = getBody()["status"];
      if($status == 2) {
         $statusSql = 0;
      } else {
         $statusSql = $status;
      }
      $filter .= "WHERE status = $statusSql";
   }

   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      $filter .= " $operator fullname LIKE '%$keyword%'";   
   }
}



// Xử lý phân trang

// Số lượng user
$countRowUsers = getRows("SELECT id FROM users");

// Số lượng người dùng muốn hiển thị trên 1 trang
$userOnPage = _USER_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowUsers/$userOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * userOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $userOnPage;
$listUsersOnPage = getRaw("SELECT id,fullname, email, phone, status, per_id FROM users $filter LIMIT $offset, $userOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=users', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '&'.$queryStr;
   }
} 
$message = getFlashData('message');
$msgType = getFlashData('msg_type');

// lấy ra các quền của tài khoản
$isAdd = firstRaw("SELECT * FROM permission WHERE id = $permisstion_id")['add'];
$isUpdate = firstRaw("SELECT * FROM permission WHERE id = $permisstion_id")['update'];
$isDelete = firstRaw("SELECT * FROM permission WHERE id = $permisstion_id")['delete'];

// được add và delete là cao hơn dù cho có 1 hay nhiều quyền 
/**
 * 1 => add and delete => [1, 2, 3, 4]
 * 2 => delete => [1, 2, 3]
 * 3 => add => [1, 2, 3, 4]
 * 4 => update => [1, 3]
 * 5 => read only 
 *
 */

 if(!empty($isAdd) && !empty($isDelete)) {
   $level = 1;
 } else if(!empty($isDelete)) {
   $level = 2;
 } else if(!empty($isAdd)) {
   $level = 3;
 } else if(!empty($isUpdate)) {
   $level = 4;
 } else {
   $level = 5;
 }
 setcookie('level', $level, time()+3600, '/');
?>

<hr />
<?php 
   getMsg($message, $msgType);
?>
<h3>Quản lý người dùng</h3>
<?php 
   if(!empty($isAdd)) {
      echo "<p>";
      echo '<a href="?module=users&action=add" class="btn btn-success btn-sm">Thêm người dùng <i class="fa fa-plus"> </i></a>';
      echo "</p>";
   }
?>
<form action="" method="get">
   <div class="row">
      <div class="col">
         <div class="form-group">
            <select name="status" class="form-control">
               <option value="0">Chọn trạng thái</option>
               <option value="1" <?php echo (!empty($status) && $status==1)? 'selected' : false ?>>Kích hoạt</option>
               <option value="2" <?php echo (!empty($status) && $status==2)? 'selected' : false ?>>Chưa kích hoạt
               </option>
            </select>
         </div>
      </div>
      <div class="col-6">
         <input type="text" class="form-control" name="keyword" placeholder="Từ khóa tìm kiếm..."
            value="<?php echo !empty($keyword) ? $keyword : false ?>">
      </div>
      <div class="col-3">
         <button type="submit" class="btn btn-primary">Tìm kiếm</button>
      </div>
   </div>
   <input type="hidden" name="module" value="users">
</form>

<table class="table table-bordered">
   <thead>
      <tr>
         <th width="5%">STT</th>
         <th>Họ Tên</th>
         <th>Email</th>
         <th>Số Điện Thoại</th>
         <th>Trạng Thái</th>
         <th width="5%">Sửa</th>
         <th width="5%">Xóa</th>
      </tr>
   </thead>
   <tbody>
      <?php 
         if(!empty($listUsersOnPage)):
            $count = 0;
            foreach($listUsersOnPage as $user):
               $per_id = $user['per_id'];
               // lấy ra các quền của tài khoản
               $isAddUser = firstRaw("SELECT * FROM permission WHERE id = $per_id")['add'];
               $isUpdateUser = firstRaw("SELECT * FROM permission WHERE id = $per_id")['update'];
               $isDeleteUser = firstRaw("SELECT * FROM permission WHERE id = $per_id")['delete'];


               if(!empty($isAddUser) && !empty($isDeleteUser)) {
                  $levelUser = 1;
               } else if(!empty($isDeleteUser)) {
                  $levelUser = 2;
               } else if(!empty($isAddUser)) {
                  $levelUser = 3;
               } else if(!empty($isUpdateUser)) {
                  $levelUser = 4;
               } else {
                  $levelUser = 5;
               }
               
               // Nếu quyền thấp hơn thì không được update và delete
               $isUpdateTable = $isUpdate;
               $isDeleteTable = $isDelete;
               if($level >= $levelUser) {
                  $isUpdateTable = 0;
                  $isDeleteTable = 0;
               } 
               
               $count++;
      ?>
      <tr>
         <td><?php echo $count ?></td>
         <td><?php echo $user['fullname'] ?></td>
         <td><?php echo $user['email'] ?></td>
         <td><?php echo $user['phone'] ?></td>
         <td>
            <?php echo $user['status'] == 1 ? '<button type="button" class="btn btn-success btn-sm">Kích hoạt</button>' : '<button type="button" class="btn btn-warning btn-sm">Chưa kích hoạt</button>' ?>
         </td>
         <td><a href="?module=users&action=edit&id=<?php echo  $user['id']?>"
               class="btn btn-warning btn-sm <?php echo empty($isUpdateTable) ? 'disabled' : null ?>"><i
                  class="fa fa-edit"></i></a></td>
         <td><a href="<?php echo _WEB_HOST_ROOT."?module=users&action=delete&id=".$user["id"] ?>"
               class="btn btn-danger btn-sm <?php echo empty($isDeleteTable) ? 'disabled' : null ?>"
               onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o"></i></a>
         </td>
      </tr>
      <?php endforeach; else: ?>
      <tr>
         <td colspan="7">
            <div class="alert alert-danger text-center">Không có người dùng</div>
         </td>
      </tr>
      <?php endif; ?>
   </tbody>
</table>

<nav aria-label="Page navigation users">
   <ul class="pagination">
      <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
         <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo _WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$nextPage;
         ?>">
            Sau
         </a>
      </li>
      <li class="page-item">
         <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT.'?module=users'.$queryStr.'&page='.$numPage;
            ?>">
            Trang cuối
         </a>
      </li>
   </ul>
</nav>
<hr>
<?php
echo "</div>";
layout('footer');
?>