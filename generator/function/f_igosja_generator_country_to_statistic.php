<?php

function f_igosja_generator_country_to_statistic()
//Добавляем сборных в статистические таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`,
                   `lineup_country_id`,
                   `statisticcountry_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN
            (
                SELECT `statisticcountry_id`,
                       `statisticcountry_country_id`,
                       `statisticcountry_tournament_id`
                FROM `statisticcountry`
                WHERE `statisticcountry_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticcountry_tournament_id`=`game_tournament_id`
            AND `statisticcountry_country_id`=`lineup_country_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            GROUP BY `lineup_country_id`
            ORDER BY `game_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_country; $i++)
    {
        $statisticcountry_id = $country_array[$i]['statisticcountry_id'];

        if (!$statisticcountry_id)
        {
            $country_id = $country_array[$i]['lineup_country_id'];

            if (0 != $country_id)
            {
                $tournament_id  = $country_array[$i]['game_tournament_id'];

                $sql = "INSERT INTO `statisticcountry`
                        SET `statisticcountry_tournament_id`='$tournament_id',
                            `statisticcountry_season_id`='$igosja_season_id',
                            `statisticcountry_country_id`='$country_id'";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}