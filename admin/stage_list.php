<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `stage_id`,
               `stage_name`
        FROM `stage`
        ORDER BY `stage_id` ASC";
$stage_sql = $mysqli->query($sql);

$stage_array = $stage_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');