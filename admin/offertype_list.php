<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `offertype_id`, `offertype_name`
        FROM `offertype`
        ORDER BY `offertype_id` ASC";
$offertype_sql = $mysqli->query($sql);

$offertype_array = $offertype_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');