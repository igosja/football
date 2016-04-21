<?php

function f_igosja_season_cup_game()
{
    global $igosja_season_id;
    global $mysqli;

    $sql = "SELECT `tournament_id`,
                   `tournament_country_id`
            FROM `tournament`
            WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
            ORDER BY `tournament_country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_country; $i++)
    {
        $country_id = $country_array[$i]['tournament_country_id'];

        $sql = "SELECT `referee_id`
                FROM `referee`
                WHERE `referee_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 8";
        $referee_sql = f_igosja_mysqli_query($sql);

        $count_referee = $referee_sql->num_rows;
        $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_referee; $j++)
        {
            $referee  = 'referee_' . ($j + 1);
            $$referee = $referee_array[$j]['referee_id'];
        }

        $tournament_id  = $country_array[$i]['tournament_id'];

        $sql = "INSERT INTO `cupparticipant` (`cupparticipant_team_id`, `cupparticipant_tournament_id`, `cupparticipant_season_id`, `cupparticipant_user_id`)
                SELECT `team_id`, '$tournament_id', '$igosja_season_id', `team_user_id`
                FROM `team`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `city_country_id`='$country_id'";
        f_igosja_mysqli_query($sql);

        $sql = "SELECT `shedule_id`
                FROM `shedule`
                WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 2";
        $shedule_sql = f_igosja_mysqli_query($sql);

        $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

        $shedule_id_1 = $shedule_array[0]['shedule_id'];
        $shedule_id_2 = $shedule_array[1]['shedule_id'];

        $sql = "SELECT `cupparticipant_team_id`
                FROM `cupparticipant`
                WHERE `cupparticipant_tournament_id`='$tournament_id'
                AND `cupparticipant_season_id`='$igosja_season_id'
                ORDER BY RAND()
                LIMIT 8";
        $team_sql = f_igosja_mysqli_query($sql);

        $count_team = $team_sql->num_rows;
        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_team; $j=$j+2)
        {
            $team_1         = $team_array[$j]['cupparticipant_team_id'];
            $team_2         = $team_array[$j+1]['cupparticipant_team_id'];
            $referee_first  = 'referee_' . ($j + 1);
            $referee_second = 'referee_' . ($j + 2);
            $referee_id_1   = $$referee_first;
            $referee_id_2   = $$referee_second;

            $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$team_2',
                        `game_home_team_id`='$team_1',
                        `game_referee_id`='$referee_id_1',
                        `game_stadium_id`='$team_1',
                        `game_stage_id`='45',
                        `game_shedule_id`='$shedule_id_1',
                        `game_temperature`='15'+RAND()*'15',
                        `game_tournament_id`='$tournament_id',
                        `game_weather_id`='1'+RAND()*'3'";
            f_igosja_mysqli_query($sql);

            $game_id = $mysqli->insert_id;

            $sql = "INSERT INTO `game`
                    SET `game_first_game_id`='$game_id',
                        `game_guest_team_id`='$team_1',
                        `game_home_team_id`='$team_2',
                        `game_referee_id`='$referee_id_2',
                        `game_stadium_id`='$team_2',
                        `game_stage_id`='45',
                        `game_shedule_id`='$shedule_id_2',
                        `game_temperature`='15'+RAND()*'15',
                        `game_tournament_id`='$tournament_id',
                        `game_weather_id`='1'+RAND()*'3'";
            f_igosja_mysqli_query($sql);
        }
    }
}