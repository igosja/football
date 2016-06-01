<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `statusteam_id`, `statusteam_name`
        FROM `statusteam`
        ORDER BY `statusteam_id` ASC";
$statusteam_sql = $mysqli->query($sql);

$statusteam_array = $statusteam_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');