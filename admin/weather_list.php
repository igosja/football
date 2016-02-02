<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `weather_id`, `weather_name`
        FROM `weather`
        ORDER BY `weather_id` ASC";
$weather_sql = $mysqli->query($sql);

$weather_array = $weather_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('weather_array', $weather_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');