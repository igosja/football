<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `statusteam_id`, `statusteam_name`
        FROM `statusteam`
        ORDER BY `statusteam_id` ASC";
$statusteam_sql = $mysqli->query($sql);

$statusteam_array = $statusteam_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('statusteam_array', $statusteam_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');