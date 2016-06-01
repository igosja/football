<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `seriestype_id`,
               `seriestype_name`
        FROM `seriestype`
        ORDER BY `seriestype_id` ASC";
$seriestype_sql = $mysqli->query($sql);

$seriestype_array = $seriestype_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');