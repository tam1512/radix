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
                  <i class="nav-icon fas fa-tachometer-alt"></i>
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
                  <i class="nav-icon fas fa-tachometer-alt"></i>
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
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('blog', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blog" ?>"
                  class="nav-link <?php echo activeMenuSidebar('blog', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Danh mục Blog
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blog" ?>"
                        class="nav-link <?php echo activeMenuSidebar('blog', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=blog&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('blog', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                     Quản lý Blog
                     <i class="fas fa-angle-left right"></i>
                     <span class="badge badge-info right">2</span>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>

               </ul>
            </li>
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                     Widgets
                     <span class="right badge badge-danger">New</span>
                  </p>
               </a>
            </li>
            <li class="nav-header">EXAMPLES</li>
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                     Calendar
                  </p>
               </a>
            </li>

            <li class="nav-header">LABELS</li>
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p class="text">Important</p>
               </a>
            </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">