<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

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

   $arrValueAbout = [
      'about_title' => 'tiêu đề',
      'about_content' => 'nội dung',
      'about_content_title' => 'tiêu đề nội dung',
      'about_youtube_link' => 'link Youtube',
      'about_image' => 'ảnh',
      'about_desc' => 'mô tả',
      'about_progress_name' => 'tên công việc',
      'progress-range' => 'phạm vi tiến hành'
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

      //get default about
      $jsonDataAbout = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'home_about'")['opt_value'];
      $homeAbout = json_decode($jsonDataAbout, true);
      setFlashData('aboutDefault', $homeAbout);

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
      $arrAbout = [];
      $arrFacts = [];
      $arrFactsContent = [];
      $arrPartners = [];
      $arrPartnersContent = [];
      $arrAboutProgress = [];

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

      //home_about
      if(!empty(getBody('post')['home_about'])) {
         $homeAbout = getBody('post')['home_about'];
         foreach($homeAbout as $key => $value) {
            if(is_array($value)) {
               foreach($value as $k => $v) {
                  $arrAboutProgress[$k][$key] =$v ;
               }
            } else {
               $arrAbout[$key] = $value;
            }
         }
      }

      //xử lý lỗi của home_about
      foreach($arrAbout as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValueAbout[$key];
         }
      }
      foreach($arrAboutProgress as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueAbout[$k];
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


      //home services
      $homeServicesTitleBg = trim($body['home_services_title-bg']);
      $homeServicesTitle = trim($body['home_services_title']);
      $homeServicesContent = trim($body['home_services_content']);

      if(empty($homeServicesTitleBg)) {
         $errors['home_services_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($homeServicesTitle)) {
         $errors['home_services_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($homeServicesContent)) {
         $errors['home_services_content']['required'] = 'Không được để trống nội dung';
      }

      //home portfolios
      $homePortfoliosTitleBg = trim($body['home_portfolios_title-bg']);
      $homePortfoliosTitle = trim($body['home_portfolios_title']);
      $homePortfoliosContent = trim($body['home_portfolios_content']);
      $homePortfoliosBtn = trim($body['home_portfolios_btn']);
      $homePortfoliosBtnLink = trim($body['home_portfolios_btn_link']);

      if(empty($homePortfoliosTitleBg)) {
         $errors['home_portfolios_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($homePortfoliosTitle)) {
         $errors['home_portfolios_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($homePortfoliosContent)) {
         $errors['home_portfolios_content']['required'] = 'Không được để trống nội dung';
      }

      if(empty($homePortfoliosBtn)) {
         $errors['home_portfolios_btn']['required'] = 'Không được để trống nội dung nút';
      }

      if(empty($homePortfoliosBtnLink)) {
         $errors['home_portfolios_btn_link']['required'] = 'Không được để trống link nút';
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
         

      
      //home blogs
      $homeBlogsTitleBg = trim($body['home_blogs_title-bg']);
      $homeBlogsTitle = trim($body['home_blogs_title']);
      $homeBlogsContent = trim($body['home_blogs_content']);

      if(empty($homeBlogsTitleBg)) {
         $errors['home_blogs_title-bg']['required'] = 'Không được để trống tiêu đề nền';
      }

      if(empty($homeBlogsTitle)) {
         $errors['home_blogs_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($homeBlogsContent)) {
         $errors['home_blogs_content']['required'] = 'Không được để trống nội dung';
      }

      if(empty($errors)) {
         $jsonSlider = json_encode($arrSlider);
         $jsonAbout = json_encode($homeAbout);
         $jsonFacts = json_encode($homeFacts);
         $jsonPartners = json_encode($homePartners);
         
         // Không có lỗi xảy ra
         $dataSliderUpdate = [
            'opt_value' => $jsonSlider,
         ];
         $dataAboutUpdate = [
            'opt_value' => $jsonAbout,
         ];
         $dataFactsUpdate = [
            'opt_value' => $jsonFacts,
         ];
         $dataPartnersUpdate = [
            'opt_value' => $jsonPartners,
         ];

         $updateSliderStatus = update('options', $dataSliderUpdate, "opt_key = 'home_slide'");
         $updateAboutStatus = update('options', $dataAboutUpdate, "opt_key = 'home_about'");
         $updateFactsStatus = update('options', $dataFactsUpdate, "opt_key = 'home_facts'");
         $updatePartnersStatus = update('options', $dataPartnersUpdate, "opt_key = 'home_partners'");
         updateOptions('home_services');
         updateOptions('home_portfolios');
         updateOptions('home_cta');
         updateOptions('home_blogs');
         if($updateSliderStatus && $updateAboutStatus && $updateFactsStatus && $updatePartnersStatus) {
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
         setFlashData('oldAbout', $homeAbout);
         setFlashData('oldFacts', $homeFacts);
         setFlashData('oldPartners', $homePartners);
         setFlashData('old', $body);
         setFlashData('body', getBody('post')['home_about']);
         redirect('admin/?module=options&action=home');
      }
   }

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $old = getFlashData('oldSlider');
   $oldAbout = getFlashData('oldAbout');
   $oldFacts = getFlashData('oldFacts');
   $oldPartners = getFlashData('oldPartners');
   $body = getFlashData('body');

   //old slider
   if(empty($old)) {
      $arrSlider = getFlashData('sliderDefault');
   } else {
      $arrSlider = $old;
   }

   //old about
   if(empty($oldAbout)) {
      $homeAbout = getFlashData('aboutDefault');
   } else {
      $homeAbout = $oldAbout;
   }
   if(!empty($homeAbout)) {
      foreach($homeAbout as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrAboutProgress[$k][$key] =$v ;
            }
         } else {
            $arrAbout[$key] = $value;
         }
      }
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
   require_once('contents/about.php');
   require_once('contents/services.php');
   require_once('contents/facts.php');
   require_once('contents/portfolios.php');
   require_once('contents/callToAction.php');
   require_once('contents/blogs.php');
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