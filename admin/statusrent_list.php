<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `statusrent_id`, `statusrent_name`
        FROM `statusrent`
        ORDER BY `statusrent_id` ASC";
$statusrent_sql = $mysqli->query($sql);

$statusrent_array = $statusrent_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('statusrent_array', $statusrent_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');