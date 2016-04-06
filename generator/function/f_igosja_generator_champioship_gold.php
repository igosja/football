<?php

function f_igosja_generator_championship_gold()
//Кубковые турниры - следующая стадия
{
    global $igosja_season_id;

    $sql = "SELECT `game_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `game_stage_id`='" . CHAMPIONSHIP_LAST_STAGE . "'
            AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
            AND `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC
            LIMIT 1";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;

    if (0 != $count_game)
    {
        $sql = "SELECT `shedule_id`
                FROM `shedule`
                WHERE `shedule_season_id`='$igosja_season_id'
                AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
                ORDER BY `shedule_id` DESC
                LIMIT 1";
        $shedule_sql = f_igosja_mysqli_query($sql);

        $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

        $shedule_id = $shedule_array[0]['shedule_id'];

        $sql = "SELECT `standing_country_id`,
                       `standing_tournament_id`
                FROM `standing`
                WHERE `standing_season_id`='$igosja_season_id'
                AND `standing_place`='1'";
        $country_sql = f_igosja_mysqli_query($sql);

        $count_country = $country_sql->num_rows;
        $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_country; $i++)
        {
            $country_id     = $country_array[$i]['standing_country_id'];
            $tournament_id  = $country_array[$i]['standing_tournament_id'];

            $sql = "SELECT `standing_point`,
                           `standing_team_id`
                    FROM `standing`
                    WHERE `standing_season_id`='$igosja_season_id'
                    AND `standing_country_id`='$country_id'
                    AND `standing_place` IN ('1', '2')
                    ORDER BY `standing_place` ASC
                    LIMIT 2";
            $standing_sql = f_igosja_mysqli_query($sql);

            $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

            $point_first    = $standing_array[0]['standing_point'];
            $point_second   = $standing_array[1]['standing_point'];

            if ($point_first == $point_second)
            {
                $team_1 = $standing_array[0]['standing_team_id'];
                $team_2 = $standing_array[1]['standing_team_id'];

                $sql = "SELECT `referee_id`
                        FROM `referee`
                        WHERE `referee_country_id`='$country_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $referee_sql = f_igosja_mysqli_query($sql);

                $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

                $referee_id = $referee_array[0]['referee_id'];

                $sql = "INSERT INTO `game`
                        SET `game_field_bonus`='0',
                            `game_guest_team_id`='$team_1',
                            `game_home_team_id`='$team_2',
                            `game_referee_id`='$referee_id',
                            `game_stadium_id`='$team_1',
                            `game_stage_id`='" . CHAMPIONSHIP_GOLD_GAME_STAGE . "',
                            `game_shedule_id`='$shedule_id',
                            `game_temperature`='15'+RAND()*'15',
                            `game_tournament_id`='$tournament_id',
                            `game_weather_id`='1'+RAND()*'3'";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}