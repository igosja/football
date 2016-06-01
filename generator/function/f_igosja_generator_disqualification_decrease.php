<?php

function f_igosja_generator_disqualification_decrease()
//Снятие дисквалификаций
{
    $sql = "SELECT `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            GROUP BY `game_tournament_id`
            ORDER BY `game_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(1);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['game_tournament_id'];

        $sql = "UPDATE `disqualification`
                SET `disqualification_yellow`=`disqualification_yellow`-'2'
                WHERE `disqualification_yellow`>='2'
                AND `disqualification_red`='0'
                AND `disqualification_tournament_id`='$tournament_id'";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `disqualification`
                SET `disqualification_red`=`disqualification_red`-'1'
                WHERE `disqualification_red`>='1'
                AND `disqualification_tournament_id`='$tournament_id'";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}