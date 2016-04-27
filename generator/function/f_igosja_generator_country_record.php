<?php

function f_igosja_generator_country_record()
//Рекорды сборных
{
    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_country_id`,
                   `game_home_score`,
                   `game_home_country_id`,
                   `game_visitor`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND `game_guest_team_id`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $visitor        = $game_array[$i]['game_visitor'];
        $total_score    = $game_array[$i]['game_home_score'] + $game_array[$i]['game_guest_score'];

        for ($k=0; $k<HOME_GUEST_LOOP; $k++)
        {
            if (0 == $k)
            {
                $country    = 'home';
                $opponent   = 'guest';
            }
            else
            {
                $country    = 'guest';
                $opponent   = 'home';
            }

            $country_id     = $game_array[$i]['game_' . $country . '_country_id'];
            $score_1        = $game_array[$i]['game_' . $country . '_score'];
            $score_2        = $game_array[$i]['game_' . $opponent . '_score'];

            $sql = "SELECT `recordcountry_value`
                    FROM `recordcountry`
                    WHERE `recordcountry_country_id`='$country_id'
                    AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordcountry`
                        SET `recordcountry_country_id`='$country_id',
                            `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "',
                            `recordcountry_value`='$visitor',
                            `recordcountry_game_id`='$game_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordcountry_value'];

                if ($visitor > $record_value)
                {
                    $sql = "UPDATE `recordcountry`
                            SET `recordcountry_value`='$visitor',
                                `recordcountry_game_id`='$game_id'
                            WHERE `recordcountry_country_id`='$country_id'
                            AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'";
                    f_igosja_mysqli_query($sql);
                }
            }

            $sql = "SELECT `recordcountry_value`
                    FROM `recordcountry`
                    WHERE `recordcountry_country_id`='$country_id'
                    AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordcountry`
                        SET `recordcountry_country_id`='$country_id',
                            `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "',
                            `recordcountry_value`='$visitor',
                            `recordcountry_game_id`='$game_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordcountry_value'];

                if ($visitor < $record_value ||
                    0 == $record_value)
                {
                    $sql = "UPDATE `recordcountry`
                            SET `recordcountry_value`='$visitor',
                                `recordcountry_game_id`='$game_id'
                            WHERE `recordcountry_country_id`='$country_id'
                            AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'";
                    f_igosja_mysqli_query($sql);
                }
            }

            $sql = "SELECT `recordcountry_value`
                    FROM `recordcountry`
                    WHERE `recordcountry_country_id`='$country_id'
                    AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordcountry`
                        SET `recordcountry_country_id`='$country_id',
                            `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "',
                            `recordcountry_value`='$total_score',
                            `recordcountry_game_id`='$game_id'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordcountry_value'];

                if ($total_score > $record_value)
                {
                    $sql = "UPDATE `recordcountry`
                            SET `recordcountry_value`='$total_score',
                                `recordcountry_game_id`='$game_id'
                            WHERE `recordcountry_country_id`='$country_id'
                            AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'";
                    f_igosja_mysqli_query($sql);
                }
            }

            if ($score_1 > $score_2)
            {
                $score = $score_1 - $score_2;

                $sql = "SELECT `recordcountry_value`
                        FROM `recordcountry`
                        WHERE `recordcountry_country_id`='$country_id'
                        AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'
                        LIMIT 1";
                $record_sql = f_igosja_mysqli_query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordcountry`
                            SET `recordcountry_country_id`='$country_id',
                                `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_WIN . "',
                                `recordcountry_value`='$score',
                                `recordcountry_game_id`='$game_id'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                    $record_value = $record_array[0]['recordcountry_value'];

                    if ($score > $record_value)
                    {
                        $sql = "UPDATE `recordcountry`
                                SET `recordcountry_value`='$score',
                                    `recordcountry_game_id`='$game_id'
                                WHERE `recordcountry_country_id`='$country_id'
                                AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
            elseif ($score_1 < $score_2)
            {
                $score = $score_2 - $score_1;

                $sql = "SELECT `recordcountry_value`
                        FROM `recordcountry`
                        WHERE `recordcountry_country_id`='$country_id'
                        AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'
                        LIMIT 1";
                $record_sql = f_igosja_mysqli_query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordcountry`
                            SET `recordcountry_country_id`='$country_id',
                                `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "',
                                `recordcountry_value`='$score',
                                `recordcountry_game_id`='$game_id'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                    $record_value = $record_array[0]['recordcountry_value'];

                    if ($score > $record_value)
                    {
                        $sql = "UPDATE `recordcountry`
                                SET `recordcountry_value`='$score',
                                    `recordcountry_game_id`='$game_id'
                                WHERE `recordcountry_country_id`='$country_id'
                                AND `recordcountry_recordcountrytype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `lineup_country_id`
            FROM `lineup`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            GROUP BY `lineup_country_id`
            ORDER BY `lineup_country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_country; $i++)
    {
        $country_id = $country_array[$i]['lineup_country_id'];

        $sql = "SELECT `lineup_goal`,
                       `lineup_player_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `lineup_country_id`='$country_id'
                ORDER BY `lineup_goal` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['lineup_player_id'];
        $goal       = $player_array[0]['lineup_goal'];

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_ONE_GAME_SCORE . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_player_id`='$player_id',
                        `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_ONE_GAME_SCORE . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_value`='$goal'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordcountry_value'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_player_id`='$player_id',
                            `recordcountry_value`='$goal'
                        WHERE `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_ONE_GAME_SCORE . "'
                        AND `recordcountry_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_goal`) AS `goal`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_country_id`='$country_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `goal` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $goal       = $player_array[0]['goal'];

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_SCORER . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_player_id`='$player_id',
                        `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_SCORER . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_value`='$goal'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordcountry_value'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_player_id`='$player_id',
                            `recordcountry_value`='$goal'
                        WHERE `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_SCORER . "'
                        AND `recordcountry_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_game`) AS `game`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_country_id`='$country_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `game` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $game       = $player_array[0]['game'];

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_GAMES . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_player_id`='$player_id',
                        `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_GAMES . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_value`='$game'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordcountry_value'];

            if ($game > $record_value)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_player_id`='$player_id',
                            `recordcountry_value`='$game'
                        WHERE `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_GAMES . "'
                        AND `recordcountry_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_pass_scoring`) AS `pass`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_country_id`='$country_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `pass` DESC
                LIMIT 1";
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $pass       = $player_array[0]['pass'];

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_ASSISTANT . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_player_id`='$player_id',
                        `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_ASSISTANT . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_value`='$pass'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordcountry_value'];

            if ($pass > $record_value)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_player_id`='$player_id',
                            `recordcountry_value`='$pass'
                        WHERE `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_MOST_ASSISTANT . "'
                        AND `recordcountry_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}

