<?php

include ('../include/include.php');

$sql = "SELECT `stadiumquality_id`, `stadiumquality_name`
        FROM `stadiumquality`
        ORDER BY `stadiumquality_id` ASC";
$stadiumquality_sql = $mysqli->query($sql);

$stadiumquality_array = $stadiumquality_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('stadiumquality_array', $stadiumquality_array);

$smarty->display('admin_main.html');