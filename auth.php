<?php
require('includes/header.php');
title("Giriş");
$action = GET('action');
User::onlyGuests();


switch ($action) {

  case 'login':
    $data = [
      'username' => POST('username'),
      'password' => Hash::make(POST('password')),
    ];
    $login = User::loginWithCredentials($data);
    if(!$login)
      Errors::set('auth','Username or password is incorrect');
    header("location:$home/home");
  break;

  case 'logout':
    User::logout();
    header("location:$home/home");
  break;

  default:
    echo '
      <form class="navigation-form col-md-6 m-auto" action="'.$home.'/auth/login" method="post">
        <h3 class="text-center">Giriş</h3>
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
  break;
}



require('includes/footer.php');
?>
