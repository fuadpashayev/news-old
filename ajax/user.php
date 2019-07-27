<?php
require('../includes/core.php');
$action = GET('action');

switch ($action) {
  case 'add':
      $data = [
          'full_name' => POST('full_name'),
          'username' => POST('username'),
          'password' => Hash::make(POST('password')),
          'rights' => POST('rights')
      ];
      $user = User::set($data);
      header("location:$home/panel/user");
  break;

  case 'edit':
      $data = [
          'full_name' => POST('full_name'),
          'username' => POST('username'),
          'password' => POST('password'),
          'rights' => POST('rights'),
          'id' => POST('id')
      ];
      $user = User::update($data);
      header("location:$home/panel/user");
  break;

  case 'delete':
      $data = [
          'id' => POST('id')
      ];
      $user = User::delete($data);
  break;

  case 'get':
    $id = POST('id');
    echo json_encode(User::get($id));
  break;
}

?>
