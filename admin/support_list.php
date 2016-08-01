<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT MAX(`inbox_date`) AS `inbox_date`,
               MAX(`inbox_id`) AS `inbox_id`,
               MAX(`inbox_read`) AS `inbox_read`,
               `inbox_title`,
               `user_login`,
               `user_id`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='0'
        AND `inbox_support`='1'
        GROUP BY `user_id`
        ORDER BY `inbox_id` DESC";
$support_sql = $mysqli->query($sql);

$support_array = $support_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');