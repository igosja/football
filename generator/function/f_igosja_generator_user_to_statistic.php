<?php

function f_igosja_generator_user_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `statisticuser_id`,
                   `team_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `team`
            ON `lineup_team_id`=`team_id`
            LEFT JOIN
            (
                SELECT `statisticuser_id`,
                       `statisticuser_user_id`
                FROM `statisticuser`
                WHERE `statisticuser_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticuser_user_id`=`team_user_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            AND `team_user_id`!='0'
            GROUP BY `team_user_id`
            ORDER BY `game_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_user; $i++)
    {
        $statisticuser_id = $user_array[$i]['statisticuser_id'];

        if (!$statisticuser_id)
        {
            $user_id = $user_array[$i]['team_user_id'];

            $sql = "INSERT INTO `statisticuser`
                    SET `statisticuser_season_id`='$igosja_season_id',
                        `statisticuser_user_id`='$user_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `statisticuser_id`,
                   `country_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `country`
            ON `lineup_country_id`=`country_id`
            LEFT JOIN
            (
                SELECT `statisticuser_id`,
                       `statisticuser_user_id`
                FROM `statisticuser`
                WHERE `statisticuser_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticuser_user_id`=`country_user_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            AND `country_user_id`!='0'
            GROUP BY `country_user_id`
            ORDER BY `game_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_user; $i++)
    {
        $statisticuser_id = $user_array[$i]['statisticuser_id'];

        if (!$statisticuser_id)
        {
            $user_id = $user_array[$i]['country_user_id'];

            $sql = "INSERT INTO `statisticuser`
                    SET `statisticuser_season_id`='$igosja_season_id',
                        `statisticuser_user_id`='$user_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}