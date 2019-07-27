<?php session_start();
require ('db.php');
$home = "http://localhost:8000/news";
$root = "$_SERVER[DOCUMENT_ROOT]/news";


$uri = $_SERVER['REQUEST_URI'];
$url = explode('/',$uri);
$page = $url[count($url)-1];
$rootPage = $url[count($url)-2];
$time = time();


class Token {

  public static function get(){
    return isset($_SESSION['token'])?$_SESSION['token']:null;
  }

  public static function generate(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $tokenString = '';
    for ($i = 0; $i < 75; $i++) {
       $tokenString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $tokenString;
  }

  public static function set($token){
    $_SESSION['token'] = $token;
  }



}

class Category {

  public static function get($id=null){
    global $db;
    $query = $db->prepare("select * from categories where id=?");
    $query->execute([$id]);
    $category = $query->fetch();
    return $category;
  }
  public static function set($data){
      global $db;
      $query = $db->prepare("insert into categories (	url_name , name) values (:url_name,:name) ");
      $query->execute($data);

      return $query;
    }
    public static function update($data){
        global $db;
        $query = $db->prepare("update categories set url_name=:url_name, name=:name where id=:id");
        $query->execute($data);
        return $query;
    }

    public static function delete($data){
        global $db;
        $query = $db->prepare("delete from categories where id=:id");
        $query->execute($data);
        return $query;
    }

    public static function getAll(){
      global $db;
      $categories = $db->query("select * from categories");
      return $categories;
    }



}


class News {


  public static function set($data){
      global $db;
      $query = $db->prepare("insert into news (title , photo, `text`, user_id, `time`) values (:title, :photo, :text, :user_id, :time) ");
      $query->execute($data);
      return $query;
    }

  public static function update($data){
      global $db;
      $query = $db->prepare("update news set title = :title , text = :text, user_id = :user_id, `time` = ':time' where id=:id");
      $query->execute($data);
      return $query;
  }

  public static function delete($data){
      global $db;
      $query = $db->prepare("delete from news where id=:id");
      $query->execute($data);
      return $query;
  }


  public static function get($id=null){
    global $db;
    $query = $db->prepare("select * from news where id=?");
    $query->execute([$id]);
    $news = $query->fetch();
    return $news;
  }

  public static function getAll(){
    global $db;
    $news = $db->query("select * from news");
    return $news;
  }



}



class User {

  public static function me(){
    global $db;
    $token = Token::get();
    $query = $db->prepare("select * from users where token=?");
    $query->execute([$token]);
    $user = $query->fetch();
    return $user;
  }

  public static function get($id=null){
    global $db;
    $query = $db->prepare("select * from users where id=?");
    $query->execute([$id]);
    $user = $query->fetch();
    return $user;
  }

    public static function set($data){
        global $db;
        $query = $db->prepare("insert into users (	username, password, full_name, rights) values (:username, :password, :full_name, :rights) ");
        $query->execute($data);
        return $query;
    }
    public static function update($data){
        global $db;
        $query = $db->prepare("update users set username=:username, password=:password, full_name=:full_name, rights=:rights where id=:id");
        $query->execute($data);
        return $query;
    }

    public static function delete($data){
        global $db;
        $query = $db->prepare("delete from users where id=:id");
        $query->execute($data);
        return $query;
    }

  public static function getAll(){
    global $db;
    $users = $db->query("select * from users");
    return $users;
  }


  public static function loginWithCredentials($data){
    global $db;
    $try = $db->prepare("select * from users where username=:username && password=:password");
    $try->execute($data);
    $user = $try->fetch();
    $token = Token::generate();
    Token::set($token);
    $updateToken = $db->query("update users set token='$token' where id='$user[id]'");
    return $user;
  }

  public static function logout(){
    $_SESSION['token'] = null;
    unset($_SESSION['token']);
  }

  public static function rights(){
    return User::me()['rights'];
  }

  public static function findRights($rights){
    $rights_names = [
      0 => 'İstifadəçi',
      1 => 'Admin'
    ];
    return $rights_names[$rights];
  }

  public static function admin(){
    return User::rights();
  }

  public static function onlyUsers(){
    global $home;
      if(!User::me())
        header("location:$home/home");
  }

  public static function onlyGuests(){
    global $home;
      if(User::me())
        header("location:$home/home");
  }


}



class Errors {

  public static function set($key,$value){
    global $time;
    $errors = Errors::exists()?Errors::getAll():[];
    $errors[$key] = $value;
    $_SESSION['errors'] = json_encode($errors);
    $_SESSION['error_added_time'] = $time;
  }

  public static function get($key){
    Errors::checkErrorsTime();
    $errors = Errors::exists()?json_decode($_SESSION['errors'],1):null;
    return $errors[$key];
  }

  public static function getAll(){
    return json_decode($_SESSION['errors'],1);
  }

  public static function exists(){
    return isset($_SESSION['errors']) && $_SESSION['errors']!=null ? true : false;
  }

  public static function alert($error){
    return "<div class='alert alert-danger text-center'>$error</div>";
  }

  public static function checkErrorsTime(){
    global $time;
    if(isset($_SESSION['error_added_time'])){
      if($time - $_SESSION['error_added_time'] > 1){
        $_SESSION['errors'] = null;
        $_SESSION['error_added_time'] = null;
      }
    }
  }

}


class Hash {

  public static function make($str){
    return md5(sha1(base64_encode(md5($str))));
  }

}


class Panel {

  public static function onlyAdmins(){
    global $home;
      if(!User::admin()){
        echo Errors::alert('Ancaq idarəçilər bu səhifəyə giriş edə bilərlər!');
        require('includes/footer.php');
        header("refresh:3,url=$home/home");
        exit;
      }
  }

}

function linkify($str){
  $str = mb_strtolower($str);
  $str = str_replace(['ü','ö','ğ','ı','ə','ç','ş',' ','?','&','$'],['u','o','g','i','e','c','s','_','','',''],$str);
  return $str;
}

function GET($index){
  return isset($_GET[$index])?$_GET[$index]:null;
}
function POST($index){
  return isset($_POST[$index])?$_POST[$index]:null;
}
function FILES($index){
    return isset($_FILES[$index])?$_FILES[$index]:null;
}

function title($title){
  echo "<title>$title</title>";
}


?>
