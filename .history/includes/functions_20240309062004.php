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
            $bodyArr[strip_tags($key)] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            // $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
          } else {
            $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
            // $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
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
            $bodyArr[strip_tags($key)] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            // $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
          } else {
            $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
            // $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
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

function redirect($path = 'index.php', $isFull = false) {
  if($isFull) {
    $url = $path;
  } else {
    $url = _WEB_HOST_ROOT.'/'.$path;
  }
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

//Get link client
function getLinkClient($module='', $action = "", $params = []) {
  $arrModule = [
    'home' => '/',
    'blogs' => 'bai-viet',
    'services' => 'dich-vu',
    'portfolios' => 'du-an',
    'pages' => 'gioi-thieu',
    'contact' => 'lien-he'
  ];

  $arrAction = [
    'about' => 'chung-toi',
    'team' => 'doi-ngu'
  ];
  $module = strtolower($module);
  $url = _WEB_HOST_ROOT;
  if(!empty($arrModule[$module])) {
    $url .= "/".$arrModule[$module];
  }

  if(!empty($arrAction[$action])) {
    $url.= "/".$arrAction[$action];
  }

  /**
   * $params = ['id' => 1, 'keyword' => 'unicode']
   * => paramString = id=1&keyword=unicode
   */
  if(!empty($params)) {
    $paramString = http_build_query($params);
    $url.="/?$paramString";
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
  $input = html_entity_decode($input);
  if(strpos($input, '<i class="') !== false) {
    return $input;
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
  $break = false;
  if(empty(getSession('quantity_error'))) {
    setSession('quantity_error', 1);
  } else {
    $break = true;
    removeSession('quantity_error');
  }

  if(!$break) {
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
        if(isAdmin()) {
          redirect(getPathAdmin());
        } else {
          redirect(getPath());
        }
      } else {
        removeSession('reload');
        removeSession('debug_error');
      }
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
  removeSession('reload');
  removeSession('debug_error');
}

function getPathAdmin() {
  $path = "admin";
  if(!empty($_SERVER["QUERY_STRING"])) {
    $path.='?'.trim($_SERVER["QUERY_STRING"]);
  }
  return $path;
}

function getPath() {
  $path = "";
  if(!empty($_SERVER["QUERY_STRING"])) {
    $path.='?'.trim($_SERVER["QUERY_STRING"]);
  }
  return $path;
}

function updateOptions($prefixKey='') {
  if(empty($prefixKey)) {
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
  } else {
    $sql = "SELECT * FROM options WHERE opt_key LIKE '%$prefixKey%'";
    $options = getRaw($sql);
    $body = getBody('post');
    $isSuccess = true;
    if(!empty($body) && !empty($options)) {
      foreach($options as $value) {
        $condition = "opt_key = '".$value['opt_key']."'";

        $valueUpdate = '';

        if(is_array($body[$value['opt_key']])) {
          $valueUpdate = json_encode(array_filter($body[$value['opt_key']]));
        } else {
          $valueUpdate = trim($body[$value['opt_key']]);
        }

        $dataUpdate = [
          'opt_value' => $valueUpdate
        ];
        $updateStatus = update('options', $dataUpdate, $condition);
        if(!$updateStatus) {
          $isSuccess = false;
          break;
        }
      }
    }
    return $isSuccess;
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

function renderOptions($prefixKey, $layout=1) {
  $html = '';
  if(!empty($prefixKey)) {
    $sql = "SELECT * FROM options WHERE opt_key LIKE '%$prefixKey%'";
    $options = getRaw($sql);
    if(!empty($options)) {
      foreach($options as $option) {
        $key = trim($option['opt_key']);
        $value = trim($option['opt_value']);
        $name = trim($option['name']);
        $upload = $option['upload'];
        $contentBtn = ($layout > 1) ? '<i class="fa fa-upload" aria-hidden="true"></i>' : 'Chọn
        ảnh';
        if($upload == 1) {
          $html .= '<div class="col-'.(12/$layout).'">
                      <div class="form-group">
                        <label for="'.$key.'">'.$name.'</label>
                        <div class="row ckfinder-group">
                          <div class="col-9">
                              <input type="text" id="'.$key.'" name="'.$key.'" class="form-control image-link"
                                placeholder="Đường dẫn ảnh..."
                                value="'.$value.'">
                          </div>
                          <div class="col-3">
                              <button type="button" class="btn btn-success btn-block ckfinder-choose-image">'.$contentBtn.'</button>
                          </div>
                        </div>
                    </div>
                  </div>';
        } else if($upload == 2) {
          $html .= '<div class="col-'.(12/$layout).'">
          <div class="form-group">
            <label for="'.$key.'">'.$name.'</label>
            <textarea type="text" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="'.$name.'...">'.$value.'</textarea>
          </div>
        </div>';
        } else if($upload == 3) {
          $html .= '<div class="col-'.(12/$layout).'">
          <div class="form-group">
            <label for="'.$key.'">'.$name.'</label>
            <textarea type="text" id="'.$key.'" name="'.$key.'" class="form-control editor" placeholder="'.$name.'...">'.$value.'</textarea>
          </div>
        </div>';
        } else {
          $html .= '<div class="col-'.(12/$layout).'">
                      <div class="form-group">
                        <label for="'.$key.'">'.$name.'</label>
                        <input type="text" id="'.$key.'" name="'.$key.'" class="form-control" placeholder="'.$name.'..." value="'.$value.'">
                      </div>
                    </div>';
        }
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

    $arrParam = explode('&', $queryStr);
    if(!empty($arrParam)) {
      foreach($arrParam as $key => $value) {
        $paramValue = explode('=', $value);
        if(empty($paramValue[1])) {
          unset($arrParam[$key]);
        }
      }
    }
    $queryStr = implode('&', $arrParam);
    if(!empty($queryStr)) {
        $queryStr = '&'.$queryStr;
    }
  } 
  return $queryStr;
}

function getCountContacts() {
  $sql = 'SELECT * FROM contacts WHERE status = 1';
  $count = getRows($sql);
  return $count;
}

function isAdmin() {
  if(!empty($_SERVER['PHP_SELF'])) {
    $currentFile = $_SERVER['PHP_SELF'];
    $dirFile = dirname($currentFile);
    $baseNameDir = basename($dirFile);
    if(trim($baseNameDir) == 'admin') {
      return true;
    }
  }
  return false;
}


//link css, js of header
function headAdmin() {
  $host =  _WEB_HOST_TEMPLATE_ADMIN;
  ?>
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- fontawesome
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/> -->
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet"
   href="<?php echo $host.'/assets/' ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?php echo $host.'/assets/' ?>plugins/summernote/summernote-bs4.css">
<!-- range style-->
<link rel="stylesheet"
   href="<?php echo $host.'/assets'; ?>/plugins/ion-rangeslider/css/ion.rangeSlider.min.css?ver=<?php echo rand(); ?>">
<!-- multi select tags -->
<link rel="stylesheet"
   href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
<!-- font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<!-- Style core-->
<link rel="stylesheet" href="<?php echo $host.'/../core/assets'; ?>/css/style.css?ver=<?php echo rand(); ?>">
<!-- Select-->
<link rel="stylesheet" href="<?php echo $host.'/assets'; ?>/css/select.css?ver=<?php echo rand(); ?>">
<!-- Style-->
<link rel="stylesheet" href="<?php echo $host.'/assets'; ?>/css/style.css?ver=<?php echo rand(); ?>">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script type="text/javascript" src="<?php echo $host.'/assets/'?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $host.'/assets/'?>ckfinder/ckfinder.js"></script>
<?php
}

//link css, js of footer
function footAdmin() {
  ?>
<!-- jQuery -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/demo.js"></script>


<!-- Lấy ra web host root và prefix link để hiển thị link ở slug -->
<?php 
   $body = getBody();
   $module = null;
   if(!empty($body['module'])) {
      $module = $body['module'];
   }
  //  global $oldAboutProgress;
?>

<script type="text/javascript">
let rootUrlAdmin = "<?php echo _WEB_HOST_ROOT_ADMIN.'/' ?>";
let rootUrl = "<?php echo _WEB_HOST_ROOT ?>";
let prefixLink = "<?php echo getPrefixLink($module) ?>"
</script>

<!-- range js-->
<script
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/plugins/ion-rangeslider/js/ion.rangeSlider.min.js?ver=<?php echo rand() ?>">
</script>
<!-- select multi tag -->
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<!-- custom.js for me -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/bootstrap-iconpicker.min.js?ver=<?php echo rand() ?>">
</script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/jquery-menu-editor.min.js?ver=<?php echo rand() ?>">
</script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/select.js?ver=<?php echo rand() ?>"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/custom.js?ver=<?php echo rand() ?>"></script>
<?php
}

function head() {
?>

<!-- Favicon -->
<link rel="icon" type="image/png" href="<?php echo getOption('general_favicon')?>">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700,800" rel="stylesheet">

<!-- Bootstrap Css -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>bootstrap.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>font-awesome.min.css">
<!-- Slick Nav CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>slicknav.min.css">
<!-- Cube Portfolio CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>cubeportfolio.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>magnific-popup.min.css">
<!-- Fancy Box CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>jquery.fancybox.min.css">
<!-- Nice Select CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>niceselect.css">
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>owl.theme.default.css">
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>owl.carousel.min.css">
<!-- Slick Slider CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>slickslider.min.css">
<!-- Animate CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>animate.min.css">

<!-- Radix StyleShet CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>reset.css">
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>style.css">
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>responsive.css">

<!-- Radix Color CSS -->
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE.'/assets/css/' ?>color/color1.css">
<!-- Style core-->
<link rel="stylesheet"
   href="<?php echo _WEB_HOST_TEMPLATE.'/../core/assets'; ?>/css/style.css?ver=<?php echo rand(); ?>">
<?php
}

function foot() {
  ?>
<!-- Jquery -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery-migrate.min.js"></script>
<!-- Popper JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>bootstrap.min.js"></script>
<!-- Colors JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>colors.js"></script>
<!-- Modernizer JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>modernizr.min.js"></script>
<!-- Nice select JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>niceselect.js"></script>
<!-- Tilt Jquery JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>tilt.jquery.min.js"></script>
<!-- Fancybox  -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.fancybox.min.js"></script>
<!-- Jquery Nav -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.nav.js"></script>
<!-- Owl Carousel JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>owl.carousel.min.js"></script>
<!-- Slick Slider JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>slickslider.min.js"></script>
<!-- Cube Portfolio JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>cubeportfolio.min.js"></script>
<!-- Slicknav JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.slicknav.min.js"></script>
<!-- Jquery Steller JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.stellar.min.js"></script>
<!-- Magnific Popup JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>magnific-popup.min.js"></script>
<!-- Wow JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>wow.min.js"></script>
<!-- CounterUp JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>jquery.counterup.min.js"></script>
<!-- Waypoint JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>waypoints.min.js"></script>
<!-- Jquery Easing JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>easing.min.js"></script>
<!-- Google Map JS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnhgNBg6jrSuqhTeKKEFDWI0_5fZLx0vM"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>gmap.min.js"></script>
<!-- Main JS -->
<script src="<?php echo _WEB_HOST_TEMPLATE.'/assets/js/' ?>main.js"></script>
<?php
}

function customNameSite() {
  $name = getOption('general_name_site');
  if(!empty($name)) {
    $firstChar = substr($name, 0, 1);
    $remainingChar = substr($name, 1);
    return '<span>'.$firstChar.'</span>'.$remainingChar;
  }
  return false;
}

function getKeyYoutube($linkStr) {
  $queryStrArr = [];
  $urlStr = parse_url($linkStr, PHP_URL_QUERY);
  parse_str($urlStr, $queryStrArr);
  
  if(!empty($queryStrArr['v'])) {
    return $queryStrArr['v'];
  } 
  return false;
}

function setView($id) {
  $blog = firstRaw("SELECT view_count FROM blogs WHERE id = $id");
  $check = false;
  if(!empty($blog['view_count'])) {
    $view = $blog['view_count'] + 1;
    $check = true;
  } else {
    if(is_array($blog)) {
      $view = 1;
      $check = true;
    }
  }

  if($check) {
    update('blogs', [
      'view_count' => $view
    ], "id = $id");
  }
  
}

//lấy avatar từ gravatar
function getAvatar($email, $size = null) {
  $hashAvatar = md5($email);
  if(!empty($size)) {
    $avatarUrl = 'https://www.gravatar.com/avatar/'.$hashAvatar."?s=$size";
  } else {
    $avatarUrl = 'https://www.gravatar.com/avatar/'.$hashAvatar;
  }
  return $avatarUrl;
}

function getAvatarById($id) {
  $userInfor = firstRaw("SELECT avatar FROM users WHERE id = $id");
  if(!empty($userInfor["avatar"])) {
    return $userInfor["avatar"];
  }
  return false;
}

//Lấy danh sách comment
function getCommentList($listData, $parentId, $id) {
  if(!empty($listData)) {
    echo '<div class = "comment-children">';
    foreach($listData as $key=> $item) {
      if($item['parent_id'] == $parentId) {
      ?>
<div class="comment-list">
   <div class="head">
      <img
         src="<?php echo !empty($item['user_id']) && !empty(getAvatarById($item['user_id'])) ? getAvatarById($item['user_id']) : getAvatar($item['email']) ?>"
         alt="#">
   </div>
   <div class="body">
      <h4>
         <?php echo !empty($item['user_id']) && !empty(getUser($item['user_id'])['name']) ? $item['fullname']. ' <label class="badge badge-danger">'.getUser($item['user_id'])['name'].'</lable>' : $item['fullname'] ?>
      </h4>
      <div class="comment-info">
         <p><span><?php echo getDateFormat($item['create_at'], 'd/m/Y') ?> at<i
                  class="fa fa-clock-o"></i><?php echo getDateFormat($item['create_at'], 'H:m') ?>,</span><a
               href="<?php echo getLinkModule('blogs', $id, '', '', ['comment_id' => $item['id']]).'#comment-form' ?>"><i
                  class="fa fa-comment-o"></i>replay</a></p>
      </div>
      <p><?php echo $item['content'] ?></p>
   </div>
</div>
<?php
        unset($listData[$key]);
        getCommentList($listData, $item['id'], $id );
      }
    }
    echo '</div>';
  }
}

function getUser($userId) {
  $userInfor = firstRaw("SELECT fullname, email, groups.name FROM users JOIN groups ON users.group_id = groups.id WHERE users.id = $userId AND users.status = 1");
  if(!empty($userInfor)) {
    return $userInfor;
  }
  return false;
}

function getComment($id) {
  $comment = firstRaw("SELECT * FROM comments WHERE id = $id");
  if(!empty($comment)) {
    return $comment;
  }
  return false;
}

function getCommentReply($commentData, $parentId, &$result=[]) {
  if(!empty($commentData)) {
    foreach($commentData as $key => $value) {
      if($parentId == $value['parent_id']) {
        $result[] = $value['id'];
        unset($commentData[$key]);
        getCommentReply($commentData, $value['id'], $result);
      }
    }
  }
  return $result;
}

function getLimitText($str, $length) {
  $str = trim($str);
  $strArr = explode(" ", $str);
  $arrLength = count($strArr);
  if($arrLength >= $length) {
    $resultStr = "";
    for($i = 0; $i < $length; $i++) {
      $resultStr .= " ".$strArr[$i];
    }
    $resultStr = trim($resultStr)."...";
    return $resultStr;
  } else {
    return $str;
  }   
}

function getCountComments($status = 0) {
  return getRows("SELECT * FROM comments WHERE status = $status");
}

function getCountSubscribes($status = 0) {
  return getRows("SELECT * FROM subscribe WHERE status = $status");
}

function getContactType($typeId) {
  return firstRaw("SELECT * FROM contact_types WHERE id = $typeId");
}

function getActiveMenu($href) {
  $requestUrl = $_SERVER['REQUEST_URI'];
  if($requestUrl != "/") {
    $requestUrl = trim($requestUrl, '/');
    $requestUrlArr = array_filter(explode('/', $requestUrl));
    if(!empty($requestUrlArr)) {
      if(strpos($href, $requestUrlArr[0]) !== false) {
        return 'class="active"';
      }
    }
  } else {
    if($href == _WEB_HOST_ROOT.$requestUrl) {
      return 'class="active"';
    }
  }
}

function getMenu($dataMenu, $isSub = false) {
  if(!empty($dataMenu)) {
    if($isSub) {
      echo '<ul class="dropdown">';
    } else {
      echo '<ul class="nav menu">';
    }
    
    foreach($dataMenu as $item) {
      echo '<li '.getActiveMenu($item['href']).'><a href="'.$item['href'].'" target="'.$item['target'].'" title="'.$item['title'].'">'.$item['text'].'</a>';

      if(!empty($item['children'])) {
        getMenu($item['children'] , true);
      }
      echo '</li>';
    }
    echo '</ul>';
  }
}