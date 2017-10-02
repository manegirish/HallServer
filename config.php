<?php
$con=mysqli_connect('localhost','dataapps_hall','SJBEakf4LnVo','dataapps_hall');
$_TODAY=gmdate("Y-m-d H:i:s");

$url='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
preg_match("/[^\/]+$/", $url, $matches);
$newUrl = str_replace($matches[0],'',$url);
$GLOBALS['server_url']=$newUrl;
?>