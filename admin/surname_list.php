<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `surname_id`, `surname_name`
        FROM `surname`
        ORDER BY `surname_name` ASC";
$surname_sql = $mysqli->query($sql);

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('surname_array', $surname_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');