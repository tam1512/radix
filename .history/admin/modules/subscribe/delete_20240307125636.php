<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $commentId = $body['id'];
      $commentDetailRows = getRows("SELECT id FROM comments WHERE id = $commentId");
      if($commentDetailRows > 0) {
         $listComments = getRaw("SELECT * FROM comments");
         $arrCommentDelete = [];
         if(!empty(getCommentReply($listComments, $commentId))) {
            $arrCommentDelete = getCommentReply($listComments, $commentId);
         }
         $arrCommentDelete[] = $commentId;

         $jsonDelete = implode(', ', $arrCommentDelete);

         $deleteComment = delete('comments', "id IN($jsonDelete)");

         if($deleteComment) {
            setFlashData('msg','Xóa thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Liên hệ không tồn tại');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=comments');