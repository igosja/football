<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `eventtype_id`,
               `eventtype_name`
        FROM `eventtype`
        ORDER BY `eventtype_id` ASC";
$eventtype_sql = $mysqli->query($sql);

$eventtype_array = $eventtype_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');