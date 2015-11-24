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

function f_igosja_generator_disqualification_decrease()
//Снятие дисквалификаций
{
    global $mysqli;

    $sql = "UPDATE `disqualification`
            SET `disqualification_yellow`='0'
            WHERE `disqualification_yellow`='2'
            AND `disqualification_red`='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `disqualification`
            SET `disqualification_red`='0'
            WHERE `disqualification_red`='1'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_visitor()
//Количество зрителей на трибунах
{
    global $mysqli;

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            LEFT JOIN `team` AS `home`
            ON `game_home_team_id`=`home`.`team_id`
            LEFT JOIN `team` AS `guest`
            ON `game_guest_team_id`=`guest`.`team_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            SET `game_visitor`=
            IF(ROUND((`home`.`team_visitor`+`guest`.`team_visitor`)*`tournament_visitor`)>`stadium_capacity`,
               `stadium_capacity`,
               ROUND((`home`.`team_visitor`+`guest`.`team_visitor`)*`tournament_visitor`)>`stadium_capacity`)
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
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

        $home_moment        = round(($home_on_target + $home_score) / 2) - rand(0, 1);
        $guest_moment       = round(($guest_on_target + $guest_score) / 2) - rand(0, 1);
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
            $position   = " BETWEEN '2' AND '25'";
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

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_lineup_statisticplayer_after_game_and_event()
//Записываем данные матча в таблицу сосотавов, обновляем статистику игроков и создаем события матча
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_foul`,
                   `game_guest_offside`,
                   `game_guest_ontarget`,
                   `game_guest_penalty`,
                   `game_guest_red`,
                   `game_guest_shot`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_guest_yellow`,
                   `game_home_foul`,
                   `game_home_offside`,
                   `game_home_ontarget`,
                   `game_home_penalty`,
                   `game_home_red`,
                   `game_home_score`,
                   `game_home_shot`,
                   `game_home_team_id`,
                   `game_home_yellow`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];

        for ($k=0; $k<HOME_GUEST_LOOP; $k++)
        {
            if (0 == $k)
            {
                $team       = 'home';
                $opponent   = 'guest';
            }
            else
            {
                $team       = 'guest';
                $opponent   = 'home';
            }

            $team_id        = $game_array[$i]['game_' . $team . '_team_id'];
            $opponent_id    = $game_array[$i]['game_' . $opponent . '_team_id'];
            $foul           = $game_array[$i]['game_' . $team . '_foul'];
            $offside        = $game_array[$i]['game_' . $team . '_offside'];
            $ontarget       = $game_array[$i]['game_' . $team . '_ontarget'];
            $score          = $game_array[$i]['game_' . $team . '_score'];
            $shot           = $game_array[$i]['game_' . $team . '_shot'];
            $penalty        = $game_array[$i]['game_' . $team . '_penalty'];
            $red            = $game_array[$i]['game_' . $team . '_red'];
            $yellow         = $game_array[$i]['game_' . $team . '_yellow'];

            for ($j=0; $j<$foul; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_foul`=`statisticplayer_foul`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_foul_made`=`lineup_foul_made`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_foul_recieve`=`lineup_foul_recieve`+'1'
                        WHERE `lineup_team_id`='$opponent_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$yellow; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_foul_made`>'0'
                        AND `lineup_yellow`='0'
                        AND `lineup_red`='0'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `disqualification`
                        SET `disqualification_yellow`=`disqualification_yellow`+'1'
                        WHERE `disqualification_player_id`='$player_id'
                        AND `disqualification_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_yellow`=`statisticplayer_yellow`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_yellow`=`lineup_yellow`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "INSERT INTO `event`
                        SET `event_eventtype_id`='" . EVENT_YELLOW . "',
                            `event_game_id`='$game_id',
                            `event_minute`='1'+'89'*RAND(),
                            `event_player_id`='$player_id',
                            `event_team_id`='$team_id'";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$red; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_foul_made`>'0'
                        AND `lineup_foul_made`>`lineup_yellow`
                        AND `lineup_red`='0'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `disqualification`
                        SET `disqualification_red`=`disqualification_red`+'1'
                        WHERE `disqualification_player_id`='$player_id'
                        AND `disqualification_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_red`=`statisticplayer_red`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_red`=`lineup_red`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "INSERT INTO `event`
                        SET `event_eventtype_id`='" . EVENT_RED . "',
                            `event_game_id`='$game_id',
                            `event_minute`='70'+'20'*RAND(),
                            `event_player_id`='$player_id',
                            `event_team_id`='$team_id'";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$offside; $j++)
            {
                $offset = rand(1,100);

                if     (15 >= $offset) {$offset = 0;}
                elseif (29 >= $offset) {$offset = 1;}
                elseif (42 >= $offset) {$offset = 2;}
                elseif (54 >= $offset) {$offset = 3;}
                elseif (65 >= $offset) {$offset = 4;}
                elseif (74 >= $offset) {$offset = 5;}
                elseif (82 >= $offset) {$offset = 6;}
                elseif (89 >= $offset) {$offset = 7;}
                elseif (95 >= $offset) {$offset = 8;}
                else                   {$offset = 9;}

                $sql = "SELECT `lineup_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '13' AND '25'
                        AND `lineup_game_id`='$game_id'
                        ORDER BY `lineup_position_id` DESC
                        LIMIT $offset, 1";
                $lineup_sql = $mysqli->query($sql);

                $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

                $lineup_id = $lineup_array[0]['lineup_id'];

                $sql = "UPDATE `lineup`
                        SET `lineup_offside`=`lineup_offside`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$shot; $j++)
            {
                $offset = rand(1,100);

                if     (15 >= $offset) {$offset = 0;}
                elseif (29 >= $offset) {$offset = 1;}
                elseif (42 >= $offset) {$offset = 2;}
                elseif (54 >= $offset) {$offset = 3;}
                elseif (65 >= $offset) {$offset = 4;}
                elseif (74 >= $offset) {$offset = 5;}
                elseif (82 >= $offset) {$offset = 6;}
                elseif (89 >= $offset) {$offset = 7;}
                elseif (95 >= $offset) {$offset = 8;}
                else                   {$offset = 9;}

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        ORDER BY `lineup_position_id` DESC
                        LIMIT $offset, 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$ontarget; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_shot`>`lineup_ontarget`
                        ORDER BY `lineup_shot`-`lineup_ontarget` DESC, RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_ontarget`=`lineup_ontarget`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$penalty; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_ontarget`>`lineup_goal`
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`+'1',
                            `statisticplayer_penalty`=`statisticplayer_penalty`+'1',
                            `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`+'1',
                            `lineup_penalty`=`lineup_penalty`+'1',
                            `lineup_penalty_goal`=`lineup_penalty_goal`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "INSERT INTO `event`
                        SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                            `event_game_id`='$game_id',
                            `event_minute`='1'+'89'*RAND(),
                            `event_player_id`='$player_id',
                            `event_team_id`='$team_id'";
                $mysqli->query($sql);
            }

            for ($j=0; $j<$score-$penalty; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_ontarget`>`lineup_goal`
                        ORDER BY `lineup_goal`-`lineup_ontarget` DESC, RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "INSERT INTO `event`
                        SET `event_eventtype_id`='" . EVENT_GOAL . "',
                            `event_game_id`='$game_id',
                            `event_minute`='1'+'89'*RAND(),
                            `event_player_id`='$player_id',
                            `event_team_id`='$team_id'";
                $mysqli->query($sql);

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_id`!='$lineup_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_statisticplayer()
//Обновляем статистику игроков, которую не надо пускать в циклы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "UPDATE `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `statisticplayer`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`
            SET `statisticplayer_game`=`statisticplayer_game`+'1',
                `statisticplayer_distance`=`statisticplayer_distance`+`lineup_distance`,
                `statisticplayer_mark`=`statisticplayer_mark`+`lineup_mark`,
                `statisticplayer_pass`=`statisticplayer_pass`+`lineup_pass`,
                `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+`lineup_pass_accurate`
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_position_id`<='25'
            AND `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_best_player()
//Вычисляем лучших игровок матча и в статистику
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "UPDATE `statisticplayer`
            LEFT JOIN
            (
                SELECT *
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                GROUP BY `lineup_game_id`
                ORDER BY `lineup_mark` DESC
            ) AS `t1`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`
            SET `statisticplayer_best`=`statisticplayer_best`+'1'
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_id` IS NOT NULL";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_statistic_team_user_referee()
//Вычисляем лучших игровок матча и в статистику
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_foul`,
                   `game_guest_ontarget`,
                   `game_guest_penalty`,
                   `game_guest_red`,
                   `game_guest_shot`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_guest_yellow`,
                   `game_home_foul`,
                   `game_home_ontarget`,
                   `game_home_penalty`,
                   `game_home_red`,
                   `game_home_score`,
                   `game_home_shot`,
                   `game_home_team_id`,
                   `game_home_yellow`,
                   `game_referee_id`,
                   `game_referee_mark`,
                   `game_tournament_id`,
                   `game_visitor`,
                   `guest_team`.`team_user_id` AS `guest_user_id`,
                   `home_team`.`team_user_id` AS `home_user_id`,
                   `stadium_capacity`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $home_user_id   = $game_array[$i]['home_user_id'];
        $home_foul      = $game_array[$i]['game_home_foul'];
        $home_ontarget  = $game_array[$i]['game_home_ontarget'];
        $home_score     = $game_array[$i]['game_home_score'];
        $home_shot      = $game_array[$i]['game_home_shot'];
        $home_penalty   = $game_array[$i]['game_home_penalty'];
        $home_red       = $game_array[$i]['game_home_red'];
        $home_yellow    = $game_array[$i]['game_home_yellow'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_user_id  = $game_array[$i]['guest_user_id'];
        $guest_foul     = $game_array[$i]['game_guest_foul'];
        $guest_ontarget = $game_array[$i]['game_guest_ontarget'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $guest_shot     = $game_array[$i]['game_guest_shot'];
        $guest_penalty  = $game_array[$i]['game_guest_penalty'];
        $guest_red      = $game_array[$i]['game_guest_red'];
        $guest_yellow   = $game_array[$i]['game_guest_yellow'];
        $referee_id     = $game_array[$i]['game_referee_id'];
        $referee_mark   = $game_array[$i]['game_referee_mark'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $visitor        = $game_array[$i]['game_visitor'];
        $stadium        = $game_array[$i]['stadium_capacity'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;
        $full_house     = 0;

        if ($visitor = $stadium)
        {
            $full_house = 1;
        }

        $sql = "UPDATE `statisticreferee`
                SET `statisticreferee_game`=`statisticreferee_game`+'1',
                    `statisticreferee_mark`=`statisticreferee_mark`+'$referee_mark',
                    `statisticreferee_penalty`=`statisticreferee_penalty`+'$home_penalty'+'$guest_penalty',
                    `statisticreferee_red`=`statisticreferee_red`+'$home_red'+'$guest_red',
                    `statisticreferee_yellow`=`statisticreferee_yellow`+'$home_yellow'+'$guest_yellow'
                WHERE `statisticreferee_tournament_id`='$tournament_id'
                AND `statisticreferee_season_id`='$igosja_season_id'
                AND `statisticreferee_referee_id`='$referee_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_game`=`statisticteam_game`+'1'
                WHERE `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'
                AND `statisticteam_team_id` IN ('$home_team_id', '$guest_team_id')";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_foul`=`statisticteam_foul`+'$home_foul',
                    `statisticteam_full_house`=`statisticteam_full_house`+'$full_house',
                    `statisticteam_goal`=`statisticteam_goal`+'$home_score',
                    `statisticteam_ontarget`=`statisticteam_ontarget`+'$home_ontarget',
                    `statisticteam_pass`=`statisticteam_pass`+'$guest_score',
                    `statisticteam_penalty`=`statisticteam_penalty`+'$home_penalty',
                    `statisticteam_penalty_goal`=`statisticteam_penalty_goal`+'$home_penalty',
                    `statisticteam_red`=`statisticteam_red`+'$home_red',
                    `statisticteam_shot`=`statisticteam_shot`+'$home_shot',
                    `statisticteam_visitor`=`statisticteam_visitor`+'$visitor',
                    `statisticteam_yellow`=`statisticteam_yellow`+'$home_yellow'
                WHERE `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'
                AND `statisticteam_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_foul`=`statisticteam_foul`+'$guest_foul',
                    `statisticteam_full_house`=`statisticteam_full_house`+'$full_house',
                    `statisticteam_goal`=`statisticteam_goal`+'$guest_score',
                    `statisticteam_ontarget`=`statisticteam_ontarget`+'$guest_ontarget',
                    `statisticteam_pass`=`statisticteam_pass`+'$home_score',
                    `statisticteam_penalty`=`statisticteam_penalty`+'$guest_penalty',
                    `statisticteam_red`=`statisticteam_red`+'$guest_red',
                    `statisticteam_shot`=`statisticteam_shot`+'$guest_shot',
                    `statisticteam_visitor`=`statisticteam_visitor`+'$visitor',
                    `statisticteam_yellow`=`statisticteam_yellow`+'$guest_yellow'
                WHERE `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'
                AND `statisticteam_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        if ($home_score > $guest_score)
        {
            $home_win++;
            $guest_loose++;

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_win`=`statisticplayer_win`+'1'
                    WHERE `statisticplayer_player_id` IN
                    (
                        SELECT `lineup_player_id`
                        FROM `game`
                        LEFT JOIN `lineup`
                        ON (`game_id`=`lineup_game_id`
                        AND `game_home_team_id`=`lineup_team_id`)
                        WHERE `game_id`='$game_id'
                        ORDER BY `lineup_position_id` ASC
                    )
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'";
            $mysqli->query($sql);
        }
        elseif ($home_score == $guest_score)
        {
            $home_draw++;
            $guest_draw++;
        }
        elseif ($home_score < $guest_score)
        {
            $home_loose++;
            $guest_win++;

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_win`=`statisticplayer_win`+'1'
                    WHERE `statisticplayer_player_id` IN
                    (
                        SELECT `lineup_player_id`
                        FROM `game`
                        LEFT JOIN `lineup`
                        ON (`game_id`=`lineup_game_id`
                        AND `game_guest_team_id`=`lineup_team_id`)
                        WHERE `game_id`='$game_id'
                        ORDER BY `lineup_position_id` ASC
                    )
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'";
            $mysqli->query($sql);
        }

        if (0 != $home_user_id)
        {
            $sql = "UPDATE `statisticuser`
                    SET `statisticuser_game`=`statisticuser_game`+'1',
                        `statisticuser_win`=`statisticuser_win`+'$home_win',
                        `statisticuser_draw`=`statisticuser_draw`+'$home_draw',
                        `statisticuser_loose`=`statisticuser_loose`+'$home_loose',
                        `statisticuser_score`=`statisticuser_score`+'$home_score',
                        `statisticuser_pass`=`statisticuser_pass`+'$guest_score'
                    WHERE `statisticuser_user_id`='$home_user_id'
                    AND `statisticuser_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        if (0 != $guest_user_id)
        {
            $sql = "UPDATE `statisticuser`
                    SET `statisticuser_game`=`statisticuser_game`+'1',
                        `statisticuser_win`=`statisticuser_win`+'$guest_win',
                        `statisticuser_draw`=`statisticuser_draw`+'$guest_draw',
                        `statisticuser_loose`=`statisticuser_loose`+'$guest_loose',
                        `statisticuser_score`=`statisticuser_score`+'$guest_score',
                        `statisticuser_pass`=`statisticuser_pass`+'$home_score'
                    WHERE `statisticuser_user_id`='$guest_user_id'
                    AND `statisticuser_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_player_condition_practice()
//Обновляем усталость и игровую правктику футболистам
{
    global $mysqli;

    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `lineup_condition`=`lineup_condition`-'20'+'10'*RAND(),
                `player_practice`=`player_practice`+'10'+'5'*RAND()
            WHERE `shedule_date`=CURDATE()
            AND `lineup_position_id`<='25'
            AND `game_played`='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `player_condition`=`lineup_condition`
            WHERE `shedule_date`=CURDATE()
            AND `lineup_position_id`<='25'
            AND `game_played`='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`=`player_condition`+'4'+'2'*RAND(),
                `player_practice`=`player_practice`-'2'-'2'*RAND()";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`='100'
            WHERE `player_condition`>'100'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`='50'
            WHERE `player_condition`<'50'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='100'
            WHERE `player_practice`>'100'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='50'
            WHERE `player_practice`<'50'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_standing()
//Обновляем турнирные таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_guest_score`,
                   `game_home_team_id`,
                   `game_home_score`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;

        if ($home_score > $guest_score)
        {
            $home_win++;
            $guest_loose++;
        }
        elseif ($home_score == $guest_score)
        {
            $home_draw++;
            $guest_draw++;
        }
        elseif ($home_score < $guest_score)
        {
            $home_loose++;
            $guest_win++;
        }

        $sql = "UPDATE `standing`
                SET `standing_game`=`standing_game`+'1',
                    `standing_win`=`standing_win`+'$home_win',
                    `standing_draw`=`standing_draw`+'$home_draw',
                    `standing_loose`=`standing_loose`+'$home_loose',
                    `standing_score`=`standing_score`+'$home_score',
                    `standing_pass`=`standing_pass`+'$guest_score',
                    `standing_point`=`standing_win`*'3'+`standing_draw`
                WHERE `standing_team_id`='$home_team_id'
                AND `standing_season_id`='$igosja_season_id'
                AND `standing_tournament_id`='$tournament_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `standing`
                SET `standing_game`=`standing_game`+'1',
                    `standing_win`=`standing_win`+'$guest_win',
                    `standing_draw`=`standing_draw`+'$guest_draw',
                    `standing_loose`=`standing_loose`+'$guest_loose',
                    `standing_score`=`standing_score`+'$guest_score',
                    `standing_pass`=`standing_pass`+'$home_score',
                    `standing_point`=`standing_win`*'3'+`standing_draw`
                WHERE `standing_team_id`='$guest_team_id'
                AND `standing_season_id`='$igosja_season_id'
                AND `standing_tournament_id`='$tournament_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $sql = "SELECT `standing_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            ORDER BY `standing_point` DESC, `standing_score`-`standing_pass` DESC, `standing_score` DESC";
    $standing_sql = $mysqli->query($sql);

    $count_standing = $standing_sql->num_rows;

    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_standing; $i++)
    {
        $standing_id = $standing_array[$i]['standing_id'];

        $place = $i + 1;

        $sql = "UPDATE `standing`
                SET `standing_place`='$place'
                WHERE `standing_id`='$standing_id'";
        $mysqli->query($sql);
    }

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_standing_history()
//Предыдущие позиции в турнирной таблице
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "INSERT INTO `standinghistory`
            (
                `standinghistory_tournament_id`,
                `standinghistory_team_id`,
                `standinghistory_stage_id`,
                `standinghistory_place`)
            SELECT `standing_tournament_id`,
                   `standing_team_id`,
                   `standing_game`,
                   `standing_place`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_game_series()
//Увеличение серий матчей (побед, без поражений, без пропущенных...)
{
    global $mysqli;

    $sql = "SELECT `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_score    = $game_array[$i]['game_guest_score'];

        if ($home_score > $guest_score)
        {
            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
        elseif ($home_score < $guest_score)
        {
            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
        elseif ($home_score == $guest_score)
        {
            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='0'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_WIN . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                    OR `series_seriestype_id`='" . SERIES_WIN . "')
                    AND `series_tournament_id`='$tournament_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        if (0 == $home_score)
        {
            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_PASS . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_PASS . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
        elseif (0 != $home_score)
        {
            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
            $mysqli->query($sql);
        }

        if (0 == $guest_score)
        {
            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_PASS . ",
                            `series_value`='1',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$guest_team_id',
                            `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $sql = "SELECT `series_id`
                    FROM `series`
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                    LIMIT 1";
            $check_sql = $mysqli->query($sql);

            $count_check = $check_sql->num_rows;

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `series`
                        SET `series_team_id`='$home_team_id',
                            `series_seriestype_id`=" . SERIES_NO_PASS . ",
                            `series_value`='1',
                            `series_tournament_id`='$tournament_id',
                            `series_date_start`=CURDATE(),
                            `series_date_end`=CURDATE()";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `series`
                        SET `series_value`=`series_value`+'1',
                            `series_date_end`=CURDATE(),
                            `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
        elseif (0 != $guest_score)
        {
            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='0'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$guest_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
            $mysqli->query($sql);

            $sql = "UPDATE `series`
                    SET `series_value`='0'
                    WHERE `series_team_id`='$home_team_id'
                    AND `series_tournament_id`='$tournament_id'
                    AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
            $mysqli->query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_team_series_to_record()
//Обровление командных рекордов из серий матчей (побед, без поражений, без пропущенных...)
{
    global $mysqli;

    for ($j=0; $j<6; $j++)
    {
        if     (0 == $j) {$series = SERIES_WIN;         $record = RECORD_TEAM_WIN;}
        elseif (1 == $j) {$series = SERIES_NO_LOOSE;    $record = RECORD_TEAM_NO_LOOSE;}
        elseif (2 == $j) {$series = SERIES_NO_WIN;      $record = RECORD_TEAM_NO_WIN;}
        elseif (3 == $j) {$series = SERIES_LOOSE;       $record = RECORD_TEAM_LOOSE;}
        elseif (4 == $j) {$series = SERIES_NO_PASS;     $record = RECORD_TEAM_NO_PASS;}
        else             {$series = SERIES_NO_SCORE;    $record = RECORD_TEAM_NO_SCORE;}

        $sql = "SELECT `series_date_end`,
                       `series_date_start`,
                       `series_team_id`,
                       `series_value`
                FROM `series`
                WHERE `series_seriestype_id`='$series'
                AND `series_tournament_id`='0'
                ORDER BY `series_team_id` ASC";
        $series_sql = $mysqli->query($sql);

        $count_series = $series_sql->num_rows;
        $series_array = $series_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_series; $i++)
        {
            $team_id    = $series_array[$i]['series_team_id'];
            $date_start = $series_array[$i]['series_date_start'];
            $date_end   = $series_array[$i]['series_date_end'];
            $value      = $series_array[$i]['series_value'];

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='$record'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$team_id',
                            `recordteam_value`='$value',
                            `recordteam_date_end`='$date_end',
                            `recordteam_date_start`='$date_start',
                            `recordteam_recordteamtype_id`='$record'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($record_value < $value)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$value',
                                `recordteam_date_end`='$date_end',
                                `recordteam_date_start`='$date_start'
                            WHERE `recordteam_recordteamtype_id`='$record'
                            AND `recordteam_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);
                }
            }

            usleep(1);

            print '.';
            flush();
        }
    }
}

function f_igosja_generator_tournament_series_to_record()
//Обровление турнирных рекордов из серий матчей (побед, без поражений, без пропущенных...)
{
    global $mysqli;

    for ($j=0; $j<6; $j++)
    {
        if     (0 == $j) {$series = SERIES_WIN;         $record = RECORD_TOURNAMENT_WIN;}
        elseif (1 == $j) {$series = SERIES_NO_LOOSE;    $record = RECORD_TOURNAMENT_NO_LOOSE;}
        elseif (2 == $j) {$series = SERIES_NO_WIN;      $record = RECORD_TOURNAMENT_NO_WIN;}
        elseif (3 == $j) {$series = SERIES_LOOSE;       $record = RECORD_TOURNAMENT_LOOSE;}
        elseif (4 == $j) {$series = SERIES_NO_PASS;     $record = RECORD_TOURNAMENT_NO_PASS;}
        else             {$series = SERIES_NO_SCORE;    $record = RECORD_TOURNAMENT_NO_SCORE;}

        $sql = "SELECT `series_tournament_id`
                FROM `series`
                WHERE `series_seriestype_id`='$series'
                AND `series_tournament_id`!='0'
                GROUP BY `series_tournament_id`
                ORDER BY `series_tournament_id` ASC";
        $tournament_sql = $mysqli->query($sql);

        $count_tournament = $tournament_sql->num_rows;

        $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_tournament; $i++)
        {
            $tournament_id = $tournament_array[$i]['series_tournament_id'];

            $sql = "SELECT `series_date_end`,
                           `series_date_start`,
                           `series_team_id`,
                           `series_value`
                    FROM `series`
                    WHERE `series_seriestype_id`='$series'
                    AND `series_tournament_id`='$tournament_id'
                    ORDER BY `series_value` DESC
                    LIMIT 1";
            $series_sql = $mysqli->query($sql);

            $series_array = $series_sql->fetch_all(MYSQLI_ASSOC);

            $team_id    = $series_array[0]['series_team_id'];
            $date_start = $series_array[0]['series_date_start'];
            $date_end   = $series_array[0]['series_date_end'];
            $value      = $series_array[0]['series_value'];

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='$record'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_value_1`='$value',
                            `recordtournament_date_end`='$date_end',
                            `recordtournament_date_start`='$date_start',
                            `recordtournament_recordtournamenttype_id`='$record'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($record_value < $value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$value',
                                `recordtournament_date_end`='$date_end',
                                `recordtournament_date_start`='$date_start'
                            WHERE `recordtournament_recordtournamenttype_id`='$record'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    $mysqli->query($sql);
                }
            }

            usleep(1);

            print '.';
            flush();
        }
    }
}

function f_igosja_generator_team_record()
//Командные рекорды
{
    global $mysqli;

    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_visitor`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

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
                $team       = 'home';
                $opponent   = 'guest';
            }
            else
            {
                $team       = 'guest';
                $opponent   = 'home';
            }

            $team_id        = $game_array[$i]['game_' . $team . '_team_id'];
            $score_1        = $game_array[$i]['game_' . $team . '_score'];
            $score_2        = $game_array[$i]['game_' . $opponent . '_score'];

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$team_id',
                            `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "',
                            `recordteam_value`='$visitor',
                            `recordteam_game_id`='$game_id'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($visitor > $record_value)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$visitor',
                                `recordteam_game_id`='$game_id'
                            WHERE `recordteam_team_id`='$team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'";
                    $mysqli->query($sql);
                }
            }

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$team_id',
                            `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "',
                            `recordteam_value`='$visitor',
                            `recordteam_game_id`='$game_id'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($visitor < $record_value &&
                    0 != $record_value)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$visitor',
                                `recordteam_game_id`='$game_id'
                            WHERE `recordteam_team_id`='$team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'";
                    $mysqli->query($sql);
                }
            }

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$team_id',
                            `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "',
                            `recordteam_value`='$total_score',
                            `recordteam_game_id`='$game_id'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($total_score < $record_value)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$total_score',
                                `recordteam_game_id`='$game_id'
                            WHERE `recordteam_team_id`='$team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'";
                    $mysqli->query($sql);
                }
            }

            if ($score_1 > $score_2)
            {
                $score = $score_1 - $score_2;

                $sql = "SELECT `recordteam_value`
                        FROM `recordteam`
                        WHERE `recordteam_team_id`='$team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'
                        LIMIT 1";
                $record_sql = $mysqli->query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordteam`
                            SET `recordteam_team_id`='$team_id',
                                `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "',
                                `recordteam_value`='$score',
                                `recordteam_game_id`='$game_id'";
                    $mysqli->query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                    $record_value = $record_array[0]['recordteam_value'];

                    if ($score < $record_value)
                    {
                        $sql = "UPDATE `recordteam`
                                SET `recordteam_value`='$score',
                                    `recordteam_game_id`='$game_id'
                                WHERE `recordteam_team_id`='$team_id'
                                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'";
                        $mysqli->query($sql);
                    }
                }
            }
            elseif ($score_1 < $score_2)
            {
                $score = $score_2 - $score_1;

                $sql = "SELECT `recordteam_value`
                        FROM `recordteam`
                        WHERE `recordteam_team_id`='$team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'
                        LIMIT 1";
                $record_sql = $mysqli->query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordteam`
                            SET `recordteam_team_id`='$team_id',
                                `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "',
                                `recordteam_value`='$score',
                                `recordteam_game_id`='$game_id'";
                    $mysqli->query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                    $record_value = $record_array[0]['recordteam_value'];

                    if ($score < $record_value)
                    {
                        $sql = "UPDATE `recordteam`
                                SET `recordteam_value`='$score',
                                    `recordteam_game_id`='$game_id'
                                WHERE `recordteam_team_id`='$team_id'
                                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'";
                        $mysqli->query($sql);
                    }
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `lineup_team_id`
            FROM `lineup`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            GROUP BY `lineup_team_id`
            ORDER BY `lineup_team_id` ASC";
    $team_sql = $mysqli->query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $team_id = $team_array[$i]['lineup_team_id'];

        $sql = "SELECT `lineup_goal`,
                       `lineup_player_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `lineup_team_id`='$team_id'
                ORDER BY `lineup_goal` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['lineup_player_id'];
        $goal       = $player_array[0]['lineup_goal'];

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_ONE_GAME_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_player_id`='$player_id',
                        `recordteam_recordteamtype_id`='" . RECORD_TEAM_ONE_GAME_SCORE . "',
                        `recordteam_team_id`='$team_id',
                        `recordteam_value`='$goal'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordteam_value'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordteam`
                        SET `recordteam_player_id`='$player_id',
                            `recordteam_value`='$goal'
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_ONE_GAME_SCORE . "'
                        AND `recordteam_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_goal`) AS `goal`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_team_id`='$team_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `goal` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $goal       = $player_array[0]['goal'];

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_SCORER . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_player_id`='$player_id',
                        `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_SCORER . "',
                        `recordteam_team_id`='$team_id',
                        `recordteam_value`='$goal'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordteam_value'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordteam`
                        SET `recordteam_player_id`='$player_id',
                            `recordteam_value`='$goal'
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_SCORER . "'
                        AND `recordteam_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_game`) AS `game`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_team_id`='$team_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `game` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $game       = $player_array[0]['game'];

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_GAMES . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_player_id`='$player_id',
                        `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_GAMES . "',
                        `recordteam_team_id`='$team_id',
                        `recordteam_value`='$game'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordteam_value'];

            if ($game > $record_value)
            {
                $sql = "UPDATE `recordteam`
                        SET `recordteam_player_id`='$player_id',
                            `recordteam_value`='$game'
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_GAMES . "'
                        AND `recordteam_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_pass_scoring`) AS `pass`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_team_id`='$team_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `pass` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $pass       = $player_array[0]['pass'];

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_ASSISTANT . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_player_id`='$player_id',
                        `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_ASSISTANT . "',
                        `recordteam_team_id`='$team_id',
                        `recordteam_value`='$pass'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_value = $record_array[0]['recordteam_value'];

            if ($pass > $record_value)
            {
                $sql = "UPDATE `recordteam`
                        SET `recordteam_player_id`='$player_id',
                            `recordteam_value`='$pass'
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_MOST_ASSISTANT . "'
                        AND `recordteam_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_tournament_record()
//Рекорды турниров
{
    global $mysqli;

    $sql = "SELECT `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            GROUP BY `game_tournament_id`
            ORDER BY `game_tournament_id` ASC";
    $tournament_sql = $mysqli->query($sql);

    $count_tournament = $tournament_sql->num_rows;

    $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

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
        $game_sql = $mysqli->query($sql);

        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        $game_id = $game_array[0]['game_id'];
        $visitor = $game_array[0]['game_visitor'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_game_id`='$game_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$visitor'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordtournament_value_1'];

            if ($visitor > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_value_1`='$visitor'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_HIGHEST_ATTENDANCE . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
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
        $game_sql = $mysqli->query($sql);

        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        $game_id = $game_array[0]['game_id'];
        $score   = $game_array[0]['game_score'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_game_id`='$game_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$score'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordtournament_value_1'];

            if ($score > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_value_1`='$score'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_SCORE . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
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
        $game_sql = $mysqli->query($sql);

        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        $game_id = $game_array[0]['game_id'];
        $score   = $game_array[0]['game_score'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_game_id`='$game_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$score'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordtournament_value_1'];

            if ($score > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_game_id`='$game_id',
                            `recordtournament_value_1`='$score'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_BIGGEST_WIN . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
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
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['lineup_player_id'];
        $goal       = $player_array[0]['lineup_goal'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_player_id`='$player_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$goal'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordtournament_value_1'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_value_1`='$goal'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_ONE_GAME_SCORE . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
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
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['lineup_player_id'];
        $mark       = $player_array[0]['lineup_mark'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_player_id`='$player_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$mark'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordtournament_value_1'];

            if ($mark > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_value_1`='$mark'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_MARK . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_goal`) AS `goal`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `goal` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $goal       = $player_array[0]['goal'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_player_id`='$player_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$goal'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordteam_value'];

            if ($goal > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_value_1`='$goal'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_SCORER . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_pass_scoring`) AS `pass`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `pass` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $pass       = $player_array[0]['pass'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_player_id`='$player_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$pass'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordteam_value'];

            if ($pass > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_value_1`='$pass'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_ASSISTANT . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT SUM(`statisticplayer_best`) AS `best`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_tournament_id`='$tournament_id'
                GROUP BY `statisticplayer_player_id`
                ORDER BY `best` DESC
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $player_array[0]['statisticplayer_player_id'];
        $best       = $player_array[0]['best'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_player_id`='$player_id',
                        `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$best'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

            $record_value = $record_array[0]['recordteam_value'];

            if ($best > $record_value)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_player_id`='$player_id',
                            `recordtournament_value_1`='$best'
                        WHERE `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_BEST . "'
                        AND `recordtournament_tournament_id`='$tournament_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_mood_after_game()
//Настроение игроков после матча
{
    global $mysqli;

    $sql = "UPDATE `game`
            LEFT JOIN `lineup`
            ON `lineup_team_id`=`game_home_team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            SET `player_mood_id`=IF(`game_home_score`>`game_guest_score`, `player_mood_id`+'1', IF(`game_home_score`<`game_guest_score`, `player_mood_id`-'1', `player_mood_id`))
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `lineup`
            ON `lineup_team_id`=`game_guest_team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            SET `player_mood_id`=IF(`game_home_score`<`game_guest_score`, `player_mood_id`+'1', IF(`game_home_score`>`game_guest_score`, `player_mood_id`-'1', `player_mood_id`))
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_mood_id`='1'
            WHERE `player_mood_id`<'1'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_mood_id`='7'
            WHERE `player_mood_id`>'7'";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_injury_after_game()
//Снятие травм у вылечившихся
{
    global $mysqli;

    $sql = "UPDATE `injury`
            LEFT JOIN `player`
            ON `injury_player_id`=`player_id`
            SET `player_injury`='0'
            WHERE `injury_end_date`<=CURDATE()";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_make_played()
//Делаем матчи сыграными
{
    global $mysqli;

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_played`='1'
            WHERE `shedule_date`=CURDATE()";
    $mysqli->query($sql);

    usleep(1);

    print '.';
    flush();
}

function f_igosja_generator_training()
//Тренировка игроков
{
    global $mysqli;

    $sql = "SELECT `player_id`,
                   `player_power`,
                   `player_training_attribute_id`,
                   `playerattribute_value`,
                   `staff_reputation`,
                   `team_training_level`
            FROM `player`
            LEFT JOIN `team`
            ON `team_id`=`player_team_id`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            LEFT JOIN `playerposition`
            ON `playerposition_player_id`=`player_id`
            LEFT JOIN `playerattribute`
            ON (`playerattribute_attribute_id`=`player_training_attribute_id`
            AND `playerattribute_player_id`=`player_id`)
            LEFT JOIN
            (
                SELECT SUM(`playerattribute_value`) AS `player_power`, `playerattribute_player_id` AS `attribute_player_id`
                FROM `playerattribute`
                LEFT JOIN `attribute`
                ON `playerattribute_attribute_id`=`attribute_id`
                WHERE `attribute_attributechapter_id`!='3'
                GROUP BY `playerattribute_player_id`
            ) AS `t1`
            ON `attribute_player_id`=`player_id`
            WHERE `player_team_id`!='0'
            AND `playerposition_position_id`!='1'
            AND `playerposition_value`='100'
            AND `staff_staffpost_id`='1'
            AND `player_age`<'30'
            ORDER BY `player_id` ASC";
    $player_sql = $mysqli->query($sql);

    $count_player = $player_sql->num_rows;

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_player; $i++)
    {
        $player_id          = $player_array[$i]['player_id'];
        $player_power       = $player_array[$i]['player_power'];
        $training           = $player_array[$i]['team_training_level'];
        $coach              = $player_array[$i]['staff_reputation'];
        $attribute_value    = $player_array[$i]['playerattribute_value'];
        $attribute_id       = $player_array[$i]['player_training_attribute_id'];

        if ($player_power < MAX_TRAINING_PLAYER_POWER / 2 + MAX_TRAINING_PLAYER_POWER * $training * $coach / 10000)
        {
            if ($attribute_value < MAX_ATTRIBUTE_VALUE &&
                0 < $attribute_id)
            {
                $sql = "UPDATE `playerattribute`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `playerattribute_attribute_id`='$attribute_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `playerattribute`
                        LEFT JOIN `attribute`
                        ON `attribute_id`=`playerattribute_attribute_id`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `attribute_attributechapter_id`!='3'
                        AND `playerattribute_value`<'" . MAX_ATTRIBUTE_VALUE . "'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }

    $sql = "SELECT `player_id`,
                   `player_power`,
                   `player_training_attribute_id`,
                   `playerattribute_value`,
                   `staff_reputation`,
                   `team_training_level`
            FROM `player`
            LEFT JOIN `team`
            ON `team_id`=`player_team_id`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            LEFT JOIN `playerposition`
            ON `playerposition_player_id`=`player_id`
            LEFT JOIN `playerattribute`
            ON (`playerattribute_attribute_id`=`player_training_attribute_id`
            AND `playerattribute_player_id`=`player_id`)
            LEFT JOIN
            (
                SELECT SUM(`playerattribute_value`) AS `player_power`, `playerattribute_player_id` AS `attribute_player_id`
                FROM `playerattribute`
                LEFT JOIN `attribute`
                ON `playerattribute_attribute_id`=`attribute_id`
                WHERE `attribute_attributechapter_id`!='3'
                GROUP BY `playerattribute_player_id`
            ) AS `t1`
            ON `attribute_player_id`=`player_id`
            WHERE `player_team_id`!='0'
            AND `playerposition_position_id`='1'
            AND `playerposition_value`='100'
            AND `staff_staffpost_id`='1'
            AND `player_age`<'30'
            ORDER BY `player_id` ASC";
    $player_sql = $mysqli->query($sql);

    $count_player = $player_sql->num_rows;

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_player; $i++)
    {
        $player_id          = $player_array[$i]['player_id'];
        $player_power       = $player_array[$i]['player_power'];
        $training           = $player_array[$i]['team_training_level'];
        $coach              = $player_array[$i]['staff_reputation'];
        $attribute_value    = $player_array[$i]['playerattribute_value'];
        $attribute_id       = $player_array[$i]['player_training_attribute_id'];

        if ($player_power < MAX_TRAINING_PLAYER_POWER / 2 + MAX_TRAINING_PLAYER_POWER * $training * $coach / 10000)
        {
            if ($attribute_value < MAX_ATTRIBUTE_VALUE &&
                0 < $attribute_id)
            {
                $sql = "UPDATE `playerattribute`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `playerattribute_attribute_id`='$attribute_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `playerattribute`
                        LEFT JOIN `attribute`
                        ON `attribute_id`=`playerattribute_attribute_id`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `attribute_attributechapter_id`!='3'
                        AND `playerattribute_value`<'" . MAX_ATTRIBUTE_VALUE . "'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }

    $sql = "SELECT `player_id`,
                   `player_power`,
                   `player_training_attribute_id`,
                   `playerattribute_value`,
                   `staff_reputation`,
                   `team_training_level`
            FROM `player`
            LEFT JOIN `team`
            ON `team_id`=`player_team_id`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            LEFT JOIN `playerposition`
            ON `playerposition_player_id`=`player_id`
            LEFT JOIN `playerattribute`
            ON (`playerattribute_attribute_id`=`player_training_attribute_id`
            AND `playerattribute_player_id`=`player_id`)
            LEFT JOIN
            (
                SELECT SUM(`playerattribute_value`) AS `player_power`, `playerattribute_player_id` AS `attribute_player_id`
                FROM `playerattribute`
                LEFT JOIN `attribute`
                ON `playerattribute_attribute_id`=`attribute_id`
                WHERE `attribute_attributechapter_id`!='3'
                GROUP BY `playerattribute_player_id`
            ) AS `t1`
            ON `attribute_player_id`=`player_id`
            WHERE `player_team_id`!='0'
            AND `playerposition_position_id`='1'
            AND `playerposition_value`='100'
            AND `staff_staffpost_id`='1'
            AND `player_age`<'30'
            ORDER BY `player_id` ASC";
    $player_sql = $mysqli->query($sql);

    $count_player = $player_sql->num_rows;

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_player; $i++)
    {
        $player_id          = $player_array[$i]['player_id'];
        $player_power       = $player_array[$i]['player_power'];
        $training           = $player_array[$i]['team_training_level'];
        $coach              = $player_array[$i]['staff_reputation'];
        $attribute_value    = $player_array[$i]['playerattribute_value'];
        $attribute_id       = $player_array[$i]['player_training_attribute_id'];

        if ($player_power < MAX_TRAINING_PLAYER_POWER / 2 + MAX_TRAINING_PLAYER_POWER * $training * $coach / 10000)
        {
            if ($attribute_value < MAX_ATTRIBUTE_VALUE &&
                0 < $attribute_id)
            {
                $sql = "UPDATE `playerattribute`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `playerattribute_attribute_id`='$attribute_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `playerattribute`
                        LEFT JOIN `attribute`
                        ON `attribute_id`=`playerattribute_attribute_id`
                        SET `playerattribute_value`=`playerattribute_value`+'1'
                        WHERE `playerattribute_player_id`='$player_id'
                        AND `attribute_attributechapter_id`!='3'
                        AND `playerattribute_value`<'" . MAX_ATTRIBUTE_VALUE . "'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }

    $sql = "UPDATE `playerattribute`
            LEFT JOIN `player`
            ON `player_id`=`playerattribute_player_id`
            SET `playerattribute_value`=`playerattribute_value`+'1'
            WHERE `player_team_id`!='0'
            AND `playerattribute_value`<'100'
            AND `playerattribute_attribute_id`=
            (
                SELECT `attribute_id`
                FROM `attribute`
                WHERE `attribute_attributechapter_id`='3'
                ORDER BY RAND()
                LIMIT 1
            )";
    $mysqli->query($sql);

    $sql = "UPDATE `playerattribute`
            LEFT JOIN `player`
            ON `player_id`=`playerattribute_player_id`
            SET `playerattribute_value`=`playerattribute_value`-'1'
            WHERE `player_team_id`!='0'
            AND `player_age`>='30'
            AND `playerattribute_value`>'10'
            AND `playerattribute_attribute_id`=
            (
                SELECT `attribute_id`
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!='3'
                ORDER BY RAND()
                LIMIT 1
            )";
    $mysqli->query($sql);
}



