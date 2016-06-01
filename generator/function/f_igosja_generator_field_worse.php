<?php

function f_igosja_generator_field_worse()
//Ухудшение состояния газона
{
    global $igosja_season_id;

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            AND `game_stage_id` IN ('10', '20', '30')
            AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);
    $count_game = $game_array[0]['count'];

    if (0 != $count_game)
    {
        $sql = "UPDATE `stadium`
                SET `stadium_stadiumquality_id`=`stadium_stadiumquality_id`-'1'
                WHERE `stadium_id`!='0'";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}