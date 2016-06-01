<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `weather_id`,
               `weather_name`
        FROM `weather`
        ORDER BY `weather_id` ASC";
$weather_sql = $mysqli->query($sql);

$weather_array = $weather_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');