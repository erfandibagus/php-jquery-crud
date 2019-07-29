<?php

$host   = 'localhost';
$dbname = 'jquery_crud';
$user   = 'user';
$pass   = '1122';

$connect = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $pass);
