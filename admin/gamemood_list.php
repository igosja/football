<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `gamemood_id`,
               `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');