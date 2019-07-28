<?php
require('../includes/core.php');
$action = GET('action');

switch ($action) {
    case 'add':
        $user = User::me();
        $file = FILES('photo');
        $photo = Hash::make(Token::generate()).'.jpg';
        $dir = "$root/images/uploads/$photo";
        move_uploaded_file($file['tmp_name'],$dir);

        $data = [
            'title' => POST('title'),
            'text' => POST('text'),
            'photo' => $photo,
            'user_id' => $user['id'],
            'url_name' => linkify(POST('title')),
            'category' => POST('category'),
            'time' => $time
        ];
        $news = News::set($data);
        header("location:$home/panel/news");
        break;

    case 'edit':
        $user = User::me();
        $file = FILES('photo');
        $photo = News::get(POST('id'))['photo'];
        if($file['name']){
            unlink("$root/images/uploads/$photo") or die('Old photo is not deleted');
            $photo = Hash::make(Token::generate()).'.jpg';
            $dir = "$root/images/uploads/$photo";
            move_uploaded_file($file['tmp_name'],$dir);
        }
        $data = [
            'title' => POST('title'),
            'text' => POST('text'),
            'photo' => $photo,
            'user_id' => $user['id'],
            'url_name' => linkify(POST('title')),
            'category' => POST('category'),
            'time' => $time,
            'id' => POST('id')
        ];
        $news = News::update($data);
        header("location:$home/panel/news");
        break;

    case 'delete':
        $data = [
            'id' => POST('id')
        ];
        $user = News::delete($data);
        break;

    case 'get':
        $id = POST('id');
        echo json_encode(News::get($id));
    break;
}

?>
