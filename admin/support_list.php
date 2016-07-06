<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`,
               `user_login`,
               `user_id`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='0'
        AND `inbox_support`='1'
        ORDER BY `inbox_id` DESC";
$support_sql = $mysqli->query($sql);

$support_array = $support_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');