<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `seriestype_id`, `seriestype_name`
        FROM `seriestype`
        ORDER BY `seriestype_id` ASC";
$seriestype_sql = $mysqli->query($sql);

$seriestype_array = $seriestype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('seriestype_array', $seriestype_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');