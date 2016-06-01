<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `newstheme_id`, `newstheme_name`
        FROM `newstheme`
        ORDER BY `newstheme_id` ASC";
$newstheme_sql = $mysqli->query($sql);

$newstheme_array = $newstheme_sql->fetch_all(1);

$smarty->assign('newstheme_array', $newstheme_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');