<?php

include ('../include/include.php');

$sql = "SELECT `gamestyle_id`, `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('gamestyle_array', $gamestyle_array);

$smarty->display('admin_main.html');