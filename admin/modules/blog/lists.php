<?php 
   $data = [
      'title' => 'Danh sách Blog'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);
?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th>Tiêu đề</th>
               <th>Danh mục</th>
               <th>Thời gian</th>
               <th width="5%">STT</th>
               <th width="5%">STT</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>1</td>
               <td>1</td>
               <td>1</td>
               <td>1</td>
               <td>1</td>
               <td>1</td>
            </tr>
         </tbody>
      </table>
   </div><!-- /.container-fluid -->
</section>
<?php
   layout('footer', 'admin', $data);
?>