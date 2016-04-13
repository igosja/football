<?php

function f_igosja_season_worldcup_standing()
{
    global $igosja_season_id;

    $sql = "INSERT INTO `worldcup` (`worldcup_country_id`, `worldcup_season_id`, `worldcup_tournament_id`, `worldcup_user_id`)
            SELECT `country_id`, '$igosja_season_id', '" . TOURNAMENT_WORLD_CUP . "', `country_user_id`
            FROM `country`
            WHERE `country_id` IN
            (
                SELECT `city_country_id`
                FROM `city`
                WHERE `city_id`!='0'
            )
            ORDER BY RAND()";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}