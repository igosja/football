<?php

//$host       = 'lion.beget.ru';
$host       = 'localhost';
//$user       = 'igosja_fm';
$user       = 'root';
//$password   = '66xM6RQ51D';
$password   = '';
$database   = 'igosja_fm';

$mysqli = new mysqli($host, $user, $password, $database);

$sql = "SET NAMES 'utf8'";
$mysqli->query($sql);

$sql = "SET `lc_time_names`='ru_RU'";
$mysqli->query($sql);