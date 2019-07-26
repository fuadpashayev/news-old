<?php
require('../includes/core.php');
$action = GET('action');

switch ($action) {
  case 'add':
  $data = [
    'url_name' => POST('url_name'),
    'name' => POST('name'),
  ];
  $category = Category::set($data);
  break;

  case 'edit':

  break;

  case 'delete':

  break;
}

?>
