<?php
require('../includes/core.php');
$action = GET('action');

switch ($action) {
  case 'add':
    $data = [
      'url_name' => linkify(POST('name')),
      'name' => POST('name'),
    ];
    $category = Category::set($data);
    header("location:$home/panel/category");
  break;

  case 'edit':
    $data = [
      'url_name' => linkify(POST('name')),
      'name' => POST('name'),
      'id' => POST('id')
    ];
    $category = Category::update($data);
    header("location:$home/panel/category");
  break;

  case 'delete':
    $data = [
      'id' => POST('id')
    ];
    $category = Category::delete($data);
  break;

}

?>
