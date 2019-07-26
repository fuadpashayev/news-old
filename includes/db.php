<?php
$host = "localhost";
$db_user = "root";
$db_name = "news";
$db_password = "";
$db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8",$db_user,$db_password);
$db->query("set names 'utf8'");

?>
