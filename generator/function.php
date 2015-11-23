<?php

function f_igosja_generator_lineup_current_create()
//Создинае составов в командах, где их нет
{
    global $mysqli;

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `guestlineup`.`lineupcurrent_id` AS `guestlineup_id`,
                   `homelineup`.`lineupcurrent_id` AS `homelineup_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineupcurrent` AS `homelineup`
            ON `homelineup`.`lineupcurrent_team_id`=`game_home_team_id`
            LEFT JOIN `lineupcurrent` AS `guestlineup`
            ON `guestlineup`.`lineupcurrent_team_id`=`game_guest_team_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    $sql_insert = array();

    for ($i=0; $i<$count_game; $i++)
    {
        $home_lineup_id  = $game_array[$i]['homelineup_id'];
        $guest_lineup_id = $game_array[$i]['guestlineup_id'];

        if (!$home_lineup_id)
        {
            $home_team_id = $game_array[$i]['game_home_team_id'];
            $sql_insert[] = "('$home_team_id')";
        }

        if (!$guest_lineup_id)
        {
            $guest_team_id = $game_array[$i]['game_guest_team_id'];
            $sql_insert[]  = "('$guest_team_id')";
        }

        usleep(1);

        print '.';
        flush();
    }

    $count_sql_insert = count($sql_insert);

    if (0 < $count_sql_insert)
    {
        $sql_insert = implode(',', $sql_insert);

        $sql = "INSERT INTO `lineupcurrent` (`lineupcurrent_team_id`)
                VALUES " . $sql_insert . ";";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_lineup_current_check_and_fill()
//Проверяем составы и заполняем пустые/исправляем
{
    global $mysqli;

    $sql = "SELECT `game_guest_team_id`,
                   `game_tournament_id`,
                   `guest_team`.`team_user_id` AS `guest_user_id`,
                   `guest_user`.`user_last_visit` AS `guest_last_visit`,
                   `game_home_team_id`,
                   `home_team`.`team_user_id` AS `home_user_id`,
                   `home_user`.`user_last_visit` AS `home_last_visit`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `user` AS `home_user`
            ON `home_team`.`team_user_id`=`home_user`.`user_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            LEFT JOIN `user` AS `guest_user`
            ON `guest_team`.`team_user_id`=`guest_user`.`user_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        for ($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $team  = 'game_home_team_id';
                $user  = 'home_user_id';
                $visit = 'home_last_visit';
            }
            else
            {
                $team  = 'game_guest_team_id';
                $user  = 'guest_user_id';
                $visit = 'guest_last_visit';
            }

            $team_id        = $game_array[$i][$team];
            $user_id        = $game_array[$i][$user];
            $last_visit     = $game_array[$i][$visit];
            $tournament_id  = $game_array[$i]['game_tournament_id'];

            if (0 == $user_id ||
                strtotime(date('Y-m-d H:i:s')) > strtotime($last_visit) + THREE_DAYS_TO_SECOND)
            {
                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_auto`='1',
                            `lineupcurrent_formation_id`='19',
                            `lineupcurrent_gamemood_id`='4',
                            `lineupcurrent_gamestyle_id`='3',
                            `lineupcurrent_player_id_1`='0',
                            `lineupcurrent_player_id_2`='0',
                            `lineupcurrent_player_id_3`='0',
                            `lineupcurrent_player_id_4`='0',
                            `lineupcurrent_player_id_5`='0',
                            `lineupcurrent_player_id_6`='0',
                            `lineupcurrent_player_id_7`='0',
                            `lineupcurrent_player_id_8`='0',
                            `lineupcurrent_player_id_9`='0',
                            `lineupcurrent_player_id_10`='0',
                            `lineupcurrent_player_id_11`='0',
                            `lineupcurrent_player_id_12`='0',
                            `lineupcurrent_player_id_13`='0',
                            `lineupcurrent_player_id_14`='0',
                            `lineupcurrent_player_id_15`='0',
                            `lineupcurrent_player_id_16`='0',
                            `lineupcurrent_player_id_17`='0',
                            `lineupcurrent_player_id_18`='0',
                            `lineupcurrent_position_id_1`='1',
                            `lineupcurrent_position_id_2`='3',
                            `lineupcurrent_position_id_3`='4',
                            `lineupcurrent_position_id_4`='6',
                            `lineupcurrent_position_id_5`='7',
                            `lineupcurrent_position_id_6`='13',
                            `lineupcurrent_position_id_7`='14',
                            `lineupcurrent_position_id_8`='16',
                            `lineupcurrent_position_id_9`='17',
                            `lineupcurrent_position_id_10`='23',
                            `lineupcurrent_position_id_11`='25',
                            `lineupcurrent_position_id_12`='26',
                            `lineupcurrent_position_id_13`='27',
                            `lineupcurrent_position_id_14`='28',
                            `lineupcurrent_position_id_15`='29',
                            `lineupcurrent_position_id_16`='30',
                            `lineupcurrent_position_id_17`='31',
                            `lineupcurrent_position_id_18`='32',
                            `lineupcurrent_role_id_1`='1',
                            `lineupcurrent_role_id_2`='5',
                            `lineupcurrent_role_id_3`='9',
                            `lineupcurrent_role_id_4`='9',
                            `lineupcurrent_role_id_5`='5',
                            `lineupcurrent_role_id_6`='18',
                            `lineupcurrent_role_id_7`='21',
                            `lineupcurrent_role_id_8`='21',
                            `lineupcurrent_role_id_9`='18',
                            `lineupcurrent_role_id_10`='30',
                            `lineupcurrent_role_id_11`='30'
                        WHERE `lineupcurrent_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `lineupcurrent_player_id_1`,
                           `lineupcurrent_player_id_2`,
                           `lineupcurrent_player_id_3`,
                           `lineupcurrent_player_id_4`,
                           `lineupcurrent_player_id_5`,
                           `lineupcurrent_player_id_6`,
                           `lineupcurrent_player_id_7`,
                           `lineupcurrent_player_id_8`,
                           `lineupcurrent_player_id_9`,
                           `lineupcurrent_player_id_10`,
                           `lineupcurrent_player_id_11`,
                           `lineupcurrent_player_id_12`,
                           `lineupcurrent_player_id_13`,
                           `lineupcurrent_player_id_14`,
                           `lineupcurrent_player_id_15`,
                           `lineupcurrent_player_id_16`,
                           `lineupcurrent_player_id_17`,
                           `lineupcurrent_player_id_18`
                    FROM `lineupcurrent`
                    WHERE `lineupcurrent_team_id`='$team_id'
                    LIMIT 1";

            $lineup_sql = $mysqli->query($sql);

            $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

            $lineup_array = array
            (
                $lineup_array[0]['lineupcurrent_player_id_1'],
                $lineup_array[0]['lineupcurrent_player_id_2'],
                $lineup_array[0]['lineupcurrent_player_id_3'],
                $lineup_array[0]['lineupcurrent_player_id_4'],
                $lineup_array[0]['lineupcurrent_player_id_5'],
                $lineup_array[0]['lineupcurrent_player_id_6'],
                $lineup_array[0]['lineupcurrent_player_id_7'],
                $lineup_array[0]['lineupcurrent_player_id_8'],
                $lineup_array[0]['lineupcurrent_player_id_9'],
                $lineup_array[0]['lineupcurrent_player_id_10'],
                $lineup_array[0]['lineupcurrent_player_id_11'],
                $lineup_array[0]['lineupcurrent_player_id_12'],
                $lineup_array[0]['lineupcurrent_player_id_13'],
                $lineup_array[0]['lineupcurrent_player_id_14'],
                $lineup_array[0]['lineupcurrent_player_id_15'],
                $lineup_array[0]['lineupcurrent_player_id_16'],
                $lineup_array[0]['lineupcurrent_player_id_17'],
                $lineup_array[0]['lineupcurrent_player_id_18']
            );

            $count_lineup = count($lineup_array);

            for ($k=0; $k<$count_lineup; $k++)
            {
                $player_id = $lineup_array[$k];

                $lineup_array[$k] = 0;
                $check_array      = array_count_values($lineup_array);
                $implode_array    = implode(',', $lineup_array);
                $lineup_array[$k] = $player_id;

                $sql = "SELECT COUNT(`disqualification_id`) AS `count`
                        FROM `disqualification`
                        WHERE `disqualification_player_id`='$player_id'
                        AND (`disqualification_red`='1'
                        OR `disqualification_yellow`='2')";
                $disqualification_sql = $mysqli->query($sql);

                $disqualification_array = $disqualification_sql->fetch_all(MYSQLI_ASSOC);

                $disqualification = $disqualification_array[0]['count'];

                if (0 == $player_id ||
                    isset($check_array[$player_id]) ||
                    0 != $disqualification)
                {
                    if (0 == $k) //Вратарская позиция, если вратаря в команде нет, будет стоять в воротах полевой
                    {
                        $order_sql = '`player_position_id`';
                    }
                    else
                    {
                        $order_sql = 1;
                    }

                    $sql = "SELECT `disqualification_red`,
                                   `disqualification_yellow`,
                                   `player_id`
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
                            AND `player_id` NOT IN (" . $implode_array . ")
                            AND (`disqualification_red`='0'
                            OR `disqualification_red` IS NULL)
                            AND (`disqualification_yellow`<'2'
                            OR `disqualification_yellow` IS NULL)
                            ORDER BY $order_sql, `player_condition` DESC
                            LIMIT 1";
                    $player_sql = $mysqli->query($sql);

                    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                    $player_id = $player_array[0]['player_id'];

                    $sql = "UPDATE `lineupcurrent`
                            SET `lineupcurrent_player_id_" . ($k + 1) . "`='$player_id'
                            WHERE `lineupcurrent_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $lineup_array[$k] = $player_id;
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_lineup_current_to_lineup()
//Переносим составы команд на матчи
{
    global $mysqli;

    for ($i=0; $i<LINEUP_PLAYER_NUMBER; $i++)
    {
        for($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $team = '`game_home_team_id`';
            }
            else
            {
                $team = '`game_guest_team_id`';
            }

            $sql = "INSERT INTO `lineup`
                    (
                        `lineup_auto`,
                        `lineup_condition`,
                        `lineup_player_id`,
                        `lineup_position_id`,
                        `lineup_game_id`,
                        `lineup_team_id`
                    )
                    SELECT `lineupcurrent_auto`,
                           `player_condition`,
                           `lineupcurrent_player_id_" . ($i + 1) . "`,
                           `lineupcurrent_position_id_" . ($i + 1) . "`,
                           `game_id`,
                           " . $team . "
                    FROM `game`
                    LEFT JOIN `shedule`
                    ON `game_shedule_id`=`shedule_id`
                    LEFT JOIN `lineupcurrent`
                    ON `lineupcurrent_team_id`=" . $team . "
                    LEFT JOIN `player`
                    ON `player_id`=`lineupcurrent_player_id_" . ($i + 1) . "`
                    WHERE `shedule_date`=CURDATE()
                    AND `game_played`='0'
                    ORDER BY `game_id` ASC";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_lineup_current_auto_reset()
//Убираем автосоставы из формы отправки состава
{
    global $mysqli;

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_auto`='0'
            WHERE `lineupcurrent_auto`='1'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_lineup_to_disqualification()
//Добавляем игроков в таблицы дисквалификации
{
    global $mysqli;

    $sql = "SELECT `disqualification_id`,
                   `game_tournament_id`,
                   `lineup_player_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN
            (
                SELECT `disqualification_id`,
                       `disqualification_player_id`,
                       `disqualification_tournament_id`
                FROM `disqualification`
            ) AS `t1`
            ON `disqualification_player_id`=`lineup_player_id`
            AND `disqualification_tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $lineup_sql = $mysqli->query($sql);

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_lineup; $i++)
    {
        $disqualification_id = $lineup_array[$i]['disqualification_id'];

        if (!$disqualification_id)
        {
            $tournament_id  = $lineup_array[$i]['game_tournament_id'];
            $player_id      = $lineup_array[$i]['lineup_player_id'];

            $sql = "INSERT INTO `disqualification`
                    SET `disqualification_player_id`='$player_id',
                        `disqualification_tournament_id`='$tournament_id'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_lineup_to_statistic()
//Добавляем игроков в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`,
                   `lineup_player_id`,
                   `lineup_team_id`,
                   `statisticplayer_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN
            (
                SELECT `statisticplayer_id`,
                       `statisticplayer_player_id`,
                       `statisticplayer_team_id`,
                       `statisticplayer_tournament_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $lineup_sql = $mysqli->query($sql);

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_lineup; $i++)
    {
        $statisticplayer_id = $lineup_array[$i]['statisticplayer_id'];

        if (!$statisticplayer_id)
        {
            $player_id      = $lineup_array[$i]['lineup_player_id'];
            $team_id        = $lineup_array[$i]['lineup_team_id'];
            $tournament_id  = $lineup_array[$i]['game_tournament_id'];

            $sql = "INSERT INTO `statisticplayer`
                            SET `statisticplayer_player_id`='$player_id',
                                `statisticplayer_tournament_id`='$tournament_id',
                                `statisticplayer_season_id`='$igosja_season_id',
                                `statisticplayer_team_id`='$team_id'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_referee_to_statistic()
//Добавляем судей в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_referee_id`,
                   `game_tournament_id`,
                   `statisticreferee_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN
            (
                SELECT `statisticreferee_id`,
                       `statisticreferee_referee_id`,
                       `statisticreferee_tournament_id`
                FROM `statisticreferee`
                WHERE `statisticreferee_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticreferee_id`=`game_referee_id`
            AND `statisticreferee_tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            GROUP BY `game_referee_id`
            ORDER BY `game_id` ASC";
    $referee_sql = $mysqli->query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_referee; $i++)
    {
        $statisticreferee_id = $referee_array[$i]['statisticreferee_id'];

        if (!$statisticreferee_id)
        {
            $referee_id     = $referee_array[$i]['game_referee_id'];
            $tournament_id  = $referee_array[$i]['game_tournament_id'];

            $sql = "INSERT INTO `statisticreferee`
                    SET `statisticreferee_tournament_id`='$tournament_id',
                        `statisticreferee_season_id`='$igosja_season_id',
                        `statisticreferee_referee_id`='$referee_id'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_team_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`,
                   `lineup_team_id`,
                   `statisticteam_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN
            (
                SELECT `statisticteam_id`,
                       `statisticteam_team_id`,
                       `statisticteam_tournament_id`
                FROM `statisticteam`
                WHERE `statisticteam_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticteam_tournament_id`=`game_tournament_id`
            AND `statisticteam_team_id`=`lineup_team_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            GROUP BY `lineup_team_id`
            ORDER BY `game_id` ASC";
    $team_sql = $mysqli->query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $statisticteam_id = $team_array[$i]['statisticteam_id'];

        if (!$statisticteam_id)
        {
            $team_id        = $team_array[$i]['lineup_team_id'];
            $tournament_id  = $team_array[$i]['game_tournament_id'];

            $sql = "INSERT INTO `statisticteam`
                    SET `statisticteam_tournament_id`='$tournament_id',
                        `statisticteam_season_id`='$igosja_season_id',
                        `statisticteam_team_id`='$team_id'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_user_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `statisticuser_id`,
                   `team_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `team`
            ON `lineup_team_id`=`team_id`
            LEFT JOIN
            (
                SELECT `statisticuser_id`,
                       `statisticuser_user_id`
                FROM `statisticuser`
                WHERE `statisticuser_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `statisticuser_user_id`=`team_user_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            AND `team_user_id`!='0'
            GROUP BY `team_user_id`
            ORDER BY `game_id` ASC";
    $user_sql = $mysqli->query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_user; $i++)
    {
        $statisticuser_id = $user_array[$i]['statisticuser_id'];

        if (!$statisticuser_id)
        {
            $user_id = $user_array[$i]['team_user_id'];

            $sql = "INSERT INTO `statisticuser`
                    SET `statisticuser_season_id`='$igosja_season_id',
                        `statisticuser_user_id`='$user_id'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_game_result()
//Генерируем результат матча
{
    global $mysqli;

    $koef_1 = 100000;
    $koef_2 = 100000;
    $koef_3 = 100000;
    $koef_4 = 100000;
    $koef_5 = 10000;

    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id = $game_array[$i]['game_id'];

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
                $team       = 'home';
                $team_sql   = 'game_home_team_id';
            }
            else
            {
                $team       = 'guest';
                $team_sql   = 'game_guest_team_id';
            }

            $team_id = $game_array[$i][$team_sql];

            $sql = "SELECT `lineup_auto`,
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
                    AND `lineup_team_id`='$team_id'
                    AND `lineup_position_id`<='25'
                    ORDER BY `lineup_position_id` ASC";
            $lineup_sql = $mysqli->query($sql);

            $count_lineup = $lineup_sql->num_rows;
            $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_lineup; $k++)
            {
                $player_power = $lineup_array[$k]['player_power'];
                $position_id  = $lineup_array[$k]['lineup_position_id'];
                $auto         = $lineup_array[$k]['lineup_auto'];

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

                $$team_power = $$team_power + $player_power;

                if (1 == $position_id)
                {
                    $$gk = $$gk + $player_power;
                }
                elseif (2 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (3 == $position_id)
                {
                    $$defence_center  = $$defence_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (in_array($position_id, array(4, 5, 6)))
                {
                    $$defence_left    = $$defence_left    + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$defence_right   = $$defence_right   + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                }
                elseif (7 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (8 == $position_id)
                {
                    $$defence_right   = $$defence_right   + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (in_array($position_id, array(9, 10, 11)))
                {
                    $$defence_center  = $$defence_center  + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 4 - $player_power / 4 * $auto / 4;
                }
                elseif (12 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$defence_center  = $$defence_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (13 == $position_id)
                {
                    $$defence_right   = $$defence_right   + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power / 4 - $player_power / 4 * $auto / 4;
                }
                elseif (in_array($position_id, array(14, 15, 16)))
                {
                    $$defence_center  = $$defence_center  + $player_power / 5 - $player_power / 5 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power / 5 - $player_power / 5 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 5 - $player_power / 5 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 5 - $player_power / 5 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power / 5 - $player_power / 5 * $auto / 4;
                }
                elseif (17 == $position_id)
                {
                    $$defence_left    = $$defence_left    + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_left   = $$halfback_left   + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power / 4 - $player_power / 4 * $auto / 4;
                }
                elseif (18 == $position_id)
                {
                    $$halfback_right  = $$halfback_right  + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (in_array($position_id, array(19, 20, 21)))
                {
                    $$halfback_left   = $$halfback_left   + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$halfback_right  = $$halfback_right  + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power / 4 - $player_power / 4 * $auto / 4;
                }
                elseif (22 == $position_id)
                {
                    $$halfback_left   = $$halfback_left   + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power / 3 - $player_power / 3 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power / 3 - $player_power / 3 * $auto / 4;
                }
                elseif (in_array($position_id, array(23, 24, 25)))
                {
                    $$halfback_center = $$halfback_center + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_left    = $$forward_left    + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_center  = $$forward_center  + $player_power / 4 - $player_power / 4 * $auto / 4;
                    $$forward_right   = $$forward_right   + $player_power / 4 - $player_power / 4 * $auto / 4;
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
                    $defence_1 = $team_1 . '_defence_left';
                    $forward_2 = $team_2 . '_forward_right';
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

                $defence_1 = $$defence_1;
                $forward_2 = $$forward_2;

                if (rand(0, $defence_1 + $koef_1) > rand(0, $forward_2 + $koef_1))
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

                        if (rand(0, $forward_1 + $koef_3) > rand(0, $defence_2 + $koef_3))
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

        $home_moment        = round(($home_on_target + $home_score) / 2) + rand(-1, 1);
        $guest_moment       = round(($guest_on_target + $guest_score) / 2) + rand(-1, 1);
        $home_pass          = $home_pass + rand(60, 80);
        $guest_pass         = $guest_pass + rand(60, 80);
        $home_corner        = $home_corner  + rand(3, 8);
        $guest_corner       = $guest_corner + rand(3, 8);
        $home_offside       = $home_offside  + rand(1, 4);
        $guest_offside      = $guest_offside + rand(1, 4);
        $home_foul          = $home_foul  + rand(8, 17);
        $guest_foul         = $guest_foul + rand(8, 17);
        $home_penalty       = $home_penalty  + floor(rand(0, 7) / 7);
        $guest_penalty      = $guest_penalty + floor(rand(0, 7) / 7);
        $home_yellow        = $home_yellow  + rand(0, 3);
        $guest_yellow       = $guest_yellow + rand(0, 3);
        $home_red           = $home_red  + floor(rand(0, 8) / 8);
        $guest_red          = $guest_red + floor(rand(0, 8) / 8);
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
                    `game_guest_score`='$guest_score',
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
                    `game_home_score`='$home_score',
                    `game_home_shot`='$home_shot',
                    `game_home_yellow`='$home_yellow',
                    `game_referee_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND()
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_lineup_mark_distance()
//Добавляем доп данные в составы матча (дистанция, оценки)
{
    global $mysqli;

    for ($i=0; $i<2; $i++) //Вратарям ставим меньше беготни и передач
    {
        if (0 == $i)
        {
            $distance   = "'3000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()";
            $pass       = "'30'+'10'*RAND()+'10'*RAND()+'10'*RAND()";
            $accurate   = "'15'+'5'*RAND()+'5'*RAND()+'5'*RAND()";
            $position   = " BETWEEN '2' AND '26'";
        }
        else
        {
            $distance = "'2000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()";
            $pass = "'15'+'2'*RAND()+'2'*RAND()+'2'*RAND()";
            $accurate = "'9'+'2'*RAND()+'2'*RAND()+'2'*RAND()";
            $position   = "='1'";
        }

        $sql = "UPDATE `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                SET `lineup_distance`=" . $distance . ",
                    `lineup_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND(),
                    `lineup_pass`=" . $pass . ",
                    `lineup_pass_accurate`=" . $accurate . "
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `lineup_position_id`" . $position;
        $mysqli->query($sql);
    }
}



