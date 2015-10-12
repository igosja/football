<?php

include ('../include/include.php');

$sql = "SELECT `day_id`
        FROM `day`
        ORDER BY `day_id` ASC";
$day_sql = $mysqli->query($sql);

$day_array = $day_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('day_array', $day_array);

$smarty->display('admin_main.html');