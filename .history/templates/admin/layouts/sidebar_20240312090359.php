<?php 
$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname, avatar FROM users WHERE id = $userId");

$groupId = getGroupId();

 $group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
 $isRoot = !empty($group['root']) ? $group['root'] : false;
 if($isRoot) {
   $isListsGroups = true;
   $isAddGroups = true;
   
   $isListsUsers = true;
   $isAddUsers = true;
   
   $isListsServices = true;
   $isAddServices = true;
   
   $isListsPages = true;
   $isAddPages = true;
   
   $isListsBlogs = true;
   $isAddBlogs = true;
   $isListsBlogCategories = true;
   
   $isListsProductCategories = true;
   $isAddProductCategories = true;
   
   $isListsProducts = true;
   $isAddProducts = true;
   
   $isListsFactories = true;
   $isAddFactories = true;
   
   $isListsDefectCategories = true;
   $isAddDefectCategories = true;
   
   $isListsDefects = true;
   $isAddDefects = true;
   
   $isListsReportCategories = true;
   $isAddReportCategories = true;
   
   $isListsReports = true;
   $isAddReports = true;
   
   $isListsStatisticalReports = true;
 } else {
    $permissionData = getPermissionData($groupId);
    $isListsGroups = checkPermission($permissionData, 'groups', 'lists');
    $isAddGroups = checkPermission($permissionData, 'groups', 'add');
    
    $isListsUsers = checkPermission($permissionData, 'users', 'lists');
    $isAddUsers = checkPermission($permissionData, 'users', 'add');
    
    $isListsProductCategories = checkPermission($permissionData, 'product_categories', 'lists');
    $isAddProductCategories = checkPermission($permissionData, 'product_categories', 'add');
    
    $isListsProducts = checkPermission($permissionData, 'products', 'lists');
    $isAddProducts = checkPermission($permissionData, 'products', 'add');
    
    $isListsFactories = checkPermission($permissionData, 'factories', 'lists');
    $isAddFactories = checkPermission($permissionData, 'factories', 'add');
    
    $isListsDefectCategories = checkPermission($permissionData, 'defect_categories', 'lists');
    $isAddDefectCategories = checkPermission($permissionData, 'defect_categories', 'add');
    
    $isListsDefects = checkPermission($permissionData, 'defects', 'lists');
    $isAddDefects = checkPermission($permissionData, 'defects', 'add');
    
    $isListsReportCategories = checkPermission($permissionData, 'report_categories', 'lists');
    $isAddReportCategories = checkPermission($permissionData, 'report_categories', 'add');
    
    $isListsReports = checkPermission($permissionData, 'reports', 'lists');
    $isAddReports = checkPermission($permissionData, 'reports', 'add');
    
    $isListsStatisticalReports = checkPermission($permissionData, 'statistical_reports', 'lists');
 }
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="<?php echo _WEB_HOST_ROOT.'/admin' ?>" class="brand-link">
      <img src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>img/AdminLTELogo.png" alt="AdminLTE Logo"
         class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Radix Admin</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
            <img src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>img/user2-160x160.jpg"
               class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
            <a href="<?php echo getLinkAdmin('users', 'profile') ?>"
               class="d-block"><?php echo $userDetail['fullname'] ?></a>
         </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN ?>"
                  class="nav-link <?php echo activeMenuSidebar('') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Tổng quan
                  </p>
               </a>
            </li>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('groups', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups" ?>"
                  class="nav-link <?php echo activeMenuSidebar('groups', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                     Nhóm người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups" ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('users', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users" ?>"
                  class="nav-link <?php echo activeMenuSidebar('users', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Quản lý người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users" ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('services', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=services" ?>"
                  class="nav-link <?php echo activeMenuSidebar('services', '', true) ? 'active' : false ?>">
                  <i class="nav-icon far fa-clone"></i>
                  <p>
                     Quản lý dịch vụ
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=services" ?>"
                        class="nav-link <?php echo activeMenuSidebar('services', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=services&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('services', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('pages', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=pages" ?>"
                  class="nav-link <?php echo activeMenuSidebar('pages', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                     Quản lý trang
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=pages" ?>"
                        class="nav-link <?php echo activeMenuSidebar('pages', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=pages&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('pages', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('portfolios', '', true, 'portfolio_categories') ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=portfolios" ?>"
                  class="nav-link <?php echo activeMenuSidebar('portfolios', '', true, 'portfolio_categories') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-briefcase"></i>
                  <p>
                     Quản lý dự án
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=portfolios" ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolios', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=portfolios&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolios', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=portfolio_categories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolio_categories') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh mục dự án</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blogs" ?>"
                  class="nav-link <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-blog"></i>
                  <p>
                     Quản lý blog
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blogs" ?>"
                        class="nav-link <?php echo activeMenuSidebar('blogs', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blogs&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('blogs', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blog_categories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('blog_categories') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh mục blog</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('contacts', '', true, 'contact_types') ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=contacts" ?>"
                  class="nav-link <?php echo activeMenuSidebar('contacts', '', true, 'contact_types') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>
                     Quản lý liên hệ
                     <span class="<?php echo getCountContacts() > 0 ? 'badge badge-danger' : 'd-none' ?>">
                        <?php echo getCountContacts() > 0 ? getCountContacts() : false ?>
                     </span>
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=contacts" ?>"
                        class="nav-link <?php echo activeMenuSidebar('contacts', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách
                           <span class="<?php echo getCountContacts() > 0 ? 'badge badge-danger' : 'd-none' ?>">
                              <?php echo getCountContacts() > 0 ? getCountContacts() : false ?>
                           </span>
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=contact_types" ?>"
                        class="nav-link <?php echo activeMenuSidebar('contact_types') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách phòng ban</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('comments') ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('comments') ?>"
                  class="nav-link <?php echo activeMenuSidebar('comments') ? 'active' : false ?>">
                  <i class="nav-icon far fa-comment-dots"></i>
                  <p>
                     Quản lý bình luận
                     <span class="badge badge-danger">
                        <?php echo getCountComments() ?>
                     </span>
                  </p>
               </a>
            </li>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('subscribe') ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('subscribe') ?>"
                  class="nav-link <?php echo activeMenuSidebar('subscribe') ? 'active' : false ?>">
                  <i class="nav-icon far fa-folder-open"></i>
                  <p>
                     Quản lý đăng ký
                     <span class="badge badge-danger">
                        <?php echo getCountSubscribes() ?>
                     </span>
                  </p>
               </a>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('options', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options" ?>"
                  class="nav-link <?php echo activeMenuSidebar('options', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                     Thiết lập
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=general" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'general') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập chung</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=header" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'header') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Header</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=footer" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'footer') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Footer</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=home" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'home') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Trang chủ</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=about" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'about') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập giới thiệu</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=team" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'team') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Team</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=services" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'services') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập dịch vụ</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=portfolios" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'portfolios') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập dự án</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=blogs" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'blogs') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Blogs</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=contact" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'contact') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập liên hệ</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options&action=menu" ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'menu') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập menu</p>
                     </a>
                  </li>
               </ul>
            </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">