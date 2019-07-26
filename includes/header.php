<?php
require("core.php");



echo '
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="'.$home.'/style.css"/>
    <link rel="icon" href="'.$home.'/images/logo.png">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,width=device-width"/>
  </head>
  <body>



    <div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Yeni Bölmə</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="'.$home.'/ajax/category.php?action=add" method="post">
              <div class="form-group">
                <label for="name" class="col-form-label">Bölmə Adı:</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <input type="hidden" id="category-id" name="id" value="">
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ləğv et</button>
                <button type="button" class="btn btn-primary" id="modal-pressed">Əlavə et</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="news-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Yeni Bölmə</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="'.$home.'/ajax/category.php?action=add" method="post">
              <div class="form-group">
                <label for="name" class="col-form-label">Bölmə Adı:</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ləğv et</button>
                <button type="button" class="btn btn-primary" id="modal-pressed">Əlavə et</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Yeni Bölmə</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="'.$home.'/ajax/category.php?action=add" method="post">
              <div class="form-group">
                <label for="name" class="col-form-label">Bölmə Adı:</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ləğv et</button>
                <button type="button" class="btn btn-primary" id="modal-pressed">Əlavə et</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



    <div class="bg"></div>
    <div class="site">
      <div class="navigation">

        <div class="navigation-header">
          <nav>
            <ul>
              <a href="'.$home.'/index.php" '.(in_array($page,['index','home'])?'class="active"':null).'>
                <li><img src="'.$home.'/images/logo.png">News Portal</li>
              </a>
            </ul>
          </nav>
        </div>

        <div class="container-body">';
        $user = User::me();
        if($user){
          if(User::me()){
            echo "<a href='$home/panel' ".($page=='panel'?'class="active"':null)."><div class='navigation-menu'>Panel</div></a>";
          }
          echo '
            <a href="'.$home.'/logout">
              <div class="navigation-menu">
                Çıxış
              </div>
            </a>
          ';
        }else{
          $error = Errors::get('auth');
          if($error){
            echo "
            <div class='alert alert-danger text-center'>
              $error
            </div>";
          }
          echo '
            <form class="navigation-form" action="'.$home.'/auth/login" method="post">
              <div class="input-group">
                <input class="form-control" type="text" name="username" placeholder="Username">
              </div>

              <div class="input-group">
                <input class="form-control" type="password" name="password"  placeholder="Password">
              </div>

              <div class="input-group">
                <button class="btn btn-primary form-control">Daxil Ol</button>
              </div>
            </form>

          ';
        }

      echo'
        </div>

      </div>
      <div class="content">
        <div class="container-header">
          <nav>
            <ul>
              <a href="'.$home.'/index.php" '.(in_array($page,['index','home'])?'class="active"':null).'">
                <li>
                  <img src="'.$home.'/images/logo.png" alt="">
                </li>
              </a>';
              if($rootPage=='panel' && $page!='panel'){
                echo '<a class="backButton" href="'.$home.'/panel"><div class="btn btn-primary m-1 back"><i class="material-icons">chevron_left</i>Panel</div></a>
                      <a class="backButton" href="#"><div class="btn btn-primary back add" type="'.$page.'"><i class="material-icons">add</i>Əlavə et</div></a>
                ';
              }

              if(User::me()){
                echo "<a href='$home/panel' ".($page=='panel' || $rootPage=='panel'?'class="active"':null)."><li>Panel</li></a>";
              }
              $categories = Category::getAll();
              foreach ($categories as $category) {
                echo "<a href='$home/$category[url_name]' ".($page==$category['url_name']?'class="active"':null)."><li>$category[name]</li></a>";
              }
              echo'
            </ul>

          </nav>

          <input class="menu-btn" type="checkbox" id="menu-btn" />
          <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
          <ul class="menu">';
            if(User::me()){
              echo "<a href='$home/panel' ".($page=='panel'?'class="active"':null)."><li>Panel</li></a>";
            }
            $categories = Category::getAll();
            foreach ($categories as $category) {
              echo "<a href='$home/$category[url_name]' ".($page==$category['url_name']?'class="active"':null)."><li>$category[name]</li></a>";
            }
            echo'
          </ul>



        </div>
        <div class="container-body">

';

?>
