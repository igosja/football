<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `buyer`.`team_name` AS `buyer_name`,
               `name_name`,
               `seller`.`team_name` AS `seller_name`,
               `surname_name`,
               `transfer_buyer_id`,
               `transfer_id`,
               `transfer_player_id`,
               `transfer_price`,
               `transfer_seller_id`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team` AS `buyer`
        ON `buyer`.`team_id`=`transfer_buyer_id`
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transfer_seller_id`
        ORDER BY `transfer_id` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');