<?php

function f_igosja_generator_lineup_practice_and_condition()
//Переносим форму и усталость в составы
{
    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `lineup_condition`=`player_condition`,
                `lineup_practice`=`player_practice`
            WHERE `shedule_date`=CURDATE()
            AND `lineup_position_id`!='0'
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);
}