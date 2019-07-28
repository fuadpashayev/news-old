<?php
require('includes/header.php');
User::onlyUsers();
$action = GET('action');
if($page!='panel' && $rootPage!='news'){
  echo '<a class="backButton" href="'.$home.'/panel"><div class="btn btn-primary m-1 back"><i class="material-icons">chevron_left</i>Panel</div></a>';
}

switch ($action) {
  case 'category':
    title("Bölmələr");
    echo '
      <a class="backButton" href="#"><button class="btn btn-primary back category-button" type="add" data-toggle="modal" data-target="#category-modal"><i class="material-icons">add</i>Əlavə et</button></a>
      <h5 class="panel-header bg-info text-white">Bölmələr</h5>
      <table class="panel-content">
        <thead>
          <tr>
            <th>Link qısayolu</th>
            <th>Adı</th>
            <th>Əməliyatlar</th>
          </tr>
        </thead>
        <tbody>
    ';

    $categories = Category::getAll();
    foreach ($categories as $category) {
      echo "
        <tr>
          <td>$category[url_name]</td>
          <td>$category[name]</td>
          <td>
            <button class='option-button btn btn-primary category-button' type='edit' data-name='$category[name]' data-id='$category[id]' data-toggle='modal' data-target='#category-modal'>Dəyiş</button>
            <button class='option-button btn btn-danger delete' id='$category[id]' type='category'>Sil</button>
          </td>
        </tr>
      ";
    }
    echo'
      </tbody>
      </table>
    ';
  break;




  case 'news':
    title("Xəbərlər");
    echo '
      <a class="backButton" href="#"><div class="btn btn-primary back add news-button" type="add" data-toggle="modal" data-target="#news-modal"><i class="material-icons">add</i>Əlavə et</div></a>
      <h5 class="panel-header bg-info text-white">Xəbərlər</h5>
      <table class="panel-content">
        <thead>
          <tr>
            <th>Şəkil</th>
            <th>Başlıq</th>
            <th>Əlavə edən</th>
            <th>Əməliyatlar</th>
          </tr>
        </thead>
        <tbody>
    ';

    $news = News::getAll();
    foreach ($news as $new) {
      $user = User::get($new['user_id']);
      $text = mb_substr($new['text'],0,50).'...';
      echo "
        <tr>
          <td>
            <img src='$home/images/uploads/$new[photo]' alt=''>
          </td>
          <td>$new[title]</td>
          <td>$user[full_name]</td>
          <td>
            <a href='$home/panel/news/$new[url_name]'>
              <button class='option-button btn btn-primary'>Göstər</button>
            </a>
            <button class='option-button btn btn-primary news-button' type='edit' data-id='$new[id]' data-toggle='modal' data-target='#news-modal'>Dəyiş</button>
            <button class='option-button btn btn-danger delete' id='$new[id]' type='news'>Sil</button>
          </td>
        </tr>
      ";
    }
    echo'
      </tbody>
      </table>
    ';
  break;

  case 'show_news':
    echo '<a class="backButton" href="'.$home.'/panel/news"><div class="btn btn-primary m-1 back"><i class="material-icons">chevron_left</i>Xəbərlər</div></a>';
    $id = GET('id');
    $news = News::get($id);
    $user = User::get($news['user_id']);
    title("Xəbərlər - $news[title]");
    echo "
        <div class='col-md-12 d-flex'>
          <div class='col-md-2 news-image'>
            <img src='$home/images/uploads/$news[photo]' alt=''>
          </div>
          <div class='col-md-10'>
            <div class='bg-primary text-center text-white p-1 m-1 b-1'>$news[title]</div>
            <div class='bg-default text-dark p-1'>$news[text]</div>
          </div>
        </div>
        <div class='author'>
          <div>
              Əlavə edən: <span>$user[full_name]</span>
          </div>
           <div>
              Tarix: <span>".date('d.m.Y H:i')."</span>
          </div>
          
        </div>
      
    ";

  break;





  case 'user':
    title("İstifadəçilər");
    Panel::onlyAdmins();
    echo '
      <a class="backButton" href="#"><div class="btn btn-primary back user-button" type="add" data-toggle="modal" data-target="#user-modal"><i class="material-icons">add</i>Əlavə et</div></a>
      <h5 class="panel-header bg-info text-white">İstifadəçilər</h5>
      <table class="panel-content">
        <thead>
          <tr>
            <th>İstifadəçi adı</th>
            <th>Ad</th>
            <th>Vəzifə</th>
            <th>Əməliyatlar</th>
          </tr>
        </thead>
        <tbody>
    ';

    $users = User::getAll();
    foreach ($users as $user) {
      $right = User::findRights($user['rights']);
      echo "
        <tr>
          <td>$user[username]</td>
          <td>$user[full_name]</td>
          <td>$right</td>
          <td>
            <button class='option-button btn btn-primary edit user-button' type='edit' data-id='$user[id]' data-toggle='modal' data-target='#user-modal'>Dəyiş</button>
            <button class='option-button btn btn-danger delete' id='$user[id]' type='user'>Sil</button>
          </td>
        </tr>
      ";
    }
    echo'
      </tbody>
      </table>
    ';
  break;





  default:
  title("İdarəçi Paneli");
  $categories = Category::getAll()->rowCount();
  $news = News::getAll()->rowCount();
  $users = User::getAll()->rowCount();


  echo '
  <div class="panel-outer">
    <div class="panel-navigation">

      <a href="'.$home.'/panel/category">
        <div class="panel-navigation-menu bg-info">
          <div class="panel-navigation-menu-inner">
            <i class="material-icons">category</i>
          </div>
          <div class="panel-navigation-menu-inner">
            <div>
              '.$categories.'
            </div>
            <div>
              Categories
            </div>
          </div>
        </div>
      </a>

      <a href="'.$home.'/panel/news">
        <div class="panel-navigation-menu bg-success">
          <div class="panel-navigation-menu-inner">
            <i class="material-icons">chrome_reader_mode</i>
          </div>
          <div class="panel-navigation-menu-inner">
            <div>
              '.$news.'
            </div>
            <div>
              News
            </div>
          </div>
        </div>
      </a>';

  if(User::admin()){
    echo '
      <a href="'.$home.'/panel/user">
        <div class="panel-navigation-menu bg-danger">
          <div class="panel-navigation-menu-inner">
            <i class="material-icons">people</i>
          </div>
          <div class="panel-navigation-menu-inner">
            <div>
              '.$users.'
            </div>
            <div>
              Users
            </div>
          </div>
        </div>
      </a>
    ';
  }
  echo '
    </div>
  </div>
  ';


  break;
}

require('includes/footer.php');
?>
