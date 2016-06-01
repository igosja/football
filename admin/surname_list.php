<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        ORDER BY `surname_name` ASC";
$surname_sql = $mysqli->query($sql);

$surname_array = $surname_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');