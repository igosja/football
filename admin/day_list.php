<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `day_id`
        FROM `day`
        ORDER BY `day_id` ASC";
$day_sql = $mysqli->query($sql);

$day_array = $day_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('day_array', $day_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');