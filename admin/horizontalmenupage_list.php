<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `horizontalmenuchapter_name`,
               `horizontalmenupage_id`,
               `horizontalmenupage_name`
        FROM `horizontalmenupage`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenupage_horizontalmenuchapter_id`=`horizontalmenuchapter_id`
        ORDER BY `horizontalmenupage_name` ASC";
$horizontalmenupage_sql = $mysqli->query($sql);

$horizontalmenupage_array = $horizontalmenupage_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');