<?php
if(!defined('_INCODE')) die('Access denied...');
if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;
if($isRoot) {
  $checkPermission = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'options', 'home');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập trang chủ');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập trang chủ"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueSlider = [
      'slider_title' => 'tiêu đề',
      'slider_btn' => 'nút xem thêm',
      'slider_btn_link' => 'link nút xem thêm',
      'slider_youtube_link' => 'link Youtube',
      'slider_image_1' => 'ảnh 1',
      'slider_image_2' => 'ảnh 2',
      'slider_bg' => 'ảnh nền',
      'slider_desc' => 'mô tả',
      'slider_position' => 'vị trí'
   ];


   $arrValueFacts = [
      'facts_title' => 'tiêu đề',
      'facts_title_sub' => 'tiêu đề phụ',
      'facts_desc' => 'mô tả',
      'facts_button_title' => 'nội dung nút',
      'facts_button_link' => 'liên kết',
      'facts_item_desc' => 'thành tựu',
      'facts_item_icon' => 'icon',
      'facts_item_number' => 'sô lượng thành tựu',
      'facts_item_unit' => 'đơn vị tính',
   ];

   $arrValuePartners = [
      'partners_title' => 'tiêu đề',
      'partners_title_sub' => 'tiêu đề phụ',
      'partners_desc' => 'mô tả',
      'partners_imgs' => 'hình ảnh đối tác',
      'partners_links' => 'link đối tác',
   ];
   if(isGet()) {
      //get default slider
      $jsonDataSlider = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_slide'")['opt_value'];
      $arrSlider = json_decode($jsonDataSlider, true);
      // echo '<pre>';
      // print_r($arrSlider);
      // echo '</pre>';

      setFlashData('sliderDefault', $arrSlider);

      //get default fact
      $jsonDataFacts = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_facts'")['opt_value'];
      $homeFacts = json_decode($jsonDataFacts, true);
      setFlashData('factsDefault', $homeFacts);

      //get default partners
      $jsonDataPartners = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_partners'")['opt_value'];
      $homePartners = json_decode($jsonDataPartners, true);
      setFlashData('partnersDefault', $homePartners);
   }

   if(isPost()) {
            
      $errors = [];
      $arrSlider = [];
      $arrFacts = [];
      $arrFactsContent = [];
      $arrPartners = [];
      $arrPartnersContent = [];

      $body = getBody('post');

      //home_slide
      if(!empty(getBody('post')['home_slide'])) {
         $homeSlider = getBody('post')['home_slide'];
         
         foreach($homeSlider as $key => $value) {
            foreach($value as $k => $v) {
               $arrSlider[$k][$key] =$v ;
            }
         }
      }


      //home_fact
      if(!empty(getBody('post')['home_facts'])) {
         $homeFacts = getBody('post')['home_facts'];
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

      //xử lý lỗi của home_facts
      foreach($arrFactsContent as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValueFacts[$key];
         }
      }
      foreach($arrFacts as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v) && $k != 'facts_item_unit') {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueFacts[$k];
           }
           if($k == 'facts_item_number' && !isNumberInt($v)) {
            $errors[$k][$key]["number"] = 'Số lượng phải là số';
           } 
         }
      }   


      //xử lý lỗi của home_slide
      foreach($arrSlider as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueSlider[$k];
           }
         }
      }


      //home_partners
      if(!empty(getBody('post')['home_partners'])) {
         $homePartners = getBody('post')['home_partners'];
         foreach($homePartners as $key => $value) {
            if(is_array($value)) {
               foreach($value as $k => $v) {
                  $arrPartners[$k][$key] =$v ;
               }
            } else {
               $arrPartnersContent[$key] = $value;
            }
         }
      }

      //xử lý lỗi của home_partners
      foreach($arrPartnersContent as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValuePartners[$key];
         }
      }
      foreach($arrPartners as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValuePartners[$k];
           }
         }
      }   
      //home call to action
      $homeCtaContent = trim($body['home_cta_content']);
      $homeCtaBtn = trim($body['home_cta_btn']);
      $homeCtaBtnLink = trim($body['home_cta_btn_link']);

      if(empty($homeCtaContent)) {
         $errors['home_cta_content']['required'] = 'Không được để trống nội dung';
      }

      if(empty($homeCtaBtn)) {
         $errors['home_cta_btn']['required'] = 'Không được để trống nội dung nút';
      }

      if(empty($homeCtaBtnLink)) {
         $errors['home_cta_btn_link']['required'] = 'Không được để trống link nút';
      }
         


      if(empty($errors)) {
         $jsonSlider = json_encode($arrSlider);
         $jsonFacts = json_encode($homeFacts);
         $jsonPartners = json_encode($homePartners);
         
         // Không có lỗi xảy ra
         $dataSliderUpdate = [
            'opt_value' => $jsonSlider,
         ];
         $dataFactsUpdate = [
            'opt_value' => $jsonFacts,
         ];
         $dataPartnersUpdate = [
            'opt_value' => $jsonPartners,
         ];

         $updateSliderStatus = update('options', $dataSliderUpdate, "opt_key = 'home_slide'");
         $updateFactsStatus = update('options', $dataFactsUpdate, "opt_key = 'home_facts'");
         $updatePartnersStatus = update('options', $dataPartnersUpdate, "opt_key = 'home_partners'");
         updateOptions('home_cta');
         if($updateSliderStatus && $updateFactsStatus && $updatePartnersStatus) {
               setFlashData('msg', 'Chỉnh sửa trang chủ thành công.');
               setFlashData('msg_type', 'success');
         } else {
           setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=home');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('oldSlider', $arrSlider);
         setFlashData('oldFacts', $homeFacts);
         setFlashData('oldPartners', $homePartners);
         setFlashData('old', $body);
         redirect('admin/?module=options&action=home');
      }
   }

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $old = getFlashData('oldSlider');
   $oldFacts = getFlashData('oldFacts');
   $oldPartners = getFlashData('oldPartners');

   //old slider
   if(empty($old)) {
      $arrSlider = getFlashData('sliderDefault');
   } else {
      $arrSlider = $old;
   }

   //old fact
   if(empty($oldFacts)) {
      $homeFacts = getFlashData('factsDefault');
   } else {
      $homeFacts = $oldFacts;
   }
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

   //old partner
   if(empty($oldPartners)) {
      $homePartners = getFlashData('partnersDefault');
   } else {
      $homePartners = $oldPartners;
   }
   if(!empty($homePartners)) {
      foreach($homePartners as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrPartners[$k][$key] =$v ;
            }
         } else {
            $arrPartnersContent[$key] = $value;
         }
      }
   }
?>

<!-- <div class="container"> -->
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <?php
   require_once('contents/slider.php');
   require_once('contents/facts.php');
   require_once('contents/callToAction.php');
   require_once('contents/partners.php');
   ?>
   <div class="px-1 mb-2">
      <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
   </div>
</form>
<!-- </div> -->


<?php
   layout('footer', 'admin', $data);
?>