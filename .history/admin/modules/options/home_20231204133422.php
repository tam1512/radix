<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
   if(!defined('_INCODE')) die('Access denied...');

   $data = [
      'title' => "Thiết lập trang chủ"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listSliderCurrent = getOption('home_slide');

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
      $arrAbout = json_decode($jsonDataAbout, true);
      setFlashData('homeDefault', $arrAbout);
   }

   if(isPost()) {
            
      $errors = [];
      $arrSlider = [];
      $arrAbout = [];
      $arrAboutProgress = [];
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


      //xử lý lỗi của home_slide
      foreach($arrSlider as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueSlider[$k];
           }
         }
      }

         
      if(empty($errors)) {
         $jsonSlider = json_encode($arrSlider);
         
         // Không có lỗi xảy ra
         $dataUpdate = [
            'opt_value' => $jsonSlider,
         ];

         $updateStatus = update('options', $dataUpdate, "opt_key = 'home_slide'");
         if($updateStatus) {
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
         setFlashData('oldAbout', $arrAbout);
         setFlashData('oldAboutProgress', $arrAboutProgress);
         setFlashData('body', getBody('post')['home_about']);
         redirect('admin/?module=options&action=home');
      }
   }

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $old = getFlashData('oldSlider');
   $oldAbout = getFlashData('oldAbout');
   $oldAboutProgress = getFlashData('oldAboutProgress');
   $body = getFlashData('body');
   if(empty($old)) {
      $arrSlider = getFlashData('sliderDefault');
   } else {
      $arrSlider = $old;
   }
   echo '<pre>';
   print_r($errors);
   echo '</pre>';
?>

<!-- <div class="container"> -->
<form action="" method="post">
   <?php 
      getMsg($msg, $msgType);
   ?>
   <?php
   require_once('contents/slider.php');
   require_once('contents/about.php');
   ?>
   <div class="px-1">
      <button class="btn btn-primary" type="submit">Cập nhật</button>
   </div>
</form>
<!-- </div> -->


<?php
   layout('footer', 'admin', $data);
?>