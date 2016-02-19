<?php

$db_host        = 'lion.beget.ru';
$db_host        = 'localhost';
$db_user        = 'igosja_fm';
//$db_user        = 'root';
$db_password    = '66xM6RQ51D';
//$db_password    = '';
$db_database    = 'igosja_fm';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);

$sql = "SET NAMES 'utf8'";
$mysqli->query($sql);

$sql = "SET `lc_time_names`='ru_RU'";
$mysqli->query($sql);