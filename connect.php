<?php
mysql_connect("mysql.hostinger.ru", "u661420716_test", "123123")
or die("<p>Ошибка подключения к базе данных! " . mysql_error() . "</p>");

mysql_select_db("u661420716_test")
or die("<p>Ошибка выбора базы данных! ". mysql_error() . "</p>");
error_reporting(E_ALL & ~E_DEPRECATED);
?>
