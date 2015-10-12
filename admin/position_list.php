<?php

include ('../include/include.php');

$sql = "SELECT `position_description`, `position_id`, `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_array', $position_array);

$smarty->display('admin_main.html');