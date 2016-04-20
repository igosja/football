<?php

function f_igosja_season_champions_league_game()
{
    global $igosja_season_id;
    global $mysqli;

    $sql = "UPDATE `leagueparticipant`
            SET `leagueparticipant_out`='-1'
            WHERE `leagueparticipant_out`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `leagueparticipant` (`leagueparticipant_in`, `leagueparticipant_season_id`, `leagueparticipant_team_id`)
            SELECT '1', '$igosja_season_id', IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_home_team_id`, `game_guest_team_id`)
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
            AND `shedule_season_id`='$igosja_season_id'-'1'
            AND `game_stage_id`='" . CUP_FINAL_STAGE . "'";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `tournament_id`
            FROM `tournament`
            WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
            AND `tournament_level`='1'
            ORDER BY `tournament_reputation` DESC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['tournament_id'];

        $sql = "SELECT `standing_team_id`
                FROM `standing`
                WHERE `standing_tournament_id`='$tournament_id'
                AND `standing_season_id`='$igosja_season_id'-'1'
                ORDER BY `standing_place` ASC
                LIMIT 4";
        $standing_sql = f_igosja_mysqli_query($sql);

        $count_standing = $standing_sql->num_rows;
        $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_standing; $j++)
        {
            $team_id = $standing_array[$j]['standing_team_id'];

            $sql = "SELECT COUNT(`leagueparticipant_id`) AS `count`
                    FROM `leagueparticipant`
                    WHERE `leagueparticipant_team_id`='$team_id'
                    AND `leagueparticipant_season_id`='$igosja_season_id'";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $check = $check_array[0]['count'];

            if (0 == $check)
            {
                $sql = "SELECT COUNT(`leagueparticipant_id`) AS `count`
                        FROM `leagueparticipant`
                        LEFT JOIN `team`
                        ON `team_id`=`leagueparticipant_team_id`
                        LEFT JOIN `city`
                        ON `city_id`=`team_city_id`
                        WHERE `city_country_id`=
                        (
                            SELECT `city_country_id`
                            FROM `city`
                            LEFT JOIN `team`
                            ON `team_city_id`=`city_id`
                            WHERE `team_id`='$team_id'
                        )
                        AND `leagueparticipant_season_id`='$igosja_season_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

                $count = $count_array[0]['count'];

                if (4 > $count)
                {
                    if (2 > $count)
                    {
                        $leagueparticipant_in = 1;
                    }
                    elseif (2 == $count)
                    {
                        if     (0 == $i) { $leagueparticipant_in = 42; }
                        elseif (5 >= $i) { $leagueparticipant_in = 41; }
                        else             { $leagueparticipant_in = 40; }
                    }
                    else
                    {
                        if (5 >= $i) { $leagueparticipant_in = 40; }
                        else         { $leagueparticipant_in = 39; }
                    }

                    $sql = "INSERT INTO `leagueparticipant` 
                            SET `leagueparticipant_in`='$leagueparticipant_in',
                                `leagueparticipant_season_id`='$igosja_season_id',
                                `leagueparticipant_team_id`='$team_id'";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }

    $sql = "INSERT INTO `ratingteamseason` (`ratingteamseason_team_id`, `ratingteamseason_season_id`)
            SELECT `leagueparticipant_team_id`, '$igosja_season_id'
            FROM `leagueparticipant`
            WHERE `leagueparticipant_season_id`='$igosja_season_id'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `leagueparticipant`
            LEFT JOIN `team`
            ON `leagueparticipant_team_id`=`team_id`
            SET `leagueparticipant_user_id`=`team_user_id`
            WHERE `leagueparticipant_season_id`='$igosja_season_id'";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `referee_id`
            FROM `referee`
            ORDER BY RAND()
            LIMIT 8";
    $referee_sql = f_igosja_mysqli_query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_referee; $i++)
    {
        $referee  = 'referee_' . ($i + 1);
        $$referee = $referee_array[$i]['referee_id'];
    }

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` ASC
            LIMIT 2";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_id_1 = $shedule_array[0]['shedule_id'];
    $shedule_id_2 = $shedule_array[1]['shedule_id'];

    $sql = "SELECT `leagueparticipant_team_id`
            FROM `leagueparticipant`
            WHERE `leagueparticipant_season_id`='$igosja_season_id'
            AND `leagueparticipant_in`='39'
            ORDER BY RAND()";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i=$i+2)
    {
        $team_1         = $team_array[$i]['leagueparticipant_team_id'];
        $team_2         = $team_array[$i+1]['leagueparticipant_team_id'];
        $referee_first  = 'referee_' . ($i + 1);
        $referee_second = 'referee_' . ($i + 2);
        $referee_id_1   = $$referee_first;
        $referee_id_2   = $$referee_second;

        $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$team_2',
                        `game_home_team_id`='$team_1',
                        `game_referee_id`='$referee_id_1',
                        `game_stadium_id`='$team_1',
                        `game_stage_id`='39',
                        `game_shedule_id`='$shedule_id_1',
                        `game_temperature`='15'+RAND()*'15',
                        `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                        `game_weather_id`='1'+RAND()*'3'";
        f_igosja_mysqli_query($sql);

        $game_id = $mysqli->insert_id;

        $sql = "INSERT INTO `game`
                    SET `game_first_game_id`='$game_id',
                        `game_guest_team_id`='$team_1',
                        `game_home_team_id`='$team_2',
                        `game_referee_id`='$referee_id_2',
                        `game_stadium_id`='$team_2',
                        `game_stage_id`='39',
                        `game_shedule_id`='$shedule_id_2',
                        `game_temperature`='15'+RAND()*'15',
                        `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                        `game_weather_id`='1'+RAND()*'3'";
        f_igosja_mysqli_query($sql);
    }
}