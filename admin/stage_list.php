<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `stage_id`, `stage_name`
        FROM `stage`
        ORDER BY `stage_id` ASC";
$stage_sql = $mysqli->query($sql);

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('stage_array', $stage_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');