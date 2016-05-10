<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `statusnational_id`,
               `statusnational_name`
        FROM `statusnational`
        ORDER BY `statusnational_id` ASC";
$statusnational_sql = $mysqli->query($sql);

$statusnational_array = $statusnational_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');