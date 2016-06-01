<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `mood_id`, `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = $mysqli->query($sql);

$mood_array = $mood_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');