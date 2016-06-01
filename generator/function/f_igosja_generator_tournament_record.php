<?php

function f_igosja_generator_tournament_record()
//Рекорды турниров
{
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            GROUP BY `game_tournament_id`
            ORDER BY `game_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;

    $tournament_array = $tournament_sql->fetch_all(1);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['game_tournament_id'];

        $sql = "SELECT `game_id`,
                       `game_visitor`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `game_tournament_id`='$tournament_id'
                AND `shedule_date`=CURDATE()
                AND `game_played`='0'
                ORDER BY `game_visitor` DESC
                LIMIT 1";
        $game_sql = f_igosja_mysqli_query($sql);

        $count_game = $game_sql->num_rows;

        if (0 != $count_game)
        {
            $game_array = $game_sql->fetch_all(1);

            $game_id = $game_array[0]['game_id'];
            $visitor = $game_array[0]['game_visitor'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$visitor'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($visitor > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_game_id`='$game_id',
                                `recordtournament_value_1`='$visitor'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `statisticteam_team_id`,
                       `statisticteam_season_id`,
                       ROUND(`statisticteam_visitor`/`statisticteam_game`,0) AS `visitor`
                FROM `statisticteam`
                WHERE `statisticteam_tournament_id`='$tournament_id'
                GROUP BY `statisticteam_season_id`
                ORDER BY `visitor` DESC
                LIMIT 1";
        $visitor_sql = f_igosja_mysqli_query($sql);

        $count_visitor = $visitor_sql->num_rows;

        if (0 != $count_visitor)
        {
            $visitor_array = $visitor_sql->fetch_all(1);

            $team_id                = $visitor_array[0]['statisticteam_team_id'];
            $statistic_season_id    = $visitor_array[0]['statisticteam_season_id'];
            $visitor                = $visitor_array[0]['visitor'];

            $sql = "SELECT `recordtournament_season_id`,
                           `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "',
                            `recordtournament_season_id`='$statistic_season_id',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$visitor'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array  = $record_sql->fetch_all(1);

                $record_value  = $record_array[0]['recordtournament_value_1'];
                $record_season = $record_array[0]['recordtournament_season_id'];

                if ($visitor > $record_value ||
                    $statistic_season_id == $record_season)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$visitor'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `statisticcountry_country_id`,
                       `statisticcountry_season_id`,
                       ROUND(`statisticcountry_visitor`/`statisticcountry_game`,0) AS `visitor`
                FROM `statisticcountry`
                WHERE `statisticcountry_tournament_id`='$tournament_id'
                GROUP BY `statisticcountry_season_id`
                ORDER BY `visitor` DESC
                LIMIT 1";
        $visitor_sql = f_igosja_mysqli_query($sql);

        $count_visitor = $visitor_sql->num_rows;

        if (0 != $count_visitor)
        {
            $visitor_array = $visitor_sql->fetch_all(1);

            $country_id                = $visitor_array[0]['statisticcountry_country_id'];
            $statistic_season_id    = $visitor_array[0]['statisticcountry_season_id'];
            $visitor                = $visitor_array[0]['visitor'];

            $sql = "SELECT `recordtournament_season_id`,
                           `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "',
                            `recordtournament_season_id`='$statistic_season_id',
                            `recordtournament_team_id`='$country_id',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$visitor'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array  = $record_sql->fetch_all(1);

                $record_value  = $record_array[0]['recordtournament_value_1'];
                $record_season = $record_array[0]['recordtournament_season_id'];

                if ($visitor > $record_value ||
                    $statistic_season_id == $record_season)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$country_id',
                                `recordtournament_value_1`='$visitor'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_AVERAGE_ATTENDANCE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `game_id`,
                       `game_home_score`+`game_guest_score` AS `game_score`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `game_tournament_id`='$tournament_id'
                AND `shedule_date`=CURDATE()
                AND `game_played`='0'
                ORDER BY `game_score` DESC
                LIMIT 1";
        $game_sql = f_igosja_mysqli_query($sql);

        $count_game = $game_sql->num_rows;

        if (0 != $count_game)
        {
            $game_array = $game_sql->fetch_all(1);

            $game_id = $game_array[0]['game_id'];
            $score   = $game_array[0]['game_score'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$score'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($score > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_game_id`='$game_id',
                                `recordtournament_value_1`='$score'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `game_id`,
                       ABS(`game_home_score`-`game_guest_score`) AS `game_score`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `game_tournament_id`='$tournament_id'
                AND `shedule_date`=CURDATE()
                AND `game_played`='0'
                ORDER BY `game_score` DESC
                LIMIT 1";
        $game_sql = f_igosja_mysqli_query($sql);

        $count_game = $game_sql->num_rows;

        if (0 != $count_game)
        {
            $game_array = $game_sql->fetch_all(1);

            $game_id = $game_array[0]['game_id'];
            $score   = $game_array[0]['game_score'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$score'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($score > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_game_id`='$game_id',
                                `recordtournament_value_1`='$score'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `lineup_goal`,
                       `lineup_player_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `game_tournament_id`='$tournament_id'
                ORDER BY `lineup_goal` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $count_player)
        {
            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['lineup_player_id'];
            $goal       = $player_array[0]['lineup_goal'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$goal'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($goal > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$goal'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `lineup_mark`,
                       `lineup_player_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `game_tournament_id`='$tournament_id'
                ORDER BY `lineup_mark` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $count_player)
        {
            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['lineup_player_id'];
            $mark       = $player_array[0]['lineup_mark'] * 10; //Нужно целое число

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$mark'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($mark > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$mark'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT SUM(`statisticplayer_goal`) AS `goal`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `goal` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $count_player)
        {
            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['statisticplayer_player_id'];
            $goal       = $player_array[0]['goal'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$goal'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);
                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($goal > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$goal'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT SUM(`statisticplayer_pass_scoring`) AS `pass`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `pass` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $count_player)
        {
            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['statisticplayer_player_id'];
            $pass       = $player_array[0]['pass'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$pass'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($pass > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$pass'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT SUM(`statisticplayer_best`) AS `best`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `best` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $count_player)
        {
            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['statisticplayer_player_id'];
            $best       = $player_array[0]['best'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$best'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($best > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$best'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `standing_point`,
                       `standing_team_id`
                FROM `standing`
                WHERE `standing_season_id`='$igosja_season_id'
                AND `standing_tournament_id`='$tournament_id'
                ORDER BY `standing_point` DESC
                LIMIT 1";
        $point_sql = f_igosja_mysqli_query($sql);

        $count_point = $point_sql->num_rows;

        if (0 != $count_point)
        {
            $point_array = $point_sql->fetch_all(1);

            $team_id = $point_array[0]['standing_team_id'];
            $point   = $point_array[0]['standing_point'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$team_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$point',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);
                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($point > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$point',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `worldcup_point`,
                       `worldcup_country_id`
                FROM `worldcup`
                WHERE `worldcup_season_id`='$igosja_season_id'
                AND `worldcup_tournament_id`='$tournament_id'
                ORDER BY `worldcup_point` DESC
                LIMIT 1";
        $point_sql = f_igosja_mysqli_query($sql);

        $count_point = $point_sql->num_rows;

        if (0 != $count_point)
        {
            $point_array = $point_sql->fetch_all(1);

            $country_id = $point_array[0]['worldcup_country_id'];
            $point      = $point_array[0]['worldcup_point'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$country_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$point',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);
                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($point > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$country_id',
                                `recordtournament_value_1`='$point',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `standing_score`,
                       `standing_team_id`
                FROM `standing`
                WHERE `standing_season_id`='$igosja_season_id'
                AND `standing_tournament_id`='$tournament_id'
                ORDER BY `standing_score` DESC
                LIMIT 1";
        $score_sql = f_igosja_mysqli_query($sql);

        $count_score = $score_sql->num_rows;

        if (0 != $count_score)
        {
            $score_array = $score_sql->fetch_all(1);

            $team_id = $score_array[0]['standing_team_id'];
            $score   = $score_array[0]['standing_score'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$team_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$score',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);
                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($score > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$score',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `worldcup_score`,
                       `worldcup_country_id`
                FROM `worldcup`
                WHERE `worldcup_season_id`='$igosja_season_id'
                AND `worldcup_tournament_id`='$tournament_id'
                ORDER BY `worldcup_score` DESC
                LIMIT 1";
        $score_sql = f_igosja_mysqli_query($sql);

        $count_score = $score_sql->num_rows;

        if (0 != $count_score)
        {
            $score_array = $score_sql->fetch_all(1);

            $country_id = $score_array[0]['worldcup_country_id'];
            $score      = $score_array[0]['worldcup_score'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$country_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$score',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);
                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($score > $record_value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$country_id',
                                `recordtournament_value_1`='$score',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `statisticteam_red`,
                       `statisticteam_team_id`,
                       `statisticteam_yellow`
                FROM `statisticteam`
                WHERE `statisticteam_season_id`='$igosja_season_id'
                AND `statisticteam_tournament_id`='$tournament_id'
                ORDER BY `statisticteam_red` DESC, `statisticteam_yellow` DESC
                LIMIT 1";
        $discipline_sql = f_igosja_mysqli_query($sql);

        $count_discipline = $discipline_sql->num_rows;

        if (0 != $count_discipline)
        {
            $discipline_array = $discipline_sql->fetch_all(1);

            $team_id = $discipline_array[0]['statisticteam_team_id'];
            $red     = $discipline_array[0]['statisticteam_red'];
            $yellow  = $discipline_array[0]['statisticteam_yellow'];

            $sql = "SELECT `recordtournament_value_1`,
                           `recordtournament_value_2`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$team_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$red',
                            `recordtournament_value_2`='$yellow',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array   = $record_sql->fetch_all(1);
                $record_value_1 = $record_array[0]['recordtournament_value_1'];
                $record_value_2 = $record_array[0]['recordtournament_value_2'];

                if ($red > $record_value_1 ||
                    ($red == $record_value_1 &&
                     $yellow > $record_value_2))
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$red',
                                `recordtournament_value_2`='$yellow',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `statisticcountry_red`,
                       `statisticcountry_country_id`,
                       `statisticcountry_yellow`
                FROM `statisticcountry`
                WHERE `statisticcountry_season_id`='$igosja_season_id'
                AND `statisticcountry_tournament_id`='$tournament_id'
                ORDER BY `statisticcountry_red` DESC, `statisticcountry_yellow` DESC
                LIMIT 1";
        $discipline_sql = f_igosja_mysqli_query($sql);

        $count_discipline = $discipline_sql->num_rows;

        if (0 != $count_discipline)
        {
            $discipline_array = $discipline_sql->fetch_all(1);

            $country_id = $discipline_array[0]['statisticcountry_country_id'];
            $red        = $discipline_array[0]['statisticcountry_red'];
            $yellow     = $discipline_array[0]['statisticcountry_yellow'];

            $sql = "SELECT `recordtournament_value_1`,
                           `recordtournament_value_2`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_team_id`='$country_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$red',
                            `recordtournament_value_2`='$yellow',
                            `recordtournament_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array   = $record_sql->fetch_all(1);
                $record_value_1 = $record_array[0]['recordtournament_value_1'];
                $record_value_2 = $record_array[0]['recordtournament_value_2'];

                if ($red > $record_value_1 ||
                    ($red == $record_value_1 &&
                     $yellow > $record_value_2))
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$country_id',
                                `recordtournament_value_1`='$red',
                                `recordtournament_value_2`='$yellow',
                                `recordtournament_season_id`='$igosja_season_id'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_TEAM . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `statisticplayer_player_id`,
                       SUM(`statisticplayer_red`) AS `red`,
                       SUM(`statisticplayer_yellow`) AS `yellow`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `red` DESC, `yellow` DESC
                LIMIT 1";
        $discipline_sql = f_igosja_mysqli_query($sql);

        $count_discipline = $discipline_sql->num_rows;

        if (0 != $count_discipline)
        {
            $discipline_array = $discipline_sql->fetch_all(1);

            $player_id  = $discipline_array[0]['statisticplayer_player_id'];
            $red        = $discipline_array[0]['red'];
            $yellow     = $discipline_array[0]['yellow'];

            $sql = "SELECT `recordtournament_value_1`,
                           `recordtournament_value_2`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_PLAYER . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_PLAYER . "',
                            `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_value_1`='$red',
                            `recordtournament_value_2`='$yellow'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array   = $record_sql->fetch_all(1);
                $record_value_1 = $record_array[0]['recordtournament_value_1'];
                $record_value_2 = $record_array[0]['recordtournament_value_2'];

                if ($red > $record_value_1 ||
                    ($red == $record_value_1 &&
                     $yellow > $record_value_2))
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_player_id`='$player_id',
                                `recordtournament_value_1`='$red',
                                `recordtournament_value_2`='$yellow'
                            WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_DISCIPLINE_PLAYER . "'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}