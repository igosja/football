<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `inboxtheme_id`, `inboxtheme_name`
        FROM `inboxtheme`
        ORDER BY `inboxtheme_id` ASC";
$inboxtheme_sql = $mysqli->query($sql);

$inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('inboxtheme_array', $inboxtheme_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');