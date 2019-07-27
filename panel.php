<?php
require('includes/header.php');
title("İdarə Paneli");
Panel::onlyAdmins();
$action = GET('action');

if($page!='panel'){
  echo '<a class="backButton" href="'.$home.'/panel"><div class="btn btn-primary m-1 back"><i class="material-icons">chevron_left</i>Panel</div></a>';
}

switch ($action) {
  case 'category':
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
    echo '
      <a class="backButton" href="#"><div class="btn btn-primary back add news-button" type="add" data-toggle="modal" data-target="#news-modal"><i class="material-icons">add</i>Əlavə et</div></a>
      <h5 class="panel-header bg-info text-white">Xəbərlər</h5>
      <table class="panel-content">
        <thead>
          <tr>
            <th>Şəkil</th>
            <th>Link qısayolu</th>
            <th>Başlıq</th>
            <th>Əməliyatlar</th>
          </tr>
        </thead>
        <tbody>
    ';

    $news = News::getAll();
    foreach ($news as $new) {
      echo "
        <tr>
          <td>
            <img src='$new[photo]' alt=''>
          </td>
          <td>$new[url_name]</td>
          <td>$new[name]</td>
          <td>
            <button class='option-button btn btn-primary edit' type='edit' data-toggle='modal' data-target=''#news-modal'>Dəyiş</button>
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





  case 'user':
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
      </a>

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

    </div>
  </div>
  ';


  break;
}

require('includes/footer.php');
?>
