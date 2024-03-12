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
    $isStatus = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'comments', 'lists');
    $isEdit = checkPermission($permissionData, 'comments', 'edit');
    $isDelete = checkPermission($permissionData, 'comments', 'delete');
    $isStatus = checkPermission($permissionData, 'comments', 'status');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý bình luận');
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
         'value'=> 'Chưa duyệt',
         'type' => 'warning'
      ],
      '1' => [
         'value' => 'Đã duyệt',
         'type' => 'success'
      ]
   ];
   $listTypes = [
      'fullname' => 'Họ và tên',
      'email' => 'Email',
      'website' => 'Website',
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
         $filter .= " WHERE comments.$type LIKE '%$keyword%'";   
      }else {
         $filter .= " WHERE comments.content LIKE '%$keyword%'";   
      }
   }

   if(!empty($bodyGet["user_id"])) {
      $userId = trim($bodyGet["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator comments.user_id = $userId"; 
   }

   if(isset($bodyGet["status"]) && ($bodyGet["status"] == 0 || $bodyGet["status"] == 1)) {
      $status = trim($bodyGet["status"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator comments.status = $status"; 
   }
}

// Xử lý phân trang

// Số lượng bình luận
$countRowComments = getRows("SELECT id FROM comments $filter");

// Số lượng bình luận muốn hiển thị trên 1 trang
$commentOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowComments/$commentOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * commentOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $commentOnPage;

$listCommentOnPage = getRaw("SELECT comments.*, blogs.title FROM comments JOIN blogs ON blogs.id = comments.blog_id $filter ORDER BY comments.create_at DESC LIMIT $offset, $commentOnPage");




//Xử lý query String
$queryStr = handleQueryString('comments', $page);


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
                  <select name="user_id" id="user_id" class="form-control">
                     <option value="0">Chọn người tạo</option>
                     <?php
                        foreach($listAllUsers as $user) {
                           $isSelect = false;
                           if(!empty($userId)) {
                              $isSelect = $user['id'] == $userId ? 'selected' : false;
                           }
                           echo '<option value="'.$user['id'].'" '.$isSelect.'>'.$user['fullname'].'('.$user['email'].')'.'</option>';
                        }
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
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
               <input type="text" class="form-control" name="keyword" placeholder="Nhập tên bình luận..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-3">
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="comments">
      </form>
      <br>
      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="25%">Thông tin</th>
               <th width="30%">Nội dung</th>
               <th width="10%">Trạng thái</th>
               <th width="10%">Thời gian</th>
               <th width="15%">Bài viết</th>
               <?php if($isEdit || $isDelete): ?>
               <th width="5%">Hành động</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listCommentOnPage)):
                  $count = 0;
                  foreach($listCommentOnPage as $comment):
                     $count++;
                     $color = $comment['status'] == 0 ? 'rgb(133,201,232,0.5)' : false;
            ?>
            <tr style="background: <?php echo $color ?>">
               <td><?php echo $count ?></td>
               <td>
                  <div class="">
                     Họ và tên:
                     <a href="<?php echo getLinkAdmin('comments', 'edit', ['id'=>$comment['id']]) ?>">
                        <?php echo $comment['fullname'] ?>
                     </a>
                  </div>
                  <div class="">
                     Email:
                     <a href="<?php echo getLinkAdmin('comments', 'edit', ['id'=>$comment['id']]) ?>">
                        <?php echo $comment['email'] ?>
                     </a>
                  </div>
                  <?php if(!empty($comment['website'])): ?>
                  <div class="">
                     Website:
                     <a href="<?php echo getLinkAdmin('comments', 'edit', ['id'=>$comment['id']]) ?>">
                        <?php echo $comment['website'] ?>
                     </a>
                  </div>
                  <?php endif; ?>
                  <?php 
                     echo !empty($comment['parent_id']) && !empty(getComment($comment['parent_id'])['fullname']) ? '<div>Trả lời: <b>'.getComment($comment['parent_id'])['fullname'].'</b></div>' : false;
                  ?>
               </td>
               <td>
                  <?php echo getLimitText($comment['content'], 10) ?>
               </td>
               <td class="text-center">
                  <?php 
                     foreach($listStatus as $key=>$value) {
                           if($key == $comment['status']) {
                           echo '<button type="button" class="btn btn-'.$value['type'].'">'.$value['value'].'</button>';
                           if($isStatus) {
                              echo $key == 0 ? '<a class="text-info" href="'.getLinkAdmin('comments', 'status', ['id' => $comment['id'], 'status' => $key]).'">Duyệt</a>' : '<a class="text-danger" href="'.getLinkAdmin('comments', 'status', ['id' => $comment['id'], 'status' => $key]).'">Hủy duyệt</a>';
                           }
                        }
                     }
                  ?>
               </td>
               <td><?php echo getDateFormat($comment["create_at"], 'd/m/Y H:i:s') ?></td>
               <td>
                  <a target="_blank" href="<?php echo getLinkModule('blogs',$comment['blog_id']) ?>">
                     <?php echo getLimitText($comment['title'], 5) ?>
                  </a>
               </td>
               <?php if($isEdit || $isDelete): ?>
               <td class="text-center">
                  <?php if($isEdit): ?>
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('comments', 'edit', ['id' => $comment['id']]) ?>">
                     <i class="fa fa-edit"></i>
                  </a>
                  <?php endif; if($isDelete): ?>
                  <a class="btn btn-danger mt-2" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('comments', 'delete', ['id' => $comment['id']]) ?>">
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
               <td colspan="10" class="text-center alert alert-danger">Không có bình luận</td>
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
                     echo _WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$prevPage;
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
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        }
                     }
                  } else {
                     for($i = $begin; $i <= $end; $i++) {
                        if($page == $i) {
                           echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                        } else {
                           echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
                     echo _WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$nextPage;
                  ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
                  <?php 
                     echo _WEB_HOST_ROOT_ADMIN.'?module=comments'.$queryStr.'&page='.$numPage;
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