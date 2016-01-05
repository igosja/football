<?php

include ('../include/include.php');

$sql = "SELECT `inboxtheme_id`, `inboxtheme_name`
        FROM `inboxtheme`
        ORDER BY `inboxtheme_id` ASC";
$inboxtheme_sql = $mysqli->query($sql);

$inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('inboxtheme_array', $inboxtheme_array);

$smarty->display('admin_main.html');