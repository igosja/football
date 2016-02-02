<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `statustransfer_id`, `statustransfer_name`
        FROM `statustransfer`
        ORDER BY `statustransfer_id` ASC";
$statustransfer_sql = $mysqli->query($sql);

$statustransfer_array = $statustransfer_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('statustransfer_array', $statustransfer_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');