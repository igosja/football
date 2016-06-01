<?php

function f_igosja_generator_lineup_check_and_fill()
//Проверяем составы и заполняем пустые/исправляем
{
    $sql = "SELECT `game_guest_country_id`,
                   `game_guest_team_id`,
                   `game_home_country_id`,
                   `game_home_team_id`,
                   `game_id`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];

        for ($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $team       = 'game_home_team_id';
                $country    = 'game_home_country_id';
            }
            else
            {
                $team       = 'game_guest_team_id';
                $country    = 'game_guest_country_id';
            }

            $team_id = $game_array[$i][$team];

            if (0 != $team_id)
            {
                for ($k=0; $k<18; $k++)
                {
                    $sql = "SELECT `lineup_id`,
                                   `lineup_player_id`,
                                   `lineup_position_id`
                            FROM `lineup`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$team_id'
                            LIMIT $k, 1";
                    $lineup_sql = f_igosja_mysqli_query($sql);

                    $count_lineup = $lineup_sql->num_rows;

                    if (0 == $count_lineup)
                    {
                        if (0 == $k) //Вратарская позиция, если вратаря в команде нет, будет стоять в воротах полевой
                        {
                            $order_sql = '`player_position_id`';
                        }
                        else
                        {
                            $order_sql = 1;
                        }

                        if      (0 == $k) {$position_id =  1; $role_id =  1;}
                        elseif  (1 == $k) {$position_id =  3; $role_id =  5;}
                        elseif  (2 == $k) {$position_id =  4; $role_id =  9;}
                        elseif  (3 == $k) {$position_id =  6; $role_id =  9;}
                        elseif  (4 == $k) {$position_id =  7; $role_id =  5;}
                        elseif  (5 == $k) {$position_id = 13; $role_id =  18;}
                        elseif  (6 == $k) {$position_id = 14; $role_id =  21;}
                        elseif  (7 == $k) {$position_id = 16; $role_id =  21;}
                        elseif  (8 == $k) {$position_id = 17; $role_id =  18;}
                        elseif  (9 == $k) {$position_id = 23; $role_id =  30;}
                        elseif (10 == $k) {$position_id = 25; $role_id =  30;}
                        elseif (11 == $k) {$position_id = 26; $role_id =  0;}
                        elseif (12 == $k) {$position_id = 27; $role_id =  0;}
                        elseif (13 == $k) {$position_id = 28; $role_id =  0;}
                        elseif (14 == $k) {$position_id = 29; $role_id =  0;}
                        elseif (15 == $k) {$position_id = 30; $role_id =  0;}
                        elseif (16 == $k) {$position_id = 31; $role_id =  0;}
                        else              {$position_id = 32; $role_id =  0;}

                        $sql = "SELECT `player_id`
                                FROM `player`
                                LEFT JOIN
                                (
                                    SELECT `disqualification_player_id`,
                                           `disqualification_red`,
                                           `disqualification_yellow`
                                    FROM `disqualification`
                                    WHERE `disqualification_tournament_id`='$tournament_id'
                                    GROUP BY `disqualification_player_id`
                                ) AS `t1`
                                ON `disqualification_player_id`=`player_id`
                                WHERE `player_team_id`='$team_id'
                                AND `player_rent_team_id`='0'
                                AND `player_id` NOT IN
                                (
                                    SELECT `lineup_player_id`
                                    FROM `lineup`
                                    WHERE `lineup_game_id`='$game_id'
                                    AND `lineup_team_id`='$team_id'
                                )
                                AND (`disqualification_red`='0'
                                OR `disqualification_red` IS NULL)
                                AND (`disqualification_yellow`<'2'
                                OR `disqualification_yellow` IS NULL)
                                ORDER BY $order_sql, `player_condition` DESC
                                LIMIT 1";
                        $player_sql = f_igosja_mysqli_query($sql);

                        $player_array = $player_sql->fetch_all(1);

                        $player_id = $player_array[0]['player_id'];

                        $sql = "INSERT INTO `lineup`
                                SET `lineup_auto`='1',
                                    `lineup_player_id`='$player_id',
                                    `lineup_position_id`='$position_id',
                                    `lineup_role_id`='$role_id',
                                    `lineup_game_id`='$game_id',
                                    `lineup_team_id`='$team_id'";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $lineup_array = $lineup_sql->fetch_all(1);

                        $lineup_id      = $lineup_array[0]['lineup_id'];
                        $player_id      = $lineup_array[0]['lineup_player_id'];
                        $position_id    = $lineup_array[0]['lineup_position_id'];

                        $sql = "SELECT COUNT(`lineup_id`) AS `count`
                                FROM `lineup`
                                WHERE `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$team_id'
                                AND `lineup_player_id`='$player_id'
                                AND `lineup_id`!='$lineup_id'";
                        $lineup_sql = f_igosja_mysqli_query($sql);

                        $lineup_array = $lineup_sql->fetch_all(1);

                        $count_lineup = $lineup_array[0]['count'];

                        $sql = "SELECT COUNT(`disqualification_id`) AS `count`
                                FROM `disqualification`
                                WHERE `disqualification_player_id`='$player_id'
                                AND (`disqualification_red`>'0'
                                OR `disqualification_yellow`>'1')
                                AND `disqualification_tournament_id`='$tournament_id'";
                        $disqualification_sql = f_igosja_mysqli_query($sql);

                        $disqualification_array = $disqualification_sql->fetch_all(1);

                        $count_disqualification = $disqualification_array[0]['count'];

                        if (0 != $count_lineup ||
                            0 != $count_disqualification)
                        {
                            if (0 == $k) //Вратарская позиция, если вратаря в команде нет, будет стоять в воротах полевой
                            {
                                $order_sql = '`player_position_id`';
                            }
                            else
                            {
                                $order_sql = 1;
                            }

                            $sql = "SELECT `player_id`
                                    FROM `player`
                                    LEFT JOIN
                                    (
                                        SELECT `disqualification_player_id`,
                                               `disqualification_red`,
                                               `disqualification_yellow`
                                        FROM `disqualification`
                                        WHERE `disqualification_tournament_id`='$tournament_id'
                                        GROUP BY `disqualification_player_id`
                                    ) AS `t1`
                                    ON `disqualification_player_id`=`player_id`
                                    WHERE `player_team_id`='$team_id'
                                    AND `player_rent_team_id`='0'
                                    AND `player_id` NOT IN
                                    (
                                        SELECT `lineup_player_id`
                                        FROM `lineup`
                                        WHERE `lineup_game_id`='$game_id'
                                        AND `lineup_team_id`='$team_id'
                                        AND `lineup_player_id`!='$player_id'
                                    )
                                    AND (`disqualification_red`='0'
                                    OR `disqualification_red` IS NULL)
                                    AND (`disqualification_yellow`<'2'
                                    OR `disqualification_yellow` IS NULL)
                                    ORDER BY $order_sql, `player_condition` DESC
                                    LIMIT 1";
                            $player_sql = f_igosja_mysqli_query($sql);

                            $player_array = $player_sql->fetch_all(1);

                            $player_id = $player_array[0]['player_id'];

                            $sql = "UPDATE `lineup`
                                    SET `lineup_player_id`='$player_id'
                                    WHERE `lineup_id`='$lineup_id'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }

                        if (0 == $position_id)
                        {
                            if      (0 == $k) {$position_id =  1; $role_id =  1;}
                            elseif  (1 == $k) {$position_id =  3; $role_id =  5;}
                            elseif  (2 == $k) {$position_id =  4; $role_id =  9;}
                            elseif  (3 == $k) {$position_id =  6; $role_id =  9;}
                            elseif  (4 == $k) {$position_id =  7; $role_id =  5;}
                            elseif  (5 == $k) {$position_id = 13; $role_id =  18;}
                            elseif  (6 == $k) {$position_id = 14; $role_id =  21;}
                            elseif  (7 == $k) {$position_id = 16; $role_id =  21;}
                            elseif  (8 == $k) {$position_id = 17; $role_id =  18;}
                            elseif  (9 == $k) {$position_id = 23; $role_id =  30;}
                            elseif (10 == $k) {$position_id = 25; $role_id =  30;}
                            elseif (11 == $k) {$position_id = 26; $role_id =  0;}
                            elseif (12 == $k) {$position_id = 27; $role_id =  0;}
                            elseif (13 == $k) {$position_id = 28; $role_id =  0;}
                            elseif (14 == $k) {$position_id = 29; $role_id =  0;}
                            elseif (15 == $k) {$position_id = 30; $role_id =  0;}
                            elseif (16 == $k) {$position_id = 31; $role_id =  0;}
                            else              {$position_id = 32; $role_id =  0;}

                            $sql = "UPDATE `lineup`
                                    SET `lineup_position_id`='$position_id',
                                        `lineup_role_id`='$role_id'
                                    WHERE `lineup_id`='$lineup_id'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }
                    }
                }
            }
            else
            {
                $country_id = $game_array[$i][$country];

                for ($k=0; $k<18; $k++)
                {
                    $sql = "SELECT `lineup_id`,
                                   `lineup_player_id`,
                                   `lineup_position_id`
                            FROM `lineup`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_country_id`='$country_id'
                            LIMIT $k, 1";
                    $lineup_sql = f_igosja_mysqli_query($sql);

                    $count_lineup = $lineup_sql->num_rows;

                    if (0 == $count_lineup)
                    {
                        if (0 == $k) //Вратарская позиция, если вратаря в команде нет, будет стоять в воротах полевой
                        {
                            $order_sql = '`player_position_id`';
                        }
                        else
                        {
                            $order_sql = 1;
                        }

                        if      (0 == $k) {$position_id =  1; $role_id =  1;}
                        elseif  (1 == $k) {$position_id =  3; $role_id =  5;}
                        elseif  (2 == $k) {$position_id =  4; $role_id =  9;}
                        elseif  (3 == $k) {$position_id =  6; $role_id =  9;}
                        elseif  (4 == $k) {$position_id =  7; $role_id =  5;}
                        elseif  (5 == $k) {$position_id = 13; $role_id =  18;}
                        elseif  (6 == $k) {$position_id = 14; $role_id =  21;}
                        elseif  (7 == $k) {$position_id = 16; $role_id =  21;}
                        elseif  (8 == $k) {$position_id = 17; $role_id =  18;}
                        elseif  (9 == $k) {$position_id = 23; $role_id =  30;}
                        elseif (10 == $k) {$position_id = 25; $role_id =  30;}
                        elseif (11 == $k) {$position_id = 26; $role_id =  0;}
                        elseif (12 == $k) {$position_id = 27; $role_id =  0;}
                        elseif (13 == $k) {$position_id = 28; $role_id =  0;}
                        elseif (14 == $k) {$position_id = 29; $role_id =  0;}
                        elseif (15 == $k) {$position_id = 30; $role_id =  0;}
                        elseif (16 == $k) {$position_id = 31; $role_id =  0;}
                        else              {$position_id = 32; $role_id =  0;}

                        $sql = "SELECT `player_id`
                                FROM `player`
                                LEFT JOIN
                                (
                                    SELECT `disqualification_player_id`,
                                           `disqualification_red`,
                                           `disqualification_yellow`
                                    FROM `disqualification`
                                    WHERE `disqualification_tournament_id`='$tournament_id'
                                    GROUP BY `disqualification_player_id`
                                ) AS `t1`
                                ON `disqualification_player_id`=`player_id`
                                WHERE `player_national_id`='$country_id'
                                AND `player_rent_team_id`='0'
                                AND `player_id` NOT IN
                                (
                                    SELECT `lineup_player_id`
                                    FROM `lineup`
                                    WHERE `lineup_game_id`='$game_id'
                                    AND `lineup_country_id`='$country_id'
                                )
                                AND (`disqualification_red`='0'
                                OR `disqualification_red` IS NULL)
                                AND (`disqualification_yellow`<'2'
                                OR `disqualification_yellow` IS NULL)
                                ORDER BY $order_sql, `player_condition` DESC
                                LIMIT 1";
                        $player_sql = f_igosja_mysqli_query($sql);

                        $player_array = $player_sql->fetch_all(1);

                        $player_id = $player_array[0]['player_id'];

                        $sql = "INSERT INTO `lineup`
                                SET `lineup_auto`='1',
                                    `lineup_player_id`='$player_id',
                                    `lineup_position_id`='$position_id',
                                    `lineup_role_id`='$role_id',
                                    `lineup_game_id`='$game_id',
                                    `lineup_country_id`='$country_id'";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $lineup_array = $lineup_sql->fetch_all(1);

                        $lineup_id      = $lineup_array[0]['lineup_id'];
                        $player_id      = $lineup_array[0]['lineup_player_id'];
                        $position_id    = $lineup_array[0]['lineup_position_id'];

                        $sql = "SELECT COUNT(`lineup_id`) AS `count`
                                FROM `lineup`
                                WHERE `lineup_game_id`='$game_id'
                                AND `lineup_country_id`='$country_id'
                                AND `lineup_player_id`='$player_id'
                                AND `lineup_id`!='$lineup_id'";
                        $lineup_sql = f_igosja_mysqli_query($sql);

                        $lineup_array = $lineup_sql->fetch_all(1);

                        $count_lineup = $lineup_array[0]['count'];

                        $sql = "SELECT COUNT(`disqualification_id`) AS `count`
                                FROM `disqualification`
                                WHERE `disqualification_player_id`='$player_id'
                                AND (`disqualification_red`>'0'
                                OR `disqualification_yellow`>'1')
                                AND `disqualification_tournament_id`='$tournament_id'";
                        $disqualification_sql = f_igosja_mysqli_query($sql);

                        $disqualification_array = $disqualification_sql->fetch_all(1);

                        $count_disqualification = $disqualification_array[0]['count'];

                        if (0 != $count_lineup ||
                            0 != $count_disqualification)
                        {
                            if (0 == $k) //Вратарская позиция, если вратаря в команде нет, будет стоять в воротах полевой
                            {
                                $order_sql = '`player_position_id`';
                            }
                            else
                            {
                                $order_sql = 1;
                            }

                            $sql = "SELECT `player_id`
                                    FROM `player`
                                    LEFT JOIN
                                    (
                                        SELECT `disqualification_player_id`,
                                               `disqualification_red`,
                                               `disqualification_yellow`
                                        FROM `disqualification`
                                        WHERE `disqualification_tournament_id`='$tournament_id'
                                        GROUP BY `disqualification_player_id`
                                    ) AS `t1`
                                    ON `disqualification_player_id`=`player_id`
                                    WHERE `player_national_id`='$country_id'
                                    AND `player_id` NOT IN
                                    (
                                        SELECT `lineup_player_id`
                                        FROM `lineup`
                                        WHERE `lineup_game_id`='$game_id'
                                        AND `lineup_country_id`='$country_id'
                                        AND `lineup_player_id`!='$player_id'
                                    )
                                    AND (`disqualification_red`='0'
                                    OR `disqualification_red` IS NULL)
                                    AND (`disqualification_yellow`<'2'
                                    OR `disqualification_yellow` IS NULL)
                                    ORDER BY $order_sql, `player_condition` DESC
                                    LIMIT 1";
                            $player_sql = f_igosja_mysqli_query($sql);

                            $player_array = $player_sql->fetch_all(1);

                            $player_id = $player_array[0]['player_id'];

                            $sql = "UPDATE `lineup`
                                    SET `lineup_player_id`='$player_id'
                                    WHERE `lineup_id`='$lineup_id'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }
                        elseif (0 == $position_id)
                        {
                            if      (0 == $k) {$position_id =  1; $role_id =  1;}
                            elseif  (1 == $k) {$position_id =  3; $role_id =  5;}
                            elseif  (2 == $k) {$position_id =  4; $role_id =  9;}
                            elseif  (3 == $k) {$position_id =  6; $role_id =  9;}
                            elseif  (4 == $k) {$position_id =  7; $role_id =  5;}
                            elseif  (5 == $k) {$position_id = 13; $role_id =  18;}
                            elseif  (6 == $k) {$position_id = 14; $role_id =  21;}
                            elseif  (7 == $k) {$position_id = 16; $role_id =  21;}
                            elseif  (8 == $k) {$position_id = 17; $role_id =  18;}
                            elseif  (9 == $k) {$position_id = 23; $role_id =  30;}
                            elseif (10 == $k) {$position_id = 25; $role_id =  30;}
                            elseif (11 == $k) {$position_id = 26; $role_id =  0;}
                            elseif (12 == $k) {$position_id = 27; $role_id =  0;}
                            elseif (13 == $k) {$position_id = 28; $role_id =  0;}
                            elseif (14 == $k) {$position_id = 29; $role_id =  0;}
                            elseif (15 == $k) {$position_id = 30; $role_id =  0;}
                            elseif (16 == $k) {$position_id = 31; $role_id =  0;}
                            else              {$position_id = 32; $role_id =  0;}

                            $sql = "UPDATE `lineup`
                                    SET `lineup_position_id`='$position_id',
                                        `lineup_role_id`='$role_id'
                                    WHERE `lineup_id`='$lineup_id'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }
                    }
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}