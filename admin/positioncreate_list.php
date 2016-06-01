<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `position_description`,
               `position_id`,
               `positioncreate_id`
        FROM `positioncreate`
        LEFT JOIN `position`
        ON `positioncreate_position_id`=`position_id`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');