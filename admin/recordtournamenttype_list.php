<?php

include ('../include/include.php');

$sql = "SELECT `recordtournamenttype_id`, `recordtournamenttype_name`
        FROM `recordtournamenttype`
        ORDER BY `recordtournamenttype_id` ASC";
$recordtournamenttype_sql = $mysqli->query($sql);

$recordtournamenttype_array = $recordtournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('recordtournamenttype_array', $recordtournamenttype_array);

$smarty->display('admin_main.html');