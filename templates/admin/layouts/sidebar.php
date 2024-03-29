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
   
   $isListsPortfolios = true;
   $isAddPortfolios = true;
   $isListsPortfolioCategories = true;
   
   $isListsBlogs = true;
   $isAddBlogs = true;
   $isListsBlogCategories = true;
   
   $isListsContacts = true;
   $isListsContactTypes = true;

   $isListsComments = true;

   $isListsSubscribe = true;

   $isListsOptions = true;
   $isOptionsGeneral = true;
   $isOptionsHeader = true;
   $isOptionsFooter = true;
   $isOptionsHome = true;
   $isOptionsAbout = true;
   $isOptionsTeam = true;
   $isOptionsServices = true;
   $isOptionsPortfolios = true;
   $isOptionsBlogs = true;
   $isOptionsContacts = true;
   $isOptionsMenu = true; 
 } else {
   $permissionData = getPermissionData($groupId);
   $isListsGroups = checkPermission($permissionData, 'groups', 'lists');
   $isAddGroups = checkPermission($permissionData, 'groups', 'add');
   
   $isListsUsers = checkPermission($permissionData, 'users', 'lists');
   $isAddUsers = checkPermission($permissionData, 'users', 'add');
       
   $isListsServices = checkPermission($permissionData, 'services', 'lists');
   $isAddServices = checkPermission($permissionData, 'services', 'add');
   
   $isListsPages = checkPermission($permissionData, 'pages', 'lists');
   $isAddPages = checkPermission($permissionData, 'pages', 'add');
   
   $isListsPortfolios = checkPermission($permissionData, 'portfolios', 'lists');
   $isAddPortfolios = checkPermission($permissionData, 'portfolios', 'add');
   $isListsPortfolioCategories = checkPermission($permissionData, 'portfolio_categories', 'lists');
   
   $isListsBlogs = checkPermission($permissionData, 'blogs', 'lists');
   $isAddBlogs = checkPermission($permissionData, 'blogs', 'add');
   $isListsBlogCategories = checkPermission($permissionData, 'blog_categories', 'lists');
   
   $isListsContacts = checkPermission($permissionData, 'contacts', 'lists');
   $isListsContactTypes = checkPermission($permissionData, 'contact_categories', 'lists');

   $isListsComments = checkPermission($permissionData, 'comments', 'lists');

   $isListsSubscribe = checkPermission($permissionData, 'subscribe', 'lists');

   $isListsOptions = checkPermission($permissionData, 'options', 'lists');
   $isOptionsGeneral = checkPermission($permissionData, 'options', 'general');
   $isOptionsHeader = checkPermission($permissionData, 'options', 'header');
   $isOptionsFooter = checkPermission($permissionData, 'options', 'footer');
   $isOptionsHome = checkPermission($permissionData, 'options', 'home');
   $isOptionsAbout = checkPermission($permissionData, 'options', 'about');
   $isOptionsTeam = checkPermission($permissionData, 'options', 'team');
   $isOptionsServices = checkPermission($permissionData, 'options', 'services');
   $isOptionsPortfolios = checkPermission($permissionData, 'options', 'portfolios');
   $isOptionsBlogs = checkPermission($permissionData, 'options', 'blogs');
   $isOptionsContacts = checkPermission($permissionData, 'options', 'contacts');
   $isOptionsMenu = checkPermission($permissionData, 'options', 'menu'); 
 }
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="<?php echo getLinkAdmin("") ?>" class="brand-link">
      <img src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>img/AdminLTELogo.png" alt="AdminLTE Logo"
         class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo getOption('general_name_site') ?> Admin</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
            <img src="<?php echo $userDetail['avatar'] ?>" class="img-circle elevation-2" alt="User Image">
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
               <a href="<?php echo getLinkAdmin("") ?>"
                  class="nav-link <?php echo activeMenuSidebar('') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Tổng quan
                  </p>
               </a>
            </li>
            <?php if($isListsGroups): ?>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('groups', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin("groups") ?>"
                  class="nav-link <?php echo activeMenuSidebar('groups', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                     Nhóm người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin("groups") ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddGroups): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin("groups", 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsUsers): ?>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('users', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('users') ?>"
                  class="nav-link <?php echo activeMenuSidebar('users', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Quản lý người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('users') ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddUsers): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('users', 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsServices): ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('services', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('services') ?>"
                  class="nav-link <?php echo activeMenuSidebar('services', '', true) ? 'active' : false ?>">
                  <i class="nav-icon far fa-clone"></i>
                  <p>
                     Quản lý dịch vụ
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('services') ?>"
                        class="nav-link <?php echo activeMenuSidebar('services', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddServices): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('services', 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('services', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsPages): ?>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('pages', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('pages') ?>"
                  class="nav-link <?php echo activeMenuSidebar('pages', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                     Quản lý trang
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('pages') ?>"
                        class="nav-link <?php echo activeMenuSidebar('pages', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddPages): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('pages', 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('pages', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsPortfolios): ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('portfolios', '', true, 'portfolio_categories') ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('portfolios') ?>"
                  class="nav-link <?php echo activeMenuSidebar('portfolios', '', true, 'portfolio_categories') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-briefcase"></i>
                  <p>
                     Quản lý dự án
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('portfolios') ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolios', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddPortfolios): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('portfolios', 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolios', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; if($isListsPortfolioCategories): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('portfolio_categories') ?>"
                        class="nav-link <?php echo activeMenuSidebar('portfolio_categories') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh mục dự án</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsBlogs): ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('blogs') ?>"
                  class="nav-link <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-blog"></i>
                  <p>
                     Quản lý bài viết
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('blogs') ?>"
                        class="nav-link <?php echo activeMenuSidebar('blogs', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddBlogs): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('blogs', 'add') ?>"
                        class="nav-link <?php echo activeMenuSidebar('blogs', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; if($isListsBlogCategories): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('blog_categories') ?>"
                        class="nav-link <?php echo activeMenuSidebar('blog_categories') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh mục bài viết</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsContacts): ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('contacts', '', true, 'contact_types') ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('contacts') ?>"
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
                     <a href="<?php echo getLinkAdmin('contacts') ?>"
                        class="nav-link <?php echo activeMenuSidebar('contacts', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách
                           <span class="<?php echo getCountContacts() > 0 ? 'badge badge-danger' : 'd-none' ?>">
                              <?php echo getCountContacts() > 0 ? getCountContacts() : false ?>
                           </span>
                        </p>
                     </a>
                  </li>
                  <?php if($isListsContactTypes): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('contact_types') ?>"
                        class="nav-link <?php echo activeMenuSidebar('contact_types') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Loại liên hệ</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php endif; if($isListsComments): ?>
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
            <?php endif; if($isListsSubscribe): ?>
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
            <?php endif; if($isListsOptions): ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('options', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo getLinkAdmin('options') ?>"
                  class="nav-link <?php echo activeMenuSidebar('options', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                     Thiết lập
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <?php if($isOptionsGeneral): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'general') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'general') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập chung</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsHeader): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'header') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'header') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Header</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsFooter): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'footer') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'footer') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Footer</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsHome): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'home') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'home') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Trang chủ</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsAbout): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'about') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'about') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập giới thiệu</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsTeam): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'team') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'team') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập Team</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsServices): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'services') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'services') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập dịch vụ</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsPortfolios): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'portfolios') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'portfolios') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập dự án</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsBlogs): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'blogs') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'blogs') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập bài viết</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsContacts): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'contacts') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'contacts') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập liên hệ</p>
                     </a>
                  </li>
                  <?php endif; if($isOptionsMenu): ?>
                  <li class="nav-item">
                     <a href="<?php echo getLinkAdmin('options', 'menu') ?>"
                        class="nav-link <?php echo activeMenuSidebar('options', 'menu') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thiết lập menu</p>
                     </a>
                  </li>
                  <?php endif;?>
               </ul>
            </li>
            <?php endif; ?>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">