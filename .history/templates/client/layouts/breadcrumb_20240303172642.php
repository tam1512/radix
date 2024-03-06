	<!-- Breadcrumbs -->
	<section class="breadcrumbs">
	   <div class="container">
	      <div class="row">
	         <div class="col-12">
	            <h2><i class="fa fa-pencil"></i><?php echo $data['title'] ?></h2>
	            <ul>
	               <li><a href="<?php echo _WEB_HOST_ROOT ?>"><i class="fa fa-home"></i>Home</a></li>
	               <?php 
							echo !empty($data['parent']) ? '<li><a href="'.getLinkClient($data['parent']).'"><i class="fa fa-clone"></i>'.$data['parent'].'</a></li>' : false;
						?>
	               <li class="active"><a href="#"><i class="fa fa-clone"></i><?php echo $data['name'] ?></a></li>
	            </ul>
	         </div>
	      </div>
	   </div>
	</section>
	<!--/ End Breadcrumbs -->