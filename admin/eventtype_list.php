<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `eventtype_id`, `eventtype_name`
        FROM `eventtype`
        ORDER BY `eventtype_id` ASC";
$eventtype_sql = $mysqli->query($sql);

$eventtype_array = $eventtype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('eventtype_array', $eventtype_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');