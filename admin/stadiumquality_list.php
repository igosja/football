<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `stadiumquality_id`, `stadiumquality_name`
        FROM `stadiumquality`
        ORDER BY `stadiumquality_id` ASC";
$stadiumquality_sql = $mysqli->query($sql);

$stadiumquality_array = $stadiumquality_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('stadiumquality_array', $stadiumquality_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');