<?php

function f_igosja_generator_champions_league_next_stage()
//Лига чемпионов - следующая стадия
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `shedule_tournamenttype_id`
            FROM `shedule`
            WHERE `shedule_date`=CURDATE()
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $tournamenttype_id = $shedule_array[0]['shedule_tournamenttype_id'];

    if (TOURNAMENT_TYPE_CHAMPIONS_LEAGUE == $tournamenttype_id)
    {
        $sql = "SELECT `game_first_game_id`,
                       `game_guest_score`,
                       `game_guest_shoot_out`,
                       `game_guest_team_id`,
                       `game_home_score`,
                       `game_home_shoot_out`,
                       `game_home_team_id`,
                       `game_stage_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `game_first_game_id`!='0'
                ORDER BY `game_id` ASC";
        $game_sql = f_igosja_mysqli_query($sql);

        $count_game = $game_sql->num_rows;
        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_game; $i++)
        {
            $game_id         = $game_array[$i]['game_first_game_id'];
            $home_score      = $game_array[$i]['game_home_score'];
            $home_shoot_out  = $game_array[$i]['game_home_shoot_out'];
            $home_team_id    = $game_array[$i]['game_home_team_id'];
            $guest_score     = $game_array[$i]['game_guest_score'];
            $guest_shoot_out = $game_array[$i]['game_guest_shoot_out'];
            $guest_team_id   = $game_array[$i]['game_guest_team_id'];
            $stage_id        = $game_array[$i]['game_stage_id'];

            $sql = "SELECT `game_guest_score`,
                           `game_home_score`
                    FROM `game`
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $first_game_sql = f_igosja_mysqli_query($sql);

            $first_game_array = $first_game_sql->fetch_all(MYSQLI_ASSOC);

            $first_home_score  = $first_game_array[0]['game_home_score'];
            $first_guest_score = $first_game_array[0]['game_guest_score'];

            if ($home_score + $home_shoot_out + $first_guest_score > $guest_score + $guest_shoot_out + $first_home_score)
            {
                $looser = $guest_team_id;
            }
            else
            {
                $looser = $home_team_id;
            }

            $sql = "UPDATE `leagueparticipant`
                    SET `leagueparticipant_out`='$stage_id'
                    WHERE `leagueparticipant_team_id`='$looser'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        if (0 != $count_game && in_array($stage_id, array(39, 40, 41, 46, 47, 48)))
        {
            if (in_array($stage_id, array(39, 40, 41)))
            {
                $and_sql = "`leagueparticipant_in`!='1'";
            }
            else
            {
                $and_sql = "1";
            }

            $sql = "SELECT `shedule_id`
                    FROM `shedule`
                    WHERE `shedule_date`>CURDATE()
                    AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
                    ORDER BY `shedule_date` ASC
                    LIMIT 2";
            $shedule_sql = f_igosja_mysqli_query($sql);

            $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

            $shedule_1 = $shedule_array[0]['shedule_id'];
            $shedule_2 = $shedule_array[1]['shedule_id'];

            $sql = "SELECT `leagueparticipant_team_id`
                    FROM `leagueparticipant`
                    WHERE `leagueparticipant_out`='0'
                    AND `leagueparticipant_in`<='$stage_id'+'1'
                    AND $and_sql
                    ORDER BY RAND()";
            $team_sql = f_igosja_mysqli_query($sql);

            $count_team = $team_sql->num_rows;
            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            for ($j=0; $j<$count_team; $j=$j+2)
            {
                $team_1 = $team_array[$j]['leagueparticipant_team_id'];
                $team_2 = $team_array[$j+1]['leagueparticipant_team_id'];

                $sql = "INSERT INTO `game`
                        SET `game_guest_team_id`='$team_2',
                            `game_home_team_id`='$team_1',
                            `game_referee_id`='1',
                            `game_stadium_id`='$team_1',
                            `game_stage_id`='$stage_id'+'1',
                            `game_shedule_id`='$shedule_1',
                            `game_temperature`='15'+RAND()*'15',
                            `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                            `game_weather_id`='1'+RAND()*'3'";
                $mysqli->query($sql);

                $game_id = $mysqli->insert_id;

                $sql = "INSERT INTO `game`
                        SET `game_first_game_id`='$game_id',
                            `game_guest_team_id`='$team_1',
                            `game_home_team_id`='$team_2',
                            `game_referee_id`='1',
                            `game_stadium_id`='$team_2',
                            `game_stage_id`='$stage_id'+'1',
                            `game_shedule_id`='$shedule_2',
                            `game_temperature`='15'+RAND()*'15',
                            `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                            `game_weather_id`='1'+RAND()*'3'";
                $mysqli->query($sql);
            }
        }
        elseif (0 != $count_game && 42 == $stage_id)
        {
            $sql = "INSERT INTO `league` (`league_season_id`, `league_team_id`)
                    SELECT '$igosja_season_id', `leagueparticipant_team_id`
                    FROM `leagueparticipant`
                    WHERE `leagueparticipant_out`='0'
                    AND `leagueparticipant_in`<='$stage_id'
                    ORDER BY RAND()";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `league_id`
                    FROM `league`
                    WHERE `league_season_id`='$igosja_season_id'";
            $league_sql = f_igosja_mysqli_query($sql);

            $count_league = $league_sql->num_rows;
            $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

            for ($j=0; $j<$count_league; $j++)
            {
                if     (0 == $j % 8) {$group = 'A';}
                elseif (1 == $j % 8) {$group = 'B';}
                elseif (2 == $j % 8) {$group = 'C';}
                elseif (3 == $j % 8) {$group = 'D';}
                elseif (4 == $j % 8) {$group = 'E';}
                elseif (5 == $j % 8) {$group = 'F';}
                elseif (6 == $j % 8) {$group = 'G';}
                elseif (7 == $j % 8) {$group = 'H';}

                $league_id = $league_array[$j]['league_id'];

                $sql = "UPDATE `league`
                        SET `league_group`='$group'
                        WHERE `league_id`='$league_id'";
                f_igosja_mysqli_query($sql);
            }

            $sql = "SELECT `shedule_id`
                    FROM `shedule`
                    WHERE `shedule_date`>CURDATE()
                    AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
                    ORDER BY `shedule_date` ASC
                    LIMIT 6";
            $shedule_sql = f_igosja_mysqli_query($sql);

            $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

            $shedule_1 = $shedule_array[0]['shedule_id'];
            $shedule_2 = $shedule_array[1]['shedule_id'];
            $shedule_3 = $shedule_array[2]['shedule_id'];
            $shedule_4 = $shedule_array[3]['shedule_id'];
            $shedule_5 = $shedule_array[4]['shedule_id'];
            $shedule_6 = $shedule_array[5]['shedule_id'];

            $sql = "SELECT `league_group`
                    FROM `league`
                    WHERE `league_season_id`='$igosja_season_id'
                    GROUP BY `league_group`
                    ORDER BY `league_group` ASC";
            $group_sql = f_igosja_mysqli_query($sql);

            $count_group = $group_sql->num_rows;
            $group_array = $group_sql->fetch_all(MYSQLI_ASSOC);

            for ($j=0; $j<$count_group; $j++)
            {
                $group_name = $group_array[$j]['league_group'];

                $sql = "SELECT `league_team_id`
                        FROM `league`
                        WHERE `league_group`='$group_name'
                        AND `league_season_id`='$igosja_season_id'
                        ORDER BY RAND()";
                $league_sql = f_igosja_mysqli_query($sql);

                $count_league = $league_sql->num_rows;
                $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

                for($k=0; $k<$count_league; $k++)
                {
                    $team_num   = $k + 1;
                    $team       = 'team_' . $team_num;
                    $$team      = $league_array[$k]['league_team_id'];
                }

                $sql = "INSERT INTO `game`
                        (
                            `game_home_team_id`,
                            `game_guest_team_id`,
                            `game_referee_id`,
                            `game_stadium_id`,
                            `game_stage_id`,
                            `game_shedule_id`,
                            `game_temperature`,
                            `game_tournament_id`,
                            `game_weather_id`
                        )
                        VALUES  ('$team_1','$team_2','1','$team_1','1','$shedule_1','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_4','$team_3','1','$team_4','1','$shedule_1','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_3','$team_1','1','$team_3','2','$shedule_2','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_2','$team_4','1','$team_2','2','$shedule_2','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_1','$team_4','1','$team_1','3','$shedule_3','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_2','$team_3','1','$team_2','3','$shedule_3','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_2','$team_1','1','$team_2','4','$shedule_4','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_3','$team_4','1','$team_3','4','$shedule_4','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_1','$team_3','1','$team_1','5','$shedule_5','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_4','$team_2','1','$team_4','5','$shedule_5','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_4','$team_1','1','$team_4','6','$shedule_6','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3'),
                                ('$team_3','$team_2','1','$team_3','6','$shedule_6','15'+RAND()*'15','" . TOURNAMENT_CHAMPIONS_LEAGUE . "','1'+RAND()*'3');";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `game_stage_id`='6'
                ORDER BY `game_id` ASC";
        $game_sql = f_igosja_mysqli_query($sql);

        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        $count_game = $game_array[0]['count'];

        if (0 != $count_game)
        {
            $sql = "UPDATE `leagueparticipant`
                    SET `leagueparticipant_out`='6'
                    WHERE `leagueparticipant_team_id` IN
                    (
                        SELECT `league_team_id`
                        FROM `league`
                        WHERE `league_season_id`='$igosja_season_id'
                        AND `league_place`>='3'
                    )";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `shedule_id`
                    FROM `shedule`
                    WHERE `shedule_date`>CURDATE()
                    AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
                    ORDER BY `shedule_date` ASC
                    LIMIT 2";
            $shedule_sql = f_igosja_mysqli_query($sql);

            $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

            $shedule_1 = $shedule_array[0]['shedule_id'];
            $shedule_2 = $shedule_array[1]['shedule_id'];

            $sql = "SELECT `leagueparticipant_team_id`
                    FROM `leagueparticipant`
                    WHERE `leagueparticipant_out`='0'
                    ORDER BY RAND()";
            $team_sql = f_igosja_mysqli_query($sql);

            $count_team = $team_sql->num_rows;
            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            for ($j=0; $j<$count_team; $j=$j+2)
            {
                $team_1 = $team_array[$j]['leagueparticipant_team_id'];
                $team_2 = $team_array[$j+1]['leagueparticipant_team_id'];

                $sql = "INSERT INTO `game`
                        SET `game_guest_team_id`='$team_2',
                            `game_home_team_id`='$team_1',
                            `game_referee_id`='1',
                            `game_stadium_id`='$team_1',
                            `game_stage_id`='46',
                            `game_shedule_id`='$shedule_1',
                            `game_temperature`='15'+RAND()*'15',
                            `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                            `game_weather_id`='1'+RAND()*'3'";
                f_igosja_mysqli_query($sql);

                $game_id = $mysqli->insert_id;

                $sql = "INSERT INTO `game`
                        SET `game_first_game_id`='$game_id',
                            `game_guest_team_id`='$team_1',
                            `game_home_team_id`='$team_2',
                            `game_referee_id`='1',
                            `game_stadium_id`='$team_2',
                            `game_stage_id`='46',
                            `game_shedule_id`='$shedule_2',
                            `game_temperature`='15'+RAND()*'15',
                            `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                            `game_weather_id`='1'+RAND()*'3'";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}