<?php

function f_igosja_generator_game_result()
//Генерируем результат матча
{
    $koef_1 = 100000;
    $koef_2 = 100000;
    $koef_3 = 100000;
    $koef_4 = 100000;
    $koef_5 = 100000;

    $sql = "SELECT `game_field_bonus`,
                   `game_id`,
                   `game_guest_country_id`,
                   `game_guest_team_id`,
                   `game_home_country_id`,
                   `game_home_team_id`,
                   `game_weather_id`,
                   `referee_rigor`,
                   `stadium_length`,
                   `stadium_width`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `referee`
            ON `game_referee_id`=`referee_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $referee_rigor  = $game_array[$i]['referee_rigor'];
        $weather_id     = $game_array[$i]['game_weather_id'];
        $stadium_length = $game_array[$i]['stadium_length'];
        $stadium_width  = $game_array[$i]['stadium_width'];

        $home_team_power        = 0;
        $home_gk                = 0;
        $home_defence_left      = 0;
        $home_defence_center    = 0;
        $home_defence_right     = 0;
        $home_halfback_left     = 0;
        $home_halfback_center   = 0;
        $home_halfback_right    = 0;
        $home_forward_left      = 0;
        $home_forward_center    = 0;
        $home_forward_right     = 0;
        $guest_team_power       = 0;
        $guest_gk               = 0;
        $guest_defence_left     = 0;
        $guest_defence_center   = 0;
        $guest_defence_right    = 0;
        $guest_halfback_left    = 0;
        $guest_halfback_center  = 0;
        $guest_halfback_right   = 0;
        $guest_forward_left     = 0;
        $guest_forward_center   = 0;
        $guest_forward_right    = 0;

        for ($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $team           = 'home';
                $team_sql       = 'game_home_team_id';
                $country_sql    = 'game_home_country_id';
                $field_bonus    = 0;
            }
            else
            {
                $team           = 'guest';
                $team_sql       = 'game_guest_team_id';
                $country_sql    = 'game_guest_country_id';
                $field_bonus    = $game_array[$i]['game_field_bonus'];
            }

            $team_id    = $game_array[$i][$team_sql];
            $country_id = $game_array[$i][$country_sql];
            $teamwork   = 0;

            if (0 != $team_id)
            {
                $team_country_lineup_sql        = "`lineup_team_id`='$team_id'";
                $team_country_lineupmain_sql    = "`lineupmain_team_id`='$team_id'";
            }
            else
            {
                $team_country_lineup_sql        = "`lineup_country_id`='$country_id'";
                $team_country_lineupmain_sql    = "`lineupmain_country_id`='$country_id'";
            }

            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND $team_country_lineup_sql
                    AND `lineup_position_id`<='25'
                    ORDER BY `lineup_position_id` ASC";
            $lineup_sql = f_igosja_mysqli_query($sql);

            $count_lineup = $lineup_sql->num_rows;
            $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_lineup; $k++)
            {
                $num            = $k + 1;
                $lineup_player  = 'lineup_' . $num;
                $$lineup_player = $lineup_array[$k]['lineup_player_id'];
            }

            for ($k=0; $k<55; $k++)
            {
                if     ($k < 10) { $first = $lineup_1; }
                elseif ($k < 19) { $first = $lineup_2; }
                elseif ($k < 27) { $first = $lineup_3; }
                elseif ($k < 34) { $first = $lineup_4; }
                elseif ($k < 40) { $first = $lineup_5; }
                elseif ($k < 45) { $first = $lineup_6; }
                elseif ($k < 49) { $first = $lineup_7; }
                elseif ($k < 52) { $first = $lineup_8; }
                elseif ($k < 54) { $first = $lineup_9; }
                elseif ($k < 55) { $first = $lineup_10; }
                else             { $first = 0; }

                if     (in_array($k, array(0)))                                     { $second = $lineup_2; }
                elseif (in_array($k, array(1, 10)))                                 { $second = $lineup_3; }
                elseif (in_array($k, array(2, 11, 19)))                             { $second = $lineup_4; }
                elseif (in_array($k, array(3, 12, 20, 27)))                         { $second = $lineup_5; }
                elseif (in_array($k, array(4, 13, 21, 28, 34)))                     { $second = $lineup_6; }
                elseif (in_array($k, array(5, 14, 22, 29, 35, 40)))                 { $second = $lineup_7; }
                elseif (in_array($k, array(6, 15, 23, 30, 36, 41, 45)))             { $second = $lineup_8; }
                elseif (in_array($k, array(7, 16, 24, 31, 37, 42, 46, 49)))         { $second = $lineup_9; }
                elseif (in_array($k, array(8, 17, 25, 32, 38, 43, 47, 50, 52)))     { $second = $lineup_10; }
                elseif (in_array($k, array(9, 18, 26, 33, 39, 44, 48, 51, 53, 54))) { $second = $lineup_11; }
                else                                                                { $second = 0; }

                $sql = "SELECT `teamwork_id`,
                               `teamwork_value`
                        FROM `teamwork`
                        WHERE (`teamwork_first_id`='$first'
                        AND `teamwork_second_id`='$second')
                        OR (`teamwork_first_id`='$second'
                        AND `teamwork_second_id`='$first')
                        LIMIT 1";
                $teamwork_sql = f_igosja_mysqli_query($sql);

                $count_teamwork = $teamwork_sql->num_rows;

                if (0 != $count_teamwork)
                {
                    $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                    $teamwork_id    = $teamwork_array[0]['teamwork_id'];
                    $teamwork_value = $teamwork_array[0]['teamwork_value'];

                    $teamwork = $teamwork + $teamwork_value;

                    if (0 != $first && 0 != $second)
                    {
                        $sql = "UPDATE `teamwork`
                                SET `teamwork_value`=`teamwork_value`+'3'
                                WHERE `teamwork_id`='$teamwork_id'
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }
                else
                {
                    if (0 != $first && 0 != $second)
                    {
                        $sql = "INSERT INTO `teamwork`
                                SET `teamwork_first_id`='$first',
                                    `teamwork_second_id`='$second',
                                    `teamwork_value`='3'";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }

            $teamwork = $teamwork / 55;

            $sql = "SELECT `lineupmain_gamemood_id`,
                           `lineupmain_gamestyle_id`
                    FROM `lineupmain`
                    WHERE $team_country_lineupmain_sql
                    AND `lineupmain_game_id`='$game_id'
                    LIMIT 1";
            $lineupmain_sql = f_igosja_mysqli_query($sql);

            $lineupmain_array = $lineupmain_sql->fetch_all(MYSQLI_ASSOC);

            $gamemood_id        = $team . '_gamemood_id';
            $$gamemood_id       = $lineupmain_array[0]['lineupmain_gamemood_id'];
            $team_koef_1        = $team . '_koef_1';
            $team_koef_3        = $team . '_koef_3';
            $$team_koef_1       = $koef_1 * ( 8 - $$gamemood_id + 6 ) / 10;
            $$team_koef_3       = $koef_3 * ( $$gamemood_id + 6 ) / 10;
            $gamestyle_id       = $team . '_gamestyle_id';
            $$gamestyle_id      = $lineupmain_array[0]['lineupmain_gamestyle_id'];
            $gamestyle          = $team . '_gamestyle';
            $$gamestyle         = $$gamestyle_id * 0.05 + 0.75;
            $team_power         = $team . '_team_power';
            $gk                 = $team . '_gk';
            $defence_left       = $team . '_defence_left';
            $defence_center     = $team . '_defence_center';
            $defence_right      = $team . '_defence_right';
            $halfback_left      = $team . '_halfback_left';
            $halfback_center    = $team . '_halfback_center';
            $halfback_right     = $team . '_halfback_right';
            $forward_left       = $team . '_forward_left';
            $forward_center     = $team . '_forward_center';
            $forward_right      = $team . '_forward_right';

            $sql = "SELECT `lineup_auto`,
                           `lineup_player_id`,
                           `lineup_position_id`,
                           `player_power`
                    FROM `lineup`
                    LEFT JOIN
                    (
                        SELECT `playerattribute_player_id`,
                               SUM(`playerattribute_value`) AS `player_power`
                        FROM `playerattribute`
                        GROUP BY `playerattribute_player_id`
                        ORDER BY `playerattribute_player_id` ASC
                    ) AS `t1`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND $team_country_lineup_sql
                    AND `lineup_position_id`<='25'
                    ORDER BY `lineup_position_id` ASC";
            $lineup_sql = f_igosja_mysqli_query($sql);

            $count_lineup = $lineup_sql->num_rows;
            $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_lineup; $k++)
            {
                $player_id      = $lineup_array[$k]['lineup_player_id'];
                $player_power   = $lineup_array[$k]['player_power'];
                $position_id    = $lineup_array[$k]['lineup_position_id'];
                $auto           = $lineup_array[$k]['lineup_auto'];

                $sql = "SELECT `playerposition_value`
                        FROM `playerposition`
                        WHERE `playerposition_player_id`='$player_id'
                        AND `playerposition_position_id`='$position_id'
                        LIMIT 1";
                $playerposition_sql = f_igosja_mysqli_query($sql);

                $count_playerposition = $playerposition_sql->num_rows;

                if (0 == $count_playerposition)
                {
                    $power_koeff = 50;
                }
                else
                {
                    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

                    $power_koeff = $playerposition_array[0]['playerposition_value'];
                    $power_koeff = (100 - $power_koeff) / 2 + $power_koeff;
                }

                $player_power           = $player_power - $player_power * $field_bonus * 5 / 100;
                $player_power           = $player_power * $power_koeff / 100;
                $player_power           = $player_power + ($weather_id - 1) * 35;
                $player_power           = $player_power + 110 - $stadium_length + 75 - $stadium_width;
                $player_power           = $player_power + $player_power * $teamwork / 4 / 100;
                $$team_power            = $$team_power + $player_power;
                $player_power_main_3    = (2 - $$gamestyle) * $player_power / 3;
                $player_power_extra_3   = ($player_power - $player_power_main_3) / 2;
                $player_power_main_4    = (2 - $$gamestyle) * $player_power / 4;
                $player_power_extra_4   = ($player_power - $player_power_main_4) / 3;
                $player_power_main_5    = (2 - $$gamestyle) * $player_power / 5;
                $player_power_extra_5   = ($player_power - $player_power_main_5) / 4;

                if (1 == $position_id)
                {
                    $$gk = $$gk + $player_power;
                }
                elseif (2 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (3 == $position_id)
                {
                    $$defence_center  = $$defence_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (in_array($position_id, array(4, 5, 6)))
                {
                    $$defence_left    = $$defence_left    + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
                elseif (7 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (8 == $position_id)
                {
                    $$defence_right   = $$defence_right   + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (in_array($position_id, array(9, 10, 11)))
                {
                    $$defence_center  = $$defence_center  + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
                elseif (12 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (13 == $position_id)
                {
                    $$defence_right   = $$defence_right   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
                elseif (in_array($position_id, array(14, 15, 16)))
                {
                    $$defence_center  = $$defence_center  + $player_power_extra_5   - $player_power_extra_5 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power_extra_5   - $player_power_extra_5 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_main_5    - $player_power_main_5 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_extra_5   - $player_power_extra_5 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power_extra_5   - $player_power_extra_5 * $auto / 4;
                }
                elseif (17 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
                elseif (18 == $position_id)
                {
                    $$halfback_right  = $$halfback_right  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (in_array($position_id, array(19, 20, 21)))
                {
                    $$halfback_left   = $$halfback_left   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
                elseif (22 == $position_id)
                {
                    $$halfback_left   = $$halfback_left   + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power_main_3    - $player_power_main_3 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power_extra_3   - $player_power_extra_3 * $auto / 4;
                }
                elseif (in_array($position_id, array(23, 24, 25)))
                {
                    $$halfback_center = $$halfback_center + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power_main_4    - $player_power_main_4 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power_extra_4   - $player_power_extra_4 * $auto / 4;
                }
            }
        }

        $home_score     = $guest_score      = 0;
        $home_on_target = $guest_on_target  = 0;
        $home_shot      = $guest_shot       = 0;
        $home_pass      = $guest_pass       = 0;
        $home_corner    = $guest_corner     = 0;
        $home_offside   = $guest_offside    = 0;
        $home_foul      = $guest_foul       = 0;
        $home_penalty   = $guest_penalty    = 0;
        $home_yellow    = $guest_yellow     = 0;
        $home_red       = $guest_red        = 0;

        for ($j=0; $j<MINUTES_IN_GAME; $j++)
        {
            for ($k=0; $k<HOME_GUEST_LOOP; $k++)
            {
                if (0 == $k)
                {
                    $team_1 = 'home';
                    $team_2 = 'guest';
                }
                else
                {
                    $team_1 = 'guest';
                    $team_2 = 'home';
                }

                $defence_direction = rand(1, 3);

                if (1 == $defence_direction)
                {
                    $defence_1      = $team_1 . '_defence_left';
                    $forward_2      = $team_2 . '_forward_right';
                }
                elseif (2 == $defence_direction)
                {
                    $defence_1 = $team_1 . '_defence_center';
                    $forward_2 = $team_2 . '_forward_center';
                }
                else
                {
                    $defence_1 = $team_1 . '_defence_right';
                    $forward_2 = $team_2 . '_forward_left';
                }

                $koef_1_1 = $team_1 . '_koef_1';
                $koef_3_1 = $team_1 . '_koef_3';
                $koef_1_2 = $team_2 . '_koef_1';
                $koef_3_2 = $team_2 . '_koef_3';

                $defence_1 = $$defence_1;
                $forward_2 = $$forward_2;

                if (rand(0, $defence_1 + $$koef_1_1) > rand(0, $forward_2 + $$koef_3_2))
                {
                    $halfback_direction = rand(1, 3);

                    if (1 == $halfback_direction)
                    {
                        $halfback_1 = $team_1 . '_halfback_left';
                        $halfback_2 = $team_2 . '_halfback_right';
                    }
                    elseif (2 == $halfback_direction)
                    {
                        $halfback_1 = $team_1 . '_halfback_center';
                        $halfback_2 = $team_2 . '_halfback_center';
                    }
                    else
                    {
                        $halfback_1 = $team_1 . '_halfback_right';
                        $halfback_2 = $team_2 . '_halfback_left';
                    }

                    $halfback_1 = $$halfback_1;
                    $halfback_2 = $$halfback_2;

                    if (rand(0, $halfback_1 + $koef_2) > rand(0, $halfback_2 + $koef_2))
                    {
                        $forward_direction = rand(1, 3);

                        if (1 == $forward_direction)
                        {
                            $forward_1 = $team_1 . '_forward_left';
                            $defence_2 = $team_2 . '_defence_right';
                        }
                        elseif (2 == $forward_direction)
                        {
                            $forward_1 = $team_1 . '_forward_center';
                            $defence_2 = $team_2 . '_defence_center';
                        }
                        else
                        {
                            $forward_1 = $team_1 . '_forward_right';
                            $defence_2 = $team_2 . '_defence_left';
                        }

                        $forward_1 = $$forward_1;
                        $defence_2 = $$defence_2;

                        if (rand(0, $forward_1 + $koef_3_1) > rand(0, $defence_2 + $koef_1_2))
                        {
                            $shot = $team_1 . '_shot';
                            $$shot++;

                            $player_1 = $team_1 . '_team_power';
                            $player_2 = $team_2 . '_team_power';

                            if (rand(0, $$player_1 / 11 + $koef_4) > rand(0, $$player_2 / 11 + $koef_4))
                            {
                                $on_target = $team_1 . '_on_target';
                                $$on_target++;

                                $player_1 = $team_1 . '_team_power';
                                $player_2 = $team_2 . '_gk';

                                if (rand(0, $$player_1 / 11 + $koef_5 / 2) > rand(0, $$player_2 + $koef_5))
                                {
                                    $score = $team_1 . '_score';
                                    $$score++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $home_moment        = round(($home_on_target + $home_score) / 2) - rand(0, 1);
        $guest_moment       = round(($guest_on_target + $guest_score) / 2) - rand(0, 1);
        $home_pass          = $home_pass + rand(60, 80);
        $guest_pass         = $guest_pass + rand(60, 80);
        $home_corner        = $home_corner  + rand(3, 8);
        $guest_corner       = $guest_corner + rand(3, 8);
        $home_offside       = $home_offside  + rand(1, 4);
        $guest_offside      = $guest_offside + rand(1, 4);
        $home_foul          = $home_foul  + rand(8, 16 + $referee_rigor);
        $guest_foul         = $guest_foul + rand(8, 16 + $referee_rigor);
        $home_penalty       = $home_penalty  + floor(rand(0, 6 + $referee_rigor) / 7);
        $guest_penalty      = $guest_penalty + floor(rand(0, 6 + $referee_rigor) / 7);
        $home_shot          = $home_shot + $home_penalty;
        $guest_shot         = $guest_shot + $guest_penalty;
        $home_on_target     = $home_on_target + $home_penalty;
        $guest_on_target    = $guest_on_target + $guest_penalty;
        $home_yellow        = $home_yellow  + rand(0, 2 + $referee_rigor);
        $guest_yellow       = $guest_yellow + rand(0, 2 + $referee_rigor);
        $home_red           = $home_red  + floor(rand(0, 7 + $referee_rigor) / 8);
        $guest_red          = $guest_red + floor(rand(0, 7 + $referee_rigor) / 8);
        $home_possesion     = round($home_team_power / ( $home_team_power + $guest_team_power ) * 100 + rand(-10, 10));
        $guest_possesion    = 100 - $home_possesion;

        $sql = "UPDATE `game`
                SET `game_guest_corner`='$guest_corner',
                    `game_guest_foul`='$guest_foul',
                    `game_guest_moment`='$guest_moment',
                    `game_guest_offside`='$guest_offside',
                    `game_guest_ontarget`='$guest_on_target',
                    `game_guest_pass`='$guest_pass',
                    `game_guest_penalty`='$guest_penalty',
                    `game_guest_possession`='$guest_possesion',
                    `game_guest_red`='$guest_red',
                    `game_guest_score`='$guest_score'+'$guest_penalty',
                    `game_guest_shot`='$guest_shot',
                    `game_guest_yellow`='$guest_yellow',
                    `game_home_corner`='$home_corner',
                    `game_home_foul`='$home_foul',
                    `game_home_moment`='$home_moment',
                    `game_home_offside`='$home_offside',
                    `game_home_ontarget`='$home_on_target',
                    `game_home_pass`='$home_pass',
                    `game_home_penalty`='$home_penalty',
                    `game_home_possession`='$home_possesion',
                    `game_home_red`='$home_red',
                    `game_home_score`='$home_score'+'$home_penalty',
                    `game_home_shot`='$home_shot',
                    `game_home_yellow`='$home_yellow',
                    `game_referee_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND()
                WHERE `game_id`='$game_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}