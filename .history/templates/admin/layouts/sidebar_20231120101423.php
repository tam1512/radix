<?php 
$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname FROM users WHERE id = $userId");
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
                  <i class="nav-icon fa-solid fa-users"></i>
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
                  <i class="nav-icon fa-solid fa-users"></i>
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
                  <i class="nav-icon fas fa-tachometer-alt"></i>
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
                  <i class="nav-icon fa fa-file"></i>
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
                  <i class="nav-icon fa fa-file"></i>
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
                        <p>Danh mục sản phẩm</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blogs" ?>"
                  class="nav-link <?php echo activeMenuSidebar('blogs', '', true, 'blog_categories') ? 'active' : false ?>">
                  <i class="nav-icon fa fa-file"></i>
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
               class="nav-item has-treeview <?php echo activeMenuSidebar('options', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=options" ?>"
                  class="nav-link <?php echo activeMenuSidebar('options', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fa fa-file"></i>
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