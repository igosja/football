<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `name_id`,
               `name_name`
        FROM `name`
        ORDER BY `name_name` ASC";
$name_sql = $mysqli->query($sql);

$name_array = $name_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');