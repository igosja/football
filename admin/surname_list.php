<?php

include ('../include/include.php');

$sql = "SELECT `surname_id`, `surname_name`
        FROM `surname`
        ORDER BY `surname_name` ASC";
$surname_sql = $mysqli->query($sql);

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('surname_array', $surname_array);

$smarty->display('admin_main.html');