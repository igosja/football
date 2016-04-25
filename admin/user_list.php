<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `user_id`,
               `user_last_visit`,
               `user_login`
        FROM `user`
        WHERE `user_id`!='0'
        AND `user_activation`='0'
        ORDER BY `user_last_visit` DESC";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');