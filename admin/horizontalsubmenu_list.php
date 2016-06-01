<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `horizontalmenu_name`,
               `horizontalmenuchapter_name`,
               `horizontalsubmenu_href`,
               `horizontalsubmenu_id`,
               `horizontalsubmenu_name`
        FROM `horizontalsubmenu`
        LEFT JOIN `horizontalmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenuchapter_id`=`horizontalmenu_horizontalmenuchapter_id`
        ORDER BY `horizontalmenuchapter_id` ASC, `horizontalmenu_id` ASC, `horizontalsubmenu_id` ASC";
$menu_sql = $mysqli->query($sql);

$menu_array = $menu_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');