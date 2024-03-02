<?php 
   $jsonTeam = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'page_team'")['opt_value'];
   $pageTeam = json_decode($jsonTeam, true);

   if(!empty($pageTeam)) {
      foreach($pageTeam as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrMember[$k][$key] =$v ;
            }
         } else {
            $arrTeam[$key] = $value;
         }
      }
   }

   
   $isPage = false;
   if(empty($data)) {
      $data = [
         'title' => $pageTeam['team_title_page'],
         'name' => 'Team'
      ];
      $isPage = true;

      layout('header', 'client', $data);
      layout('breadcrumb', 'client', $data);
   }
?>

<!-- team Us -->
<section class="team-us section">
   <div class="container">
      <?php if(!empty($arrTeam)): ?>
      <div class="row">
         <div class="col-12">
            <div class="section-title wow fadeInUp">
               <span
                  class="title-bg"><?php echo (!empty($arrTeam['team_title_bg']) ? $arrTeam['team_title_bg'] : false) ?></span>
               <h1><?php echo (!empty($arrTeam['team_title']) ? $arrTeam['team_title'] : false) ?></h1>
               <p>
                  <?php echo (!empty($arrTeam['team_desc']) ? html_entity_decode($arrTeam['team_desc']) : false) ?>
               </p>
               <p></p>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <?php if(!empty($arrMember)): ?>
      <div class="row">
         <div class="col-lg-3 col-md-6 col-12">
            <!-- Single Team -->
            <div class="single-team">
               <div class="t-head">
                  <img src="images/t2.jpg" alt="#">
                  <div class="t-icon">
                     <a href="team-single.html"><i class="fa fa-plus"></i></a>
                  </div>
               </div>
               <div class="t-bottom">
                  <p>Founder</p>
                  <h2>Collis Molate</h2>
                  <ul class="t-social">
                     <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                     <li><a href="#"><i class="fa fa-behance"></i></a></li>
                  </ul>
               </div>
            </div>
            <!-- End Single Team -->
            <div class="progress-main">
               <div class="row">
                  <?php foreach($arrMember as $key => $value): ?>
                  <div class="col-lg-6 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.4s">
                     <!-- Single Skill -->
                     <div class="single-progress">
                        <h4>
                           <?php echo (!empty($value['team_progress_name']) ? $value['team_progress_name'] : false) ?>
                        </h4>
                        <div class="progress">
                           <div class="progress-bar" role="progressbar"
                              style="width: <?php echo (!empty($value['progress-range']) ? $value['progress-range'] : false) ?>%"
                              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                              <span
                                 class="percent"><?php echo (!empty($value['progress-range']) ? $value['progress-range'] : false) ?>%</span>
                           </div>
                        </div>
                     </div>
                     <!--/ End Single Skill -->
                  </div>
                  <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<!--/ End team Us -->

<?php 
   if($isPage) {
      require_once(_WEB_PATH_ROOT."/modules/home/contents/partners.php");
      layout('footer', 'client', $data);
   }
?>