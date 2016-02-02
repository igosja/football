<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `name_id`, `name_name`
        FROM `name`
        ORDER BY `name_name` ASC";
$name_sql = $mysqli->query($sql);

$name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('name_array', $name_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');