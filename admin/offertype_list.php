<?php

include ('../include/include.php');

$sql = "SELECT `offertype_id`, `offertype_name`
        FROM `offertype`
        ORDER BY `offertype_id` ASC";
$offertype_sql = $mysqli->query($sql);

$offertype_array = $offertype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('offertype_array', $offertype_array);

$smarty->display('admin_main.html');