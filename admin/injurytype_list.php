<?php

include ('../include/include.php');

$sql = "SELECT `injurytype_id`, `injurytype_day`, `injurytype_name`
        FROM `injurytype`
        ORDER BY `injurytype_id` ASC";
$injurytype_sql = $mysqli->query($sql);

$injurytype_array = $injurytype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('injurytype_array', $injurytype_array);

$smarty->display('admin_main.html');