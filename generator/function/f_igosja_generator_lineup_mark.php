<?php

function f_igosja_generator_lineup_mark()
//Оценки игрокам
{
    $sql = "UPDATE `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            SET `lineup_mark`='6'+RAND()+`lineup_goal`/'2'+`lineup_pass_scoring`/'3'-`lineup_red`/'2'-`lineup_yellow`/'3'
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND (`lineup_position_id` BETWEEN 1 AND 25
            OR `lineup_in`!='0')";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}