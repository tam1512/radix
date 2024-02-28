<?php 
   $jsonFacts = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_facts'")['opt_value'];
   $homeFacts = json_decode($jsonFacts, true);

   if(!empty($homeFacts)) {
      foreach($homeFacts as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrFacts[$k][$key] =$v ;
            }
         } else {
            $arrFactsContent[$key] = $value;
         }
      }
   }
   echo '<pre>';
   print_r($arrFacts);
   echo '</pre>';
?>

<!-- Fun Facts -->
<section id="fun-facts" class="fun-facts section">
   <div class="container">
      <?php if(!empty($arrFactsContent)): ?>
      <div class="row">
         <div class="col-lg-5 col-12 wow fadeInLeft" data-wow-delay="0.5s">
            <div class="text-content">
               <div class="section-title">
                  <h1>
                     <span><?php echo (!empty($arrFactsContent['facts_title_sub']) ? $arrFactsContent['facts_title_sub'] : false) ?></span><?php echo (!empty($arrFactsContent['facts_title']) ? $arrFactsContent['facts_title'] : false) ?>
                  </h1>
                  <p>
                     <?php echo (!empty($arrFactsContent['facts_desc']) ? html_entity_decode($arrFactsContent['facts_desc']) : false) ?>
                  </p>
                  <a href="<?php echo (!empty($arrFactsContent['facts_button_link']) ? $arrFactsContent['facts_button_link'] : false) ?>"
                     class="btn primary"><?php echo (!empty($arrFactsContent['facts_button_title']) ? $arrFactsContent['facts_button_title'] : false) ?></a>
               </div>
            </div>
         </div>
         <div class="col-lg-7 col-12">
            <div class="row">
               <?php 
                  if(!empty($arrFacts)): 
                     $time = 0.6;
                     foreach($arrFacts as $key=>$item):
               ?>
               <div class="col-lg-6 col-md-6 col-12 wow fadeIn" data-wow-delay="<?php echo $time; $time += 0.2 ?>s">
                  <!-- Single Fact -->
                  <div class="single-fact">
                     <div class="icon">
                        <?php echo (!empty($arrFacts[$key]['facts_item_icon']) ? html_entity_decode($arrFacts[$key]['facts_item_icon']) : false) ?>
                     </div>
                     <div class="counter">
                        <p><span
                              class="count"><?php echo (!empty($arrFacts[$key]['facts_item_number']) ? $arrFacts[$key]['facts_item_number'] : false) ?></span><?php echo (!empty($arrFacts[$key]['facts_item_unit']) ? $arrFacts[$key]['facts_item_unit'] : false) ?>
                        </p>
                        <h4>
                           <?php echo (!empty($arrFacts[$key]['facts_item_desc']) ? $arrFacts[$key]['facts_item_desc'] : false) ?>
                        </h4>
                     </div>
                  </div>
                  <!--/ End Single Fact -->
               </div>
               <?php endforeach; endif; ?>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<!--/ End Fun Facts -->