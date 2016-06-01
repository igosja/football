<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `gamestyle_id`,
               `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');