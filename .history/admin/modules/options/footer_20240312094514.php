<?php
// CHỨC NĂNG THIẾT LẬP CHUNG
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
  $checkPermission = checkPermission($permissionData, 'footer', 'lists');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Thiết lập Footer');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

   $data = [
      'title' => "Thiết lập Footer"
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $arrValueFooter2 = [
      'footer_2_title' => 'tiêu đề',
      'footer_2_qick_link_content' => 'Nội dung liên kết',
      'footer_2_qick_link' => 'link liên kết',
   ];

   if(isGet()) {
      //get default slider
      $jsonDataFooter2 = firstRaw("SELECT opt_value FROM options WHERE opt_key = 'footer_2'")['opt_value'];
      $arrFooter2 = json_decode($jsonDataFooter2, true);

      setFlashData('footer2Default', $arrFooter2);
   }

   if(isPost()) {
            
      $errors = [];
      $arrFooter2 = [];
      $arrQuickLinks = [];

      $body = getBody('post');

      //footer_2
      if(!empty(getBody('post')['footer_2'])) {
         $footer2 = getBody('post')['footer_2'];
         foreach($footer2 as $key => $value) {
            if(is_array($value)) {
               foreach($value as $k => $v) {
                  $arrQuickLinks[$k][$key] =$v ;
               }
            } else {
               $arrFooter2[$key] = $value;
            }
         }
      }

      //xử lý lỗi của home_about
      foreach($arrFooter2 as $key => $value) {
         if(empty($value)) {
            $errors[$key]['required'] = "Không được để trống ".$arrValueFooter2[$key];
         }
      }
      foreach($arrQuickLinks as $key => $value) {
         foreach($value as $k => $v) {
           if(empty($v)) {
            $errors[$k][$key]["required"] = "Không được để trống ".$arrValueFooter2[$k];
           }
         }
      }  

      //footer 1
      $footer1Title = trim($body['footer_1_title']);
      $footer1Content = trim($body['footer_1_content']);

      if(empty($footer1Title)) {
         $errors['footer_1_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($footer1Content)) {
         $errors['footer_1_content']['required'] = 'Không được để trống nội dung';
      }

      //footer 4
      $footer4Title = trim($body['footer_4_title']);
      $footer4Content = trim($body['footer_4_content']);

      if(empty($footer4Title)) {
         $errors['footer_4_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($footer4Content)) {
         $errors['footer_4_content']['required'] = 'Không được để trống nội dung';
      }

      //footer 3
      $footer3Title = trim($body['footer_3_title']);
      $footer3Twitter = trim($body['footer_3_twitter']);

      if(empty($footer3Title)) {
         $errors['footer_3_title']['required'] = 'Không được để trống tiêu đề';
      }

      if(empty($footer3Twitter)) {
         $errors['footer_3_twitter']['required'] = 'Không được để trống tài khoản twitter';
      }

      //copyright
      $copyrightContent = trim($body['copyright_content']);

      if(empty($copyrightContent)) {
         $errors['copyright_content']['required'] = 'Không được để trống copyright';
      }

      if(empty($errors)) {
         $jsonFooter2 = json_encode($footer2);
         
         // Không có lỗi xảy ra
         $dataFooter2Update = [
            'opt_value' => $jsonFooter2,
         ];

         $updateFooter2Status = update('options', $dataFooter2Update, "opt_key = 'footer_2'");
         updateOptions('footer_1');
         updateOptions('footer_3');
         updateOptions('footer_4');
         updateOptions('copyright');
         if($updateFooter2Status) {
               setFlashData('msg', 'Chỉnh sửa footer thành công.');
               setFlashData('msg_type', 'success');
         } else {
           setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger'); 
         }
         redirect('admin/?module=options&action=footer');
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
         setFlashData('msg_type', 'danger');
         setFlashData('errors', $errors);
         setFlashData('oldFooter2', $footer2);
         redirect('admin/?module=options&action=footer');
      }
   }

   $msg = getFlashData('msg');
   $msgType = getFlashData('msg_type');

   $errors = getFlashData('errors');
   $oldFooter2 = getFlashData('oldFooter2');

   //old about
   if(empty($oldFooter2)) {
      $footer2 = getFlashData('footer2Default');
   } else {
      $footer2 = $oldFooter2;
   }
   if(!empty($footer2)) {
      foreach($footer2 as $key => $value) {
         if(is_array($value)) {
            foreach($value as $k => $v) {
               $arrQuickLinks[$k][$key] =$v ;
            }
         } else {
            $arrFooter2[$key] = $value;
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
   require_once('contents/footer_1.php');
   require_once('contents/footer_2.php');
   require_once('contents/footer_3.php');
   require_once('contents/footer_4.php');
   require_once('contents/copyright.php');
   ?>
   <div class="px-1 mb-2">
      <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
   </div>
</form>
<!-- </div> -->


<?php
   layout('footer', 'admin', $data);
?>