<?php

function f_igosja_generator_standing_history()
//Предыдущие позиции в турнирной таблице
{
    global $igosja_season_id;

    $sql = "SELECT `game_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE `shedule_date`=CURDATE()
            AND `tournament_tournamenttype_id`='2'
            ORDER BY `game_id`
            LIMIT 1";
    $check_sql = f_igosja_mysqli_query($sql);

    $count = $check_sql->num_rows;

    if (0 != $count)
    {
        $sql = "INSERT INTO `standinghistory`
                (
                    `standinghistory_tournament_id`,
                    `standinghistory_team_id`,
                    `standinghistory_stage_id`,
                    `standinghistory_place`
                )
                SELECT `standing_tournament_id`,
                       `standing_team_id`,
                       `standing_game`,
                       `standing_place`
                FROM `standing`
                WHERE `standing_season_id`='$igosja_season_id'";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}