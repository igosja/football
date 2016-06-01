<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `recordteamtype_id`,
               `recordteamtype_name`
        FROM `recordteamtype`
        ORDER BY `recordteamtype_id` ASC";
$recordteamtype_sql = $mysqli->query($sql);

$recordteamtype_array = $recordteamtype_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');