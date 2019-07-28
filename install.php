<?php
require ('includes/db.php');

$sql = [];

$sql['create_table_users'] = "
create table users(
  `id` int(11) auto_increment primary key,
  `username` varchar(55) not null,
  `password` varchar(555) not null,
  `full_name` varchar(55) not null,
  `rights` int(1) default '0',
  `token` varchar(255) not null
);
";


$sql['create_categories_table'] = "
create table categories(
  `id` int(11) auto_increment primary key,
  `url_name` varchar(55) not null,
  `name` varchar(55) not null
);
";


$sql['create_news_table'] = "
create table news(
  `id` int(11) auto_increment primary key,
  `title` varchar(255) not null,
  `text` text not null,
  `photo` varchar(255) not null,
  `user_id` int(11) not null,
  `url_name` varchar(255) not null,
  `category` int(11) not null,
  `time` bigint not null
);
";


//password: admin
$sql['create_admin_user'] = "
insert into users set
  `username` = 'admin',
  `password` = '0a0ee8cc493e45b3301e425eed735742',
  `full_name` = 'admin',
  `rights` = 1
";

$sql['create_categories'] = "
insert into categories set
  `url_name` = 'idman',
  `name` = 'İdman';

insert into categories set
  `url_name` = 'hava',
  `name` = 'Hava';

insert into categories set
  `url_name` = 'siyaset',
  `name` = 'Siyasət';

insert into categories set
  `url_name` = 'iqtisadiyyat',
  `name` = 'İqtisadiyyat';

insert into categories set
  `url_name` = 'dunya',
  `name` = 'Dünya';



";

foreach ($sql as $name => $query) {
  $executed = $db->query($query);
  if($executed){
    echo "<div style='color:green'>$name query executed successfully</div>";
  }else{
    foreach ($db->errorInfo() as $key => $value) {
      echo '<div style="color:red">'.$value.'</div>';
    }
  }
}


header("refresh:3,url = index.php");


?>
