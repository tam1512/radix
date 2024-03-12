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
    $checkPermission = checkPermission($permissionData, 'portfolios', 'lists');
    $isEdit = checkPermission($permissionData, 'portfolios', 'edit');
    $isDelete = checkPermission($permissionData, 'portfolios', 'delete');
    $isDetail= checkPermission($permissionData, 'portfolios', 'detail');
    $isDuplicate = checkPermission($permissionData, 'portfolios', 'duplicate');
 }

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý dự án');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 } 
   $data = [
      'title' => 'Danh sách dự án'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);


   $listAllUsers = getRaw("SELECT id, fullname, email FROM users ORDER BY create_at DESC");
   $listAllCates = getRaw("SELECT id, name FROM portfolio_categories ORDER BY create_at DESC");
   $portfolioCategoryMapping = getRaw("SELECT * FROM portfolio_category_mapping");
   $listAllPortFolios = getRaw("SELECT * FROM portfolios");
   foreach($listAllPortFolios as $key => $item) {
      foreach($portfolioCategoryMapping as $map) {
         if($item['id'] == $map['portfolio_id']) {
            $listAllPortFolios[$key]['categories'][] = $map['category_id'];
         }
      }
   }
// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      $filter .= " WHERE portfolios.name LIKE '%$keyword%'";   
   }

   if(!empty(getBody()["user_id"])) {
      $userId = trim(getBody()["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator portfolios.user_id = $userId"; 
   }

   if(!empty(getBody()["cate_id"])) {
      $cateId = trim(getBody()["cate_id"]);
   }
}

// Xử lý phân trang

// Số lượng dự án
if(!empty($cateId)) {
   $countRowPortfolios = 0;
   if(empty($userId) && empty($keyword)) {
      foreach($listAllPortFolios as $item) {
         foreach($item['categories'] as $cate) {
            if($cate == $cateId) {
               $countRowPortfolios++;
               break;
            }
         }
      } 
   } else if(!empty($userId) && empty($keyword)){
      foreach($listAllPortFolios as $item) {
         if($item['user_id'] == $userId) {
            foreach($item['categories'] as $cate) {
               if($cate == $cateId) {
                  $countRowPortfolios++;
                  break;
               }
            }
         }
      } 
   } else if(empty($userId) && !empty($keyword)){
      foreach($listAllPortFolios as $item) {
         if(preg_match('/^.*.'.$item['name'].'.*$/i', $keyword)) {
            foreach($item['categories'] as $cate) {
               if($cate == $cateId) {
                  $countRowPortfolios++;
                  break;
               }
            }
         }
      } 
   }
} else {
   $countRowPortfolios = getRows("SELECT id FROM portfolios $filter");
}

// Số lượng người dùng muốn hiển thị trên 1 trang
$portfolioOnPage = _SERVICE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowPortfolios/$portfolioOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * portfolioOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $portfolioOnPage;
$listPortfolioOnPage = getRaw("SELECT portfolios.id, portfolios.name, thumbnail, users.fullname, portfolios.create_at, portfolios.user_id, users.email AS user_email FROM portfolios INNER JOIN users ON portfolios.user_id = users.id $filter ORDER BY portfolios.create_at DESC");
//Thêm categories cho các dự án sau khi lọc
foreach($listPortfolioOnPage as $key => $value) {
   foreach($listAllPortFolios as $item) {
      if($value['id'] == $item['id']) {
         $listPortfolioOnPage[$key]['categories'] = $item['categories'];
         break;
      }
   }
}

if(!empty($cateId)) {
   //Lọc lại mảng theo categories từ mảng trên
   foreach($listPortfolioOnPage as $key => $item) {
      if(!in_array($cateId, $item['categories'])) {
         unset($listPortfolioOnPage[$key]);
      }
   }
}
//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=portfolios', '', $queryStr);
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
                  <select name="cate_id" class="form-control selectpicker" data-live-search="true"
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
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="portfolios">
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
               <?php if($isDetail): ?>
               <th width="10%">Xem</th>
               <?php endif; if($isEdit): ?>
               <th width="10%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="10%">Xóa</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listPortfolioOnPage)):
                  $count = 0;
                  $lengthArr = count($listPortfolioOnPage);
                  $lengthArr = ($lengthArr < $offset+$portfolioOnPage) ? $lengthArr : $offset+$portfolioOnPage;
                  for($i = $offset; $i < $lengthArr; $i++):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <?php
                   echo isIcon($listPortfolioOnPage[$i]['thumbnail']) ? $listPortfolioOnPage[$i]['thumbnail'] : '<img src="'.$listPortfolioOnPage[$i]['thumbnail'].'" alt="thumbnail" width="80%">' 
                   ?>
               </td>
               <td>
                  <?php echo $listPortfolioOnPage[$i]['name'] ?>
                  <?php if($isDuplicate): ?>
                  <a href="<?php echo getLinkAdmin('portfolios', 'duplicate', ['id' => $listPortfolioOnPage[$i]['id']]) ?>"
                     class="btn btn-danger btn-sm btn-duplicate ml-2">Nhân bản</a>
                  <?php endif; ?>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('portfolios', "", ['user_id'=>$listPortfolioOnPage[$i]['user_id']])?>"><?php echo $listPortfolioOnPage[$i]['fullname']  ?></a>
               </td>
               <td>
                  <?php 
                     foreach($listPortfolioOnPage[$i]['categories'] as $cateID):
                        foreach($listAllCates as $cate):
                           if($cateID ==  $cate['id']):
                  ?>
                  <p class="badge badge-success"><?php echo $cate['name'] ?></p>
                  <?php
                              break;
                           endif;
                        endforeach;
                     endforeach;
                  ?>
               </td>
               <td><?php echo getDateFormat($listPortfolioOnPage[$i]["create_at"], 'd/m/Y H:i:s') ?></td>
               <?php if($isDetail): ?>
               <td class="text-center">
                  <a class="btn btn-success" target="_blank"
                     href="<?php echo getLinkModule('portfolios', $listPortfolioOnPage[$i]['id']) ?>">
                     Xem
                  </a>
               </td>
               <?php endif; if($isEdit): ?>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('portfolios', 'edit', ['id' => $listPortfolioOnPage[$i]['id']]) ?>">Sửa</a>
               </td>
               <?php endif; if($isDelete): ?>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('portfolios', 'delete', ['id' => $listPortfolioOnPage[$i]['id']]) ?>">Xóa</a>
               </td>
               <?php endif; ?>
            </tr>
            <?php 
               endfor; else:
            ?>
            <tr>
               <td colspan="8" class="text-center alert alert-danger">Không có dự án</td>
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
               echo _WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=portfolios'.$queryStr.'&page='.$numPage;
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