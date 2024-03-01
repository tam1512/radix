<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $portfolioId = $body['id'];
      $portfolioDetail = firstRaw("SELECT * FROM portfolios WHERE id = $portfolioId");
      if(!empty($portfolioDetail)) {
         $duplicate = $portfolioDetail['duplicate'];
         $duplicate++;
         $portfolioDetail['duplicate'] = 0;
         $portfolioDetail['user_id'] = isLogin()['user_id'];
         $portfolioDetail['create_at'] = date('Y-m-d H:i:s');
         $portfolioDetail['name'] .="($duplicate)"; 
         $portfolioDetail['slug'] .="$duplicate"; 

         unset($portfolioDetail['update_at']);
         unset($portfolioDetail['id']);

         $insertStatus = insert('portfolios', $portfolioDetail);
         if($insertStatus) {
            setFlashData('msg','Nhân bản thành công');
            setFlashData('msg_type', 'success');
            update('portfolios', [
               'duplicate' => $duplicate
            ], 'id='.$portfolioId);
         } else {
            setFlashData('msg','Lỗi hệ thống. Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Dự án không tồn tại');
         setFlashData('msg_type', 'danger');
      }
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=portfolios');