<?php 
if(!defined('_INCODE')) die('Access denied...');
if(!isLogin()) {
   redirect("admin?module=auth&action=login");
 }

   //Lấy userID
   $userId = isLogin()['user_id'];

   $data = [
      'title' => 'Tổng quan'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $message = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $quantityUsers = getRows("SELECT * FROM users WHERE status = 1");
   $quantityServices = getRows("SELECT * FROM services");
   $quantityPortfolios = getRows("SELECT * FROM portfolios");
   $quantityBlogs = getRows("SELECT * FROM blogs");
   $quantityContacts = getRows("SELECT * FROM contacts WHERE status = 0");
   $quantityComments = getRows("SELECT * FROM comments WHERE status = 0");
   $quantitySubscribe = getRows("SELECT * FROM subscribe WHERE status = 0");
?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <?php 
         getMsg($message, $msgType);
      ?>
      <div class="row">
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
               <div class="inner">
                  <h3><?php echo $quantityUsers ?></h3>

                  <p>Người dùng</p>
               </div>
               <div class="icon">
                  <i class="fas fa-user"></i>
               </div>
               <a href="<?php echo getLinkAdmin('users') ?>" class="small-box-footer">Xem thêm <i
                     class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
               <div class="inner">
                  <h3><?php echo $quantityServices ?></h3>

                  <p>Dịch vụ</p>
               </div>
               <div class="icon">
                  <i class="ion far fa-clone"></i>
               </div>
               <a href="<?php echo getLinkAdmin('services') ?>" class="small-box-footer">Xem thêm <i
                     class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
               <div class="inner">
                  <h3><?php echo $quantityPortfolios ?></h3>

                  <p>Dự án</p>
               </div>
               <div class="icon">
                  <i class="fas fa-briefcase"></i>
               </div>
               <a href="<?php echo getLinkAdmin('portfolios') ?>" class="small-box-footer">Xem thêm <i
                     class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3><?php echo $quantityBlogs ?></h3>

                  <p>Bài viết</p>
               </div>
               <div class="icon">
                  <i class="fas fa-blog"></i>
               </div>
               <a href="<?php echo getLinkAdmin('blogs') ?>" class="small-box-footer">Xem thêm <i
                     class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
               </div>
               <div class="icon">
                  <i class="ion ion-pie-graph"></i>
               </div>
               <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
               </div>
               <div class="icon">
                  <i class="ion ion-pie-graph"></i>
               </div>
               <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
               </div>
               <div class="icon">
                  <i class="ion ion-pie-graph"></i>
               </div>
               <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
      </div>
      <!-- /.row -->
   </div><!-- /.container-fluid -->
</section>
<?php

   layout('footer', 'admin', $data);
?>