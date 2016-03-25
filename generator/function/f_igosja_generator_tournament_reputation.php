<?php

function f_igosja_generator_tournament_reputation()
//Репутация чемпионатов и кубков
{
    global $igosja_season_id;

    $sql = "UPDATE `tournament`
            LEFT JOIN
            (
                SELECT COUNT(`team_id`) AS `count_team`,
                       SUM(`team_reputation`) AS `team_reputation`,
                       `standing_tournament_id`
                FROM `standing`
                LEFT JOIN `team`
                ON `standing_team_id`=`team_id`
                WHERE `standing_season_id`='$igosja_season_id'
                GROUP BY `standing_tournament_id`
            ) AS `t1`
            ON `tournament_id`=`standing_tournament_id`
            SET `tournament_reputation`=`team_reputation`/`count_team`
            WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `tournament`
            LEFT JOIN
            (
                SELECT COUNT(`team_id`) AS `count_team`,
                       SUM(`team_reputation`) AS `team_reputation`,
                       `city_country_id`
                FROM `team`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `team_id`!='0'
                GROUP BY `city_country_id`
            ) AS `t1`
            ON `tournament_country_id`=`city_country_id`
            SET `tournament_reputation`=`team_reputation`/`count_team`
            WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}