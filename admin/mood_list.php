<?php

include ('../include/include.php');

$sql = "SELECT `mood_id`, `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = $mysqli->query($sql);

$mood_array = $mood_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('mood_array', $mood_array);

$smarty->display('admin_main.html');