<?php

include ('../include/include.php');

$sql = "SELECT `formation_id`, `formation_name`
        FROM `formation`
        ORDER BY `formation_id` ASC";
$formation_sql = $mysqli->query($sql);

$formation_array = $formation_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('formation_array', $formation_array);

$smarty->display('admin_main.html');