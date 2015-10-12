<?php

include ('../include/include.php');

$sql = "SELECT `position_description`, `position_id`, `positioncreate_id`
        FROM `positioncreate`
        LEFT JOIN `position`
        ON `positioncreate_position_id`=`position_id`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_array', $position_array);

$smarty->display('admin_main.html');