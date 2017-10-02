<?php
$con=mysql_connect('localhost','root','');
mysql_select_db('hall');
$_TODAY=gmdate("Y-m-d H:i:s");
define("MAIL_HOST","smtp.sendgrid.net");
define("MAIL_PORT","587");
define("MAIL_USERNAME","cubemails");
define("MAIL_PASSWORD","cube@123");

?>