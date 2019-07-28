<?php
ob_start();
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
            <h5 class="modal-title" id="modal-title">Yeni Xəbər</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="'.$home.'/ajax/news.php?action=add" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="title" class="col-form-label">Başlıq:</label>
                <input type="text" class="form-control" id="title" name="title">
              </div>
              
              <div class="form-group">
                <label for="text" class="col-form-label">Mətn:</label>
                <input type="text" class="form-control" id="text" name="text">
              </div>
              
               <div class="form-group">
                <label for="photo" class="col-form-label">Şəkil:</label>
                <input type="file" class="form-control" id="photo" name="photo">
               </div>
               
               <div class="form-group">
                <label for="category" class="col-form-label">Bölmə:</label>
                <select class="form-control" name="category" id="category">
                ';
                    $categories = Category::getAll();
                    foreach ($categories as $category) {
                        echo "<option value='$category[id]'>$category[name]</option>";
                    }
                echo'
                </select>
               </div>
               
              <input type="hidden" id="news-id" name="id" value="">
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
            <h5 class="modal-title" id="modal-title">Yeni İstifadəçi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="'.$home.'/ajax/user.php?action=add" method="post">
              <div class="form-group">
                <label for="full_name" class="col-form-label">Ad / Soyad:</label>
                <input type="text" class="form-control" id="full_name" name="full_name">
              </div>
              
              <div class="form-group">
                <label for="username" class="col-form-label">İstifadəçi Adı:</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              
               <div class="form-group">
                <label for="password" class="col-form-label">Şifrə:</label>
                <input type="text" class="form-control" id="password" name="password">
               </div>
               
               <div class="form-group">
                <label for="rights" class="col-form-label">Vəzifə:</label>
                <select name="rights" id="rights" class="form-control">
                    <option value="0">İstifadəçi</option>
                    <option value="1">Admin</option>
                </select>
               </div>
              <input type="hidden" id="user-id" name="id" value="">
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
            echo "
            <div class='navigation-menu user'>$user[full_name]</div>
            <a href='$home/panel' ".($page=='panel'?'class="active"':null)."><div class='navigation-menu'>Panel</div></a>
            
            ";
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

              if(User::me()){
                echo "<a href='$home/panel' ".($page=='panel' || $rootPage=='panel'?'class="active"':null)."><li>Panel</li></a>";
              }
              $categories = Category::getAll();
              foreach ($categories as $category) {
                echo "<a href='$home/$category[url_name]' ".($page==$category['url_name']?'class="active"':null)."><li>$category[name]</li></a>";
              }
                if(User::me()){
                    echo "<a href='$home/logout'><li>Çıxış</li></a>";
                }else{
                    echo "<a href='$home/auth' ".($page=='auth' || $rootPage=='auth'?'class="active"':null)."><li>Giriş</li></a>";
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
            if(User::me()){
                echo "<a href='$home/logout'><li>Çıxış</li></a>";
            }else{
                echo "<a href='$home/auth' ".($page=='auth' || $rootPage=='auth'?'class="active"':null)."><li>Giriş</li></a>";
            }
            echo'
          </ul>



        </div>
        <div class="container-body">

';

?>
