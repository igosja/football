<?php

function f_igosja_generator_player_condition_practice()
//Обновляем усталость и игровую практику футболистам
{
    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            SET `lineup_condition`=`lineup_condition`-'13'-`player_age`/'5'-`stadium_stadiumquality_id`,
                `lineup_practice`=`lineup_practice`+'10'+`player_age`/'5'
            WHERE `shedule_date`=CURDATE()
            AND `lineup_position_id`<='25'
            AND `lineup_position_id`!='0'
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `player_condition`=`lineup_condition`,
                `player_practice`=`lineup_practice`
            WHERE `shedule_date`=CURDATE()
            AND `lineup_position_id`<='25'
            AND `lineup_position_id`!='0'
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`=`player_condition`+'3'+('45'-`player_age`)/'2',
                `player_practice`=`player_practice`-'1'-'2'*RAND()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`='100'
            WHERE `player_condition`>'100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`='50'
            WHERE `player_condition`<'50'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='100'
            WHERE `player_practice`>'100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='50'
            WHERE `player_practice`<'50'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}