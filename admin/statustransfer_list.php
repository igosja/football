<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `statustransfer_id`,
               `statustransfer_name`
        FROM `statustransfer`
        ORDER BY `statustransfer_id` ASC";
$statustransfer_sql = $mysqli->query($sql);

$statustransfer_array = $statustransfer_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');