<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `statusnational_id`, `statusnational_name`
        FROM `statusnational`
        ORDER BY `statusnational_id` ASC";
$statusnational_sql = $mysqli->query($sql);

$statusnational_array = $statusnational_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('statusnational_array', $statusnational_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');