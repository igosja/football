<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `eventtype_id`,
               `eventtype_name`,
               `game_id`,
               `shedule_date`
        FROM `event`
        LEFT JOIN `eventtype`
        ON `eventtype_id`=`event_eventtype_id`
        LEFT JOIN `game`
        ON `game_id`=`event_game_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        WHERE `event_player_id`='0'
        ORDER BY `event_id` ASC";
$event_sql = $mysqli->query($sql);

$event_array = $event_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');