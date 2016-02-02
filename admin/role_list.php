<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `role_id`, `role_name`, `role_short`
        FROM `role`
        ORDER BY `role_id` ASC";
$role_sql = $mysqli->query($sql);

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('role_array', $role_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');