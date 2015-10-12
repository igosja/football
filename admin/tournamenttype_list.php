<?php

include ('../include/include.php');

$sql = "SELECT `tournamenttype_id`, `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = $mysqli->query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('tournamenttype_array', $tournamenttype_array);

$smarty->display('admin_main.html');