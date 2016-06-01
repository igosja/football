<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `horizontalmenuchapter_id`,
               `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');