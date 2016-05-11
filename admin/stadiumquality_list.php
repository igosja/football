<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `stadiumquality_id`,
               `stadiumquality_name`
        FROM `stadiumquality`
        ORDER BY `stadiumquality_id` ASC";
$stadiumquality_sql = $mysqli->query($sql);

$stadiumquality_array = $stadiumquality_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');