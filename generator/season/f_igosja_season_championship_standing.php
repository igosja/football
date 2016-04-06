<?php

function f_igosja_season_championship_standing()
{
    global $igosja_season_id;

    $sql = "INSERT INTO `standing` (`standing_tournament_id`, `standing_country_id`, `standing_season_id`, `standing_team_id`, `standing_user_id`)
            SELECT `tournament_id`, `city_country_id`, '$igosja_season_id', `team_id`, `team_user_id`
            FROM `team`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            LEFT JOIN `tournament`
            ON `tournament_country_id`=`city_country_id`
            WHERE `team_id`!='0'
            AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
            ORDER BY RAND()";
    f_igosja_mysqli_query($sql);
}