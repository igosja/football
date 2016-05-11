<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `inboxtheme_id`,
               `inboxtheme_name`
        FROM `inboxtheme`
        ORDER BY `inboxtheme_id` ASC";
$inboxtheme_sql = $mysqli->query($sql);

$inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');