<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `staffpost_id`,
               `staffpost_name`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$post_sql = $mysqli->query($sql);

$post_array = $post_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');