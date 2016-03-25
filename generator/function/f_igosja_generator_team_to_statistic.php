<?php

function f_igosja_generator_team_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`,
                   `lineup_team_id`,
                   `statisticteam_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN
            (
                SELECT `statisticteam_id`,
                       `statisticteam_team_id`,
                       `statisticteam_tournament_id`
                FROM `statisticteam`
                WHERE `statisticteam_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticteam_tournament_id`=`game_tournament_id`
            AND `statisticteam_team_id`=`lineup_team_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            GROUP BY `lineup_team_id`
            ORDER BY `game_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $statisticteam_id = $team_array[$i]['statisticteam_id'];

        if (!$statisticteam_id)
        {
            $team_id        = $team_array[$i]['lineup_team_id'];

            if (0 != $team_id)
            {
                $tournament_id  = $team_array[$i]['game_tournament_id'];

                $sql = "INSERT INTO `statisticteam`
                        SET `statisticteam_tournament_id`='$tournament_id',
                            `statisticteam_season_id`='$igosja_season_id',
                            `statisticteam_team_id`='$team_id'";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}