<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `mood_id`, `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = $mysqli->query($sql);

$mood_array = $mood_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('mood_array', $mood_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');