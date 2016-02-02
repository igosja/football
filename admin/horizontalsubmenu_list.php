<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `horizontalmenu_name`, `horizontalmenuchapter_name`, `horizontalsubmenu_href`, `horizontalsubmenu_id`, `horizontalsubmenu_name`
        FROM `horizontalsubmenu`
        LEFT JOIN `horizontalmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenuchapter_id`=`horizontalmenu_horizontalmenuchapter_id`
        ORDER BY `horizontalmenuchapter_id` ASC, `horizontalmenu_id` ASC, `horizontalsubmenu_id` ASC";
$menu_sql = $mysqli->query($sql);

$menu_array = $menu_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('menu_array', $menu_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');