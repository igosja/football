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

    $sql = "INSERT INTO `ratingcountryseason` (`ratingcountryseason_country_id`, `ratingcountryseason_season_id`)
            SELECT `worldcup_country_id`, '$igosja_season_id'
            FROM `worldcup`
            WHERE `worldcup_season_id`='$igosja_season_id'";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `worldcup_country_id`
            FROM `worldcup`
            WHERE `worldcup_season_id`='$igosja_season_id'
            ORDER BY RAND()";
    $standing_sql = f_igosja_mysqli_query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(1);

    for($i=0; $i<$count_standing; $i++)
    {
        $country_id = $standing_array[$i]['worldcup_country_id'];

        $sql = "SELECT `stadium_id`
                FROM `stadium`
                LEFT JOIN `team`
                ON `stadium_team_id`=`team_id`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `city_country_id`='$country_id'
                ORDER BY `stadium_capacity` DESC
                LIMIT 1";
        $stadium_sql = f_igosja_mysqli_query($sql);

        $stadium_array = $stadium_sql->fetch_all(1);

        $stadium_id = $stadium_array[0]['stadium_id'];

        $sql = "UPDATE `country`
                SET `country_stadium_id`='$stadium_id'
                WHERE `country_id`='$country_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}