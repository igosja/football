<?php

include ('../include/include.php');

$sql = "SELECT `gamemood_id`, `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('gamemood_array', $gamemood_array);

$smarty->display('admin_main.html');