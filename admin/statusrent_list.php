<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `statusrent_id`,
               `statusrent_name`
        FROM `statusrent`
        ORDER BY `statusrent_id` ASC";
$statusrent_sql = $mysqli->query($sql);

$statusrent_array = $statusrent_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');