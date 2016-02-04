<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='-1'
        ORDER BY `inbox_id` DESC";
$support_sql = $mysqli->query($sql);

$support_array = $support_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');