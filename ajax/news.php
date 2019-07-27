<?php
require('../includes/core.php');
$action = GET('action');

switch ($action) {
    case 'add':
        $user = User::me();
        $file = FILES('photo');
        $name = Hash::make(Token::generate()).'.jpg';
        $dir = "$root/images/uploads/$name";
        $photo = "$home/images/uploads/$name";
        move_uploaded_file($file['tmp_name'],$dir);
        $data = [
            'title' => POST('title'),
            'text' => POST('text'),
            'photo' => $photo,
            'user_id' => $user['id'],
            'time' => $time
        ];
        $news = News::set($data);
        header("location:$home/panel/news");
        break;

    case 'edit':
        $data = [
            'full_name' => POST('full_name'),
            'username' => POST('username'),
            'password' => POST('password'),
            'rights' => POST('rights'),
            'id' => POST('id')
        ];
        $user = News::update($data);
        header("location:$home/panel/news");
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
