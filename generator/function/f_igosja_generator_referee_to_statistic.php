<?php

function f_igosja_generator_referee_to_statistic()
//Добавляем судей в статистические таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_referee_id`,
                   `game_tournament_id`,
                   `statisticreferee_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN
            (
                SELECT `statisticreferee_id`,
                       `statisticreferee_referee_id`,
                       `statisticreferee_tournament_id`
                FROM `statisticreferee`
                WHERE `statisticreferee_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticreferee_id`=`game_referee_id`
            AND `statisticreferee_tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            GROUP BY `game_referee_id`
            ORDER BY `game_id` ASC";
    $referee_sql = f_igosja_mysqli_query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_referee; $i++)
    {
        $statisticreferee_id = $referee_array[$i]['statisticreferee_id'];

        if (!$statisticreferee_id)
        {
            $referee_id     = $referee_array[$i]['game_referee_id'];
            $tournament_id  = $referee_array[$i]['game_tournament_id'];

            $sql = "INSERT INTO `statisticreferee`
                    SET `statisticreferee_tournament_id`='$tournament_id',
                        `statisticreferee_season_id`='$igosja_season_id',
                        `statisticreferee_referee_id`='$referee_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}