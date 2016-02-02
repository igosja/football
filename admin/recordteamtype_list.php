<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `recordteamtype_id`, `recordteamtype_name`
        FROM `recordteamtype`
        ORDER BY `recordteamtype_id` ASC";
$recordteamtype_sql = $mysqli->query($sql);

$recordteamtype_array = $recordteamtype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('recordteamtype_array', $recordteamtype_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');