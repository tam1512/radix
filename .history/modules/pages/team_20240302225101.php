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
         <?php foreach($arrMember as $item): ?>
         <div class="col-lg-3 col-md-6 col-12">
            <!-- Single Team -->
            <div class="single-team">
               <div class="t-head">
                  <img src="<?php echo $item['team_member_img'] ?>" alt="#">
                  <div class="t-icon">
                     <a href="#"><i class="fa fa-plus"></i></a>
                  </div>
               </div>
               <div class="t-bottom">
                  <p><?php echo $item['team_member_position'] ?></p>
                  <h2><?php echo $item['team_member_name'] ?></h2>
                  <ul class="t-social">
                     <li><a href="<?php echo $item['team_member_facebook'] ?>"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="<?php echo $item['team_member_twitter'] ?>"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="<?php echo $item['team_member_linkedin'] ?>"><i class="fa fa-linkedin"></i></a></li>
                     <li><a href="<?php echo $item['team_member_behance'] ?>"><i class="fa fa-behance"></i></a></li>
                  </ul>
               </div>
            </div>
            <!-- End Single Team -->
         </div>
         <?php endforeach; ?>
      </div>
      <?php endif; ?>
   </div>
</section>
<!--/ End team Us -->

<?php 
   if($isPage) {
      layout('footer', 'client', $data);
   }
?>