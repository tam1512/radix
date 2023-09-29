<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Các hàm xử lý chung
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Hàm để reqired các layout
 function layout($layoutName = 'header', $data = []) {
   if(file_exists(_WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php')) {
      require_once _WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php';
   }
 }

 // Hàm dùng để gửi mail tự động (quên mật khẩu, kích hoạt tài khoản)
 function sendMail($to, $subject, $content) {
  //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tamtt1512@gmail.com';                     //SMTP username
    $mail->Password   = 'kctt nfxn qipj mnry';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('tamtt1512@gmail.com', 'Tôn Thành Tâm');
    $mail->addAddress($to);     //Add a recipient
    // $mail->addReplyTo($to, $content_mail); // Xác định email sẽ được thêm vào phần trả lời

    //Content
    $mail->isHTML(true);     
    $mail->CharSet = 'utf8';                             //Set email format to HTML
    $mail->Subject = $subject; // Tiêu đề email
    $mail->Body    = $content; // Nội dung email

    return $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 }

// Kiểm tra phương thức Post
function isPost() {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    return true;
  }

  return false;
}

// Kiểm tra phương thức Get
function isGet() {
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    return true;
  }
  return false;
}

// Lấy giá trị phương thức POST, GET
function getBody() {
  $bodyArr = [];
  if(isGet()) {
    if(!empty($_GET)) {
      foreach ($_GET as $key => $value) {
        if(is_array($value)) { // kiểm tra xem $value có phải mảng không
          $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
        } else {
          $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
        }

      }
    }
  }
  if(isPost()) {
    if(!empty($_POST)) {
      foreach ($_POST as $key => $value) {
        if(is_array($value)) { 
          $bodyArr[strip_tags($key)] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); 
        } else {
          $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS); 
        }

      }
    }
  }
  return $bodyArr;
}

// kiểm tra email
function isEmail($email) {
  $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
  return $checkEmail; // đúng trả về giá trị email, sai trả về false
}

// Kiểm tra số nguyên 
function isNumberInt($number, $range = []) {
/**
 * $range = [
  * 'min_range' => 1,
  * 'max_range' => 10
 * ]
 */
  $checkNumber = null;
  if(!empty($range)) {
    $option = ['options' => $range];
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $option);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
  }

  return $checkNumber;
}
// Kiểm tra số thực
function isNumberFloat($number, $range = []) {
  $checkNumber = null;
  if(!empty($range)) {
    $option = ['options' => $range];
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $option);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
  }

  return $checkNumber;
}

//Kiểm tra số điện thoại, bắt đầu bằng số không, 10 chữ số
function isPhone($phone) {
  $checkZeroFirst = false;
  if($phone[0] == '0') {
    $checkZeroFirst = true;
    $phone = substr($phone, 1);
  }

  $checkNumberLast = false;
  
  if(isNumberInt($phone) && strlen($phone) == 9) {
    $checkNumberLast = true;
  }

  if($checkZeroFirst && $checkNumberLast) {
    return true;
  }

  return false;
}

//Hàm lấy thông báo
function getMsg($message, $type = 'success') {
  if(!empty($message)) {
    echo '<div class="text-center alert alert-'.$type.'">';
    echo $message;
    echo '</div>';
  }
}

function form_error($fieldName, $errors, $beforeHtml = '', $afterHtml = '') {
  if(!empty($errors[$fieldName])) {
   return $beforeHtml . reset($errors[$fieldName]) . $afterHtml;
  }
}
function form_infor($fieldName, $infor) {
  if(!empty($infor[$fieldName])) {
   return $infor[$fieldName];
  }
}

function old($fieldName, $oldData, $default = null) {
    if(!empty($oldData[$fieldName])) {
      return $oldData[$fieldName];
     } else {
      return $default;
     }
}

function redirect($path = 'index.php') {
  header("location: $path");
  exit;
}

function isLogin() {
  if(!empty(getSession('login_token'))) {
    $loginToken = getSession('login_token');
    $queryLoginToken = firstRaw("SELECT id, userId FROM logintoken WHERE token = '$loginToken'");
    if(!empty($queryLoginToken)) {
      return $queryLoginToken;
    } else {
      removeSession('login_token');
    }
  } 
  return false;
}


//Lưu lại thời gian cuối cùng hoạt động
function saveActivity() {
  $userId = isLogin()['userId'];
  update('users', ['lastActivity' => date('Y-m-d H:i:s')], 'id='.$userId);
  setcookie('userId', $userId, time() + 60*_TIME_OUT_LOGIN, '/');
}

//Tự động xóa token khi người dùng không hoạt động _TIME_OUT_LOGIN phút hoặc thoát trình duyệt quá thời gian đó, nếu trong thời gian đó người dùng quay lại trang web thì sẽ tự động đăng nhập
function autoLogin() {
  if(!empty($_COOKIE['userId'])) {
    $cookie_user = $_COOKIE['userId'];
    if(!empty($cookie_user)) {
      $queryLoginToken = firstRaw("SELECT * FROM logintoken WHERE userId = '$cookie_user'");
      if(!empty($queryLoginToken)) {
          setSession('login_token', $queryLoginToken['token']);
      }
    }
  }
}

//Tự động xóa logintoken sau một khoản thời gian không hoạt động
function autoRemoveLoginToken() {
  $userId = isLogin()['userId'];
  $queryUser = firstRaw("SELECT lastActivity FROM users WHERE id = $userId");
  $lastActivity = $queryUser['lastActivity'];
  $now = date('Y-m-d H:i:s');
  $diff = strtotime($now) - strtotime($lastActivity);
  $diff = floor($diff/60);
  if($diff >= _TIME_OUT_LOGIN) {
    delete('logintoken', "userId=$userId");
    setcookie('userId', $userId, time()-60);
    return true;
  }
  return false;
}