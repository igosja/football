<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `horizontalmenu_id`,
               `horizontalmenu_name`,
               `horizontalmenuchapter_name`
        FROM `horizontalmenu`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenuchapter_id`=`horizontalmenu_horizontalmenuchapter_id`
        ORDER BY `horizontalmenuchapter_name` ASC, `horizontalmenu_name` ASC";
$menu_sql = $mysqli->query($sql);

$menu_array = $menu_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');