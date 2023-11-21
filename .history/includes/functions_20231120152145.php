<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Các hàm xử lý chung
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Hàm để reqired các layout
function layout($layoutName = 'header',$dir='', $data = []) {
  if(!empty($dir)) {
    $dir = '/'.$dir;
  }
   if(file_exists(_WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php')) {
      require_once _WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php';
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
function getBody($method="") {
  $bodyArr = [];
  $method = strtolower($method);
  if(empty($method)) {
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
  } else {
    if($method == 'get') {
      if(!empty($_GET)) {
        foreach ($_GET as $key => $value) {
          if(is_array($value)) { // kiểm tra xem $value có phải mảng không
            $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
          } else {
            $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
          }
  
        }
      }
    } else if($method == 'post') {
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
  $url = _WEB_HOST_ROOT.'/'.$path;
  header("location: $url");
  exit;
}

function isLogin() {
  if(!empty(getSession('login_token'))) {
    $loginToken = getSession('login_token');
    $queryLoginToken = firstRaw("SELECT id, user_id FROM login_token WHERE token = '$loginToken'");
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
  $user_id = isLogin()['user_id'];
  update('users', ['last_activity' => date('Y-m-d H:i:s')], 'id='.$user_id);
  setcookie('user_id', $user_id, time() + 60*_TIME_OUT_LOGIN, '/');
}

//Tự động xóa token khi người dùng không hoạt động _TIME_OUT_LOGIN phút hoặc thoát trình duyệt quá thời gian đó, nếu trong thời gian đó người dùng quay lại trang web thì sẽ tự động đăng nhập
function autoLogin() {
  if(!empty($_COOKIE['user_id'])) {
    $cookie_user = $_COOKIE['user_id'];
      $queryLoginToken = firstRaw("SELECT * FROM login_token WHERE user_id = '$cookie_user'");
      if(!empty($queryLoginToken)) {
          setSession('login_token', $queryLoginToken['token']);
      }
  }
}

//Tự động xóa login_token sau một khoản thời gian không hoạt động
function autoRemoveLoginToken() {
  $user_id = isLogin()['user_id'];
  $queryUser = firstRaw("SELECT last_activity FROM users WHERE id = $user_id");
  $last_activity = $queryUser['last_activity'];
  $now = date('Y-m-d H:i:s');
  $diff = strtotime($now) - strtotime($last_activity);
  $diff = floor($diff/60);
  if($diff >= _TIME_OUT_LOGIN) {
    delete('login_token', "user_id=$user_id");
    setcookie('user_id', $user_id, time()-60, '/');
    return true;
  }
  return false;
}

//Action menu sidebar (active and menu-open) 
/**
 * kiểu tra với đường dẫn phương thức GET
 * 1. module đúng sẽ active child đầu tiên
 * 2. module và action đúng sẽ active child của action đó
 * 3. nếu không có module sẽ active mặc định
 * 4. nếu child có sub, truyền vào tham số sub là mảng, các action = với một trong các tham số sẽ được tính là đúng
 * 5. nếu một module nằm trong 1 module khác sử dụng biến $moduleSub để kích hoạt
 */
function activeMenuSidebar($module, $action='', $sub = false, $moduleSub = '') { //service add
  if(empty(getBody()['module']) && empty($module)) {
    return true;
  } else {
    if(!empty(getBody()['action'])) {
      if(!empty($module)) {
        if(strpos(getBody()['module'], $module) !== false && getBody()["action"] == $action) {
          return true;
        }
        if(strpos(getBody()['module'], $module) !== false && $sub && !is_array($sub)) {
          return true;
        }
        if(!empty($sub) && is_array($sub)) {
          foreach($sub as $item) {
            if(strpos(getBody()['module'], $module) !== false && getBody()["action"] == $item) {
              return true;
            }
          }
        }
      }
    } else {
      if(!empty(getBody()['module']) && !empty($module)) {
        if(strpos(getBody()['module'], $module) !== false && empty($action)) {
          return true;
        }
      }
      if(!empty(getBody()["module"])) {
        // echo getBody()["module"];
        if(getBody()['module'] == $moduleSub) {
          return true;
        }
      }
    }
  }
  
  return false;
}

//Get link admin
function getLinkAdmin($module, $action = "", $params = []) {
  $url = _WEB_HOST_ROOT_ADMIN;
  if(!empty($module)) {
    $url .= "/?module=$module";
  }

  if(!empty($action)) {
    $url.= "&action=$action";
  }

  /**
   * $params = ['id' => 1, 'keyword' => 'unicode']
   * => paramString = id=1&keyword=unicode
   */
  if(!empty($params)) {
    $paramString = http_build_query($params);
    $url.="&$paramString";
  }
  return $url;
}

//Format date
function getDateFormat($dateStr, $format) {
  $dateObject = date_create($dateStr);
  if(!empty($dateObject)) {
    return date_format($dateObject, $format);
  }
  return false;
}

//Check icon
function isIcon($input) {
  if(strpos($input, '<i class="') != false) {
    return true;
  }
  return false;
}

function getNameUserUniqueOrId($listUser, $input) {
  if(!empty($listUser)) {
    foreach($listUser as $user) {
      if(!empty($input)) {
        if(isNumberInt($input)) {
          if($user['id'] == $input) {
            $fullname = $user['fullname'];
            $email = $user['email'];
            return $fullname."($email)";
          }
        } else if(is_string($input)) {
          $input = rtrim($input, ")");
          $inputArray = explode('(', $input);
          $fullname = $inputArray[0];
          $email = $inputArray[1];
          if($user['fullname'] == $fullname && $user['email'] == $email) {
            return $user['id'];
          }
        }
      }
    }
  }
  return false;
}

//set_exception_handler
function setExceptionError($e) {
  if(empty(getSession('debug_error'))) {
    setSession('debug_error', [
      "error_code" => $e->getCode(),
      "error_message" => $e->getMessage(),
      "error_file" => $e->getFile(),
      "error_line" => $e->getLine()
    ]);
  }

  $isReload = getSession('reload');
  if(empty($isReload)) {
    setSession('reload', 1);
    redirect(getPathAdmin());
  } else {
    removeSession('reload');
    removeSession('debug_error');
  }
}

// Tạo ra session và exception để hiển thị một cách độc lập (do mặc định là lỗi ở đâu thì sẽ hiển thị ở đó, khó kiểm soát không chuyên nghiệp)
function setErrorHandler($errno, $errstr, $errfile, $errline) {
  // tạo exception để set_exception_handler bắt được và hiển thị ra
  if(!_DEBUG) {
    return;
  }

  setSession('debug_error', [
    "error_code" => $errno,
    "error_message" => $errstr,
    "error_file" => $errfile,
    "error_line" => $errline
  ]);
 throw new ErrorException($errstr, $errno, 1, $errfile, $errline);
}

function loadExceptionError() {
  if(!empty(getSession('debug_error'))) {
    if(_DEBUG) {
      $exception = getSession('debug_error');
      require_once _WEB_PATH_ROOT.'/modules/errors/exception.php';
    } else {
      require_once _WEB_PATH_ROOT.'/modules/errors/500.php';
    }
 } 
}

function getPathAdmin() {
  $path = "admin";
  if(!empty($_SERVER["QUERY_STRING"])) {
    $path.='?'.trim($_SERVER["QUERY_STRING"]);
  }
  return $path;
}

function updateOptions() {
  if(isPost()){
    $body = getBody('post');
    $countUpdate = 0;
    if(!empty($body)) {
      foreach($body as $key => $value) {
        $condition = "opt_key = '$key'";
        $dataUpdate = [
          "opt_value" => trim($value)
        ];
        $updateStatus = update('options', $dataUpdate, $condition);
        if($updateStatus) {
          $countUpdate++;
        }
      }
    }
    if($countUpdate > 0) {
      setFlashData('msg', "Đã cập nhật $countUpdate bản ghi thành công.");
      setFlashData('msg_type', "success");
    } else {
      setFlashData('msg', "Cập nhật không thành công.");
      setFlashData('msg_type', "error");
    }
    redirect(getPathAdmin());
  }
}

function getOption($key, $type="") {
    $sql = "SELECT * FROM options WHERE opt_key = '$key'";
    $option = firstRaw($sql);
    if(!empty($option)) {
      if($type == 'label') {
        return $option['name'];
      }
      return $option['opt_value'];
    }
}

function renderOptions($prefixKey) {
  $html = '';
  if(!empty($prefixKey)) {
    $sql = "SELECT * FROM options WHERE opt_key LIKE '%$prefixKey%'";
    $options = getRaw($sql);
    if(!empty($options)) {
      foreach($options as $option) {
        $key = trim($option['opt_key']);
        $value = trim($option['opt_value']);
        $name = trim($option['name']);
        $html .= '<div class="form-group">
                    <label for="'.$key.'">'.$name.'</label>
                    <input type="text" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="'.$name.'..." value="'.$value.'">
                  </div>';
      }
    }
  }
  if(!empty($html)) {
    return $html;
  }
  return false;
}

function handleQueryString($module, $page) {
  $queryStr = null;
  if(!empty($_SERVER["QUERY_STRING"])) {
    $queryStr = $_SERVER["QUERY_STRING"];
    $queryStr = str_replace('module='.$module, '', $queryStr);
    $queryStr = str_replace('page='.$page, '', $queryStr);
    $queryStr = trim($queryStr, '&');
    if(!empty($queryStr)) {
        $queryStr = '&'.$queryStr;
    }
  } 
  return $queryStr;
}