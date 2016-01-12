<?php

include ('../include/include.php');

$sql = "SELECT `newstheme_id`, `newstheme_name`
        FROM `newstheme`
        ORDER BY `newstheme_id` ASC";
$newstheme_sql = $mysqli->query($sql);

$newstheme_array = $newstheme_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('newstheme_array', $newstheme_array);

$smarty->display('admin_main.html');