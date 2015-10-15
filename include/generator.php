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

function f_igosja_generator_lineup_current_fill_auto()
//Заполняем автосоставы
{
    global $mysqli;

    $today = date('Y-m-d');

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_auto`='0'";
    $mysqli->query($sql);

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `guestuser`.`user_last_visit` AS `guest_last_visit`,
                   `guestuser`.`user_id` AS `guest_user_id`,
                   `homeuser`.`user_last_visit` AS `home_last_visit`,
                   `homeuser`.`user_id` AS `home_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `hometeam`
            ON `hometeam`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guestteam`
            ON `guestteam`.`team_id`=`game_guest_team_id`
            LEFT JOIN `user` AS `homeuser`
            ON `hometeam`.`team_user_id`=`homeuser`.`user_id`
            LEFT JOIN `user` AS `guestuser`
            ON `guestteam`.`team_user_id`=`guestuser`.`user_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_user_id       = $game_array[$i]['home_user_id'];
        $guest_user_id      = $game_array[$i]['guest_user_id'];
        $home_last_visit    = strtotime($today) - strtotime($game_array[$i]['home_last_visit']);
        $guest_last_visit   = strtotime($today) - strtotime($game_array[$i]['guest_last_visit']);

        if (0 == $home_user_id ||
            604800 < $home_last_visit) //604800 = 7*24*60*60
        {
            $home_team_id = $game_array[$i]['game_home_team_id'];

            $sql = "UPDATE `lineupcurrent`
                    SET `lineupcurrent_auto`='1',
                        `lineupcurrent_formation_id`='19',
                        `lineupcurrent_gamemood_id`='4',
                        `lineupcurrent_gamestyle_id`='3',
                        `lineupcurrent_player_id_1`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='1'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_2`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='3'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_3`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_4`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_5`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='7'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_6`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='13'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_7`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='15'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_8`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='15'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_9`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='17'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_10`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_11`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_12`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='1'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_13`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='3'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_14`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 2, 1
                        ),
                        `lineupcurrent_player_id_15`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='7'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_16`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='13'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_17`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='17'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_18`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$home_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            AND `player_injury`='0'
                            AND `player_rent_team_id`='0'
                            ORDER BY `player_condition` DESC
                            LIMIT 2, 1
                        ),
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
                    WHERE `lineupcurrent_team_id`='$home_team_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        if (0 == $guest_user_id ||
            604800 < $guest_last_visit) //7*24*60*60
        {
            $guest_team_id = $game_array[$i]['game_guest_team_id'];

            $sql = "UPDATE `lineupcurrent`
                    SET `lineupcurrent_auto`='1',
                        `lineupcurrent_formation_id`='19',
                        `lineupcurrent_gamemood_id`='4',
                        `lineupcurrent_gamestyle_id`='3',
                        `lineupcurrent_player_id_1`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='1'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_2`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='3'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_3`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_4`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_5`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='7'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_6`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='13'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_7`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='15'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_8`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='15'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_9`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='17'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_10`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            ORDER BY `player_condition` DESC
                            LIMIT 1
                        ),
                        `lineupcurrent_player_id_11`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_12`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='1'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_13`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='3'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_14`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='5'
                            ORDER BY `player_condition` DESC
                            LIMIT 2, 1
                        ),
                        `lineupcurrent_player_id_15`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='7'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_16`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='13'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_17`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='17'
                            ORDER BY `player_condition` DESC
                            LIMIT 1, 1
                        ),
                        `lineupcurrent_player_id_18`=
                        (
                            SELECT `player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            WHERE `player_team_id`='$guest_team_id'
                            AND `playerposition_value`='100'
                            AND `playerposition_position_id`='24'
                            ORDER BY `player_condition` DESC
                            LIMIT 2, 1
                        ),
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
                    WHERE `lineupcurrent_team_id`='$guest_team_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
    }
}

function f_igosja_generator_lineup_current_clean()
//Удаляем травмированных, проданных, арендованных
{
    global $mysqli;

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `guest_player_1`.`player_injury` AS `guest_player_injury_1`,
                   `guest_player_2`.`player_injury` AS `guest_player_injury_2`,
                   `guest_player_3`.`player_injury` AS `guest_player_injury_3`,
                   `guest_player_4`.`player_injury` AS `guest_player_injury_4`,
                   `guest_player_5`.`player_injury` AS `guest_player_injury_5`,
                   `guest_player_6`.`player_injury` AS `guest_player_injury_6`,
                   `guest_player_7`.`player_injury` AS `guest_player_injury_7`,
                   `guest_player_8`.`player_injury` AS `guest_player_injury_8`,
                   `guest_player_9`.`player_injury` AS `guest_player_injury_9`,
                   `guest_player_10`.`player_injury` AS `guest_player_injury_10`,
                   `guest_player_11`.`player_injury` AS `guest_player_injury_11`,
                   `guest_player_12`.`player_injury` AS `guest_player_injury_12`,
                   `guest_player_13`.`player_injury` AS `guest_player_injury_13`,
                   `guest_player_14`.`player_injury` AS `guest_player_injury_14`,
                   `guest_player_15`.`player_injury` AS `guest_player_injury_15`,
                   `guest_player_16`.`player_injury` AS `guest_player_injury_16`,
                   `guest_player_17`.`player_injury` AS `guest_player_injury_17`,
                   `guest_player_18`.`player_injury` AS `guest_player_injury_18`,
                   `guest_player_1`.`player_rent_team_id` AS `guest_player_rent_team_id_1`,
                   `guest_player_2`.`player_rent_team_id` AS `guest_player_rent_team_id_2`,
                   `guest_player_3`.`player_rent_team_id` AS `guest_player_rent_team_id_3`,
                   `guest_player_4`.`player_rent_team_id` AS `guest_player_rent_team_id_4`,
                   `guest_player_5`.`player_rent_team_id` AS `guest_player_rent_team_id_5`,
                   `guest_player_6`.`player_rent_team_id` AS `guest_player_rent_team_id_6`,
                   `guest_player_7`.`player_rent_team_id` AS `guest_player_rent_team_id_7`,
                   `guest_player_8`.`player_rent_team_id` AS `guest_player_rent_team_id_8`,
                   `guest_player_9`.`player_rent_team_id` AS `guest_player_rent_team_id_9`,
                   `guest_player_10`.`player_rent_team_id` AS `guest_player_rent_team_id_10`,
                   `guest_player_11`.`player_rent_team_id` AS `guest_player_rent_team_id_11`,
                   `guest_player_12`.`player_rent_team_id` AS `guest_player_rent_team_id_12`,
                   `guest_player_13`.`player_rent_team_id` AS `guest_player_rent_team_id_13`,
                   `guest_player_14`.`player_rent_team_id` AS `guest_player_rent_team_id_14`,
                   `guest_player_15`.`player_rent_team_id` AS `guest_player_rent_team_id_15`,
                   `guest_player_16`.`player_rent_team_id` AS `guest_player_rent_team_id_16`,
                   `guest_player_17`.`player_rent_team_id` AS `guest_player_rent_team_id_17`,
                   `guest_player_18`.`player_rent_team_id` AS `guest_player_rent_team_id_18`,
                   `guest_player_1`.`player_team_id` AS `guest_player_team_id_1`,
                   `guest_player_2`.`player_team_id` AS `guest_player_team_id_2`,
                   `guest_player_3`.`player_team_id` AS `guest_player_team_id_3`,
                   `guest_player_4`.`player_team_id` AS `guest_player_team_id_4`,
                   `guest_player_5`.`player_team_id` AS `guest_player_team_id_5`,
                   `guest_player_6`.`player_team_id` AS `guest_player_team_id_6`,
                   `guest_player_7`.`player_team_id` AS `guest_player_team_id_7`,
                   `guest_player_8`.`player_team_id` AS `guest_player_team_id_8`,
                   `guest_player_9`.`player_team_id` AS `guest_player_team_id_9`,
                   `guest_player_10`.`player_team_id` AS `guest_player_team_id_10`,
                   `guest_player_11`.`player_team_id` AS `guest_player_team_id_11`,
                   `guest_player_12`.`player_team_id` AS `guest_player_team_id_12`,
                   `guest_player_13`.`player_team_id` AS `guest_player_team_id_13`,
                   `guest_player_14`.`player_team_id` AS `guest_player_team_id_14`,
                   `guest_player_15`.`player_team_id` AS `guest_player_team_id_15`,
                   `guest_player_16`.`player_team_id` AS `guest_player_team_id_16`,
                   `guest_player_17`.`player_team_id` AS `guest_player_team_id_17`,
                   `guest_player_18`.`player_team_id` AS `guest_player_team_id_18`,
                   `home_player_1`.`player_injury` AS `home_player_injury_1`,
                   `home_player_2`.`player_injury` AS `home_player_injury_2`,
                   `home_player_3`.`player_injury` AS `home_player_injury_3`,
                   `home_player_4`.`player_injury` AS `home_player_injury_4`,
                   `home_player_5`.`player_injury` AS `home_player_injury_5`,
                   `home_player_6`.`player_injury` AS `home_player_injury_6`,
                   `home_player_7`.`player_injury` AS `home_player_injury_7`,
                   `home_player_8`.`player_injury` AS `home_player_injury_8`,
                   `home_player_9`.`player_injury` AS `home_player_injury_9`,
                   `home_player_10`.`player_injury` AS `home_player_injury_10`,
                   `home_player_11`.`player_injury` AS `home_player_injury_11`,
                   `home_player_12`.`player_injury` AS `home_player_injury_12`,
                   `home_player_13`.`player_injury` AS `home_player_injury_13`,
                   `home_player_14`.`player_injury` AS `home_player_injury_14`,
                   `home_player_15`.`player_injury` AS `home_player_injury_15`,
                   `home_player_16`.`player_injury` AS `home_player_injury_16`,
                   `home_player_17`.`player_injury` AS `home_player_injury_17`,
                   `home_player_18`.`player_injury` AS `home_player_injury_18`,
                   `home_player_1`.`player_rent_team_id` AS `home_player_rent_team_id_1`,
                   `home_player_2`.`player_rent_team_id` AS `home_player_rent_team_id_2`,
                   `home_player_3`.`player_rent_team_id` AS `home_player_rent_team_id_3`,
                   `home_player_4`.`player_rent_team_id` AS `home_player_rent_team_id_4`,
                   `home_player_5`.`player_rent_team_id` AS `home_player_rent_team_id_5`,
                   `home_player_6`.`player_rent_team_id` AS `home_player_rent_team_id_6`,
                   `home_player_7`.`player_rent_team_id` AS `home_player_rent_team_id_7`,
                   `home_player_8`.`player_rent_team_id` AS `home_player_rent_team_id_8`,
                   `home_player_9`.`player_rent_team_id` AS `home_player_rent_team_id_9`,
                   `home_player_10`.`player_rent_team_id` AS `home_player_rent_team_id_10`,
                   `home_player_11`.`player_rent_team_id` AS `home_player_rent_team_id_11`,
                   `home_player_12`.`player_rent_team_id` AS `home_player_rent_team_id_12`,
                   `home_player_13`.`player_rent_team_id` AS `home_player_rent_team_id_13`,
                   `home_player_14`.`player_rent_team_id` AS `home_player_rent_team_id_14`,
                   `home_player_15`.`player_rent_team_id` AS `home_player_rent_team_id_15`,
                   `home_player_16`.`player_rent_team_id` AS `home_player_rent_team_id_16`,
                   `home_player_17`.`player_rent_team_id` AS `home_player_rent_team_id_17`,
                   `home_player_18`.`player_rent_team_id` AS `home_player_rent_team_id_18`,
                   `home_player_1`.`player_team_id` AS `home_player_team_id_1`,
                   `home_player_2`.`player_team_id` AS `home_player_team_id_2`,
                   `home_player_3`.`player_team_id` AS `home_player_team_id_3`,
                   `home_player_4`.`player_team_id` AS `home_player_team_id_4`,
                   `home_player_5`.`player_team_id` AS `home_player_team_id_5`,
                   `home_player_6`.`player_team_id` AS `home_player_team_id_6`,
                   `home_player_7`.`player_team_id` AS `home_player_team_id_7`,
                   `home_player_8`.`player_team_id` AS `home_player_team_id_8`,
                   `home_player_9`.`player_team_id` AS `home_player_team_id_9`,
                   `home_player_10`.`player_team_id` AS `home_player_team_id_10`,
                   `home_player_11`.`player_team_id` AS `home_player_team_id_11`,
                   `home_player_12`.`player_team_id` AS `home_player_team_id_12`,
                   `home_player_13`.`player_team_id` AS `home_player_team_id_13`,
                   `home_player_14`.`player_team_id` AS `home_player_team_id_14`,
                   `home_player_15`.`player_team_id` AS `home_player_team_id_15`,
                   `home_player_16`.`player_team_id` AS `home_player_team_id_16`,
                   `home_player_17`.`player_team_id` AS `home_player_team_id_17`,
                   `home_player_18`.`player_team_id` AS `home_player_team_id_18`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineupcurrent` AS `homelineup`
            ON `homelineup`.`lineupcurrent_team_id`=`game_home_team_id`
            LEFT JOIN `player` AS `home_player_1`
            ON `home_player_1`.`player_id`=`homelineup`.`lineupcurrent_player_id_1`
            LEFT JOIN `player` AS `home_player_2`
            ON `home_player_2`.`player_id`=`homelineup`.`lineupcurrent_player_id_2`
            LEFT JOIN `player` AS `home_player_3`
            ON `home_player_3`.`player_id`=`homelineup`.`lineupcurrent_player_id_3`
            LEFT JOIN `player` AS `home_player_4`
            ON `home_player_4`.`player_id`=`homelineup`.`lineupcurrent_player_id_4`
            LEFT JOIN `player` AS `home_player_5`
            ON `home_player_5`.`player_id`=`homelineup`.`lineupcurrent_player_id_5`
            LEFT JOIN `player` AS `home_player_6`
            ON `home_player_6`.`player_id`=`homelineup`.`lineupcurrent_player_id_6`
            LEFT JOIN `player` AS `home_player_7`
            ON `home_player_7`.`player_id`=`homelineup`.`lineupcurrent_player_id_7`
            LEFT JOIN `player` AS `home_player_8`
            ON `home_player_8`.`player_id`=`homelineup`.`lineupcurrent_player_id_8`
            LEFT JOIN `player` AS `home_player_9`
            ON `home_player_9`.`player_id`=`homelineup`.`lineupcurrent_player_id_9`
            LEFT JOIN `player` AS `home_player_10`
            ON `home_player_10`.`player_id`=`homelineup`.`lineupcurrent_player_id_10`
            LEFT JOIN `player` AS `home_player_11`
            ON `home_player_11`.`player_id`=`homelineup`.`lineupcurrent_player_id_11`
            LEFT JOIN `player` AS `home_player_12`
            ON `home_player_12`.`player_id`=`homelineup`.`lineupcurrent_player_id_12`
            LEFT JOIN `player` AS `home_player_13`
            ON `home_player_13`.`player_id`=`homelineup`.`lineupcurrent_player_id_13`
            LEFT JOIN `player` AS `home_player_14`
            ON `home_player_14`.`player_id`=`homelineup`.`lineupcurrent_player_id_14`
            LEFT JOIN `player` AS `home_player_15`
            ON `home_player_15`.`player_id`=`homelineup`.`lineupcurrent_player_id_15`
            LEFT JOIN `player` AS `home_player_16`
            ON `home_player_16`.`player_id`=`homelineup`.`lineupcurrent_player_id_16`
            LEFT JOIN `player` AS `home_player_17`
            ON `home_player_17`.`player_id`=`homelineup`.`lineupcurrent_player_id_17`
            LEFT JOIN `player` AS `home_player_18`
            ON `home_player_18`.`player_id`=`homelineup`.`lineupcurrent_player_id_18`
            LEFT JOIN `lineupcurrent` AS `guestlineup`
            ON `guestlineup`.`lineupcurrent_team_id`=`game_guest_team_id`
            LEFT JOIN `player` AS `guest_player_1`
            ON `guest_player_1`.`player_id`=`guestlineup`.`lineupcurrent_player_id_1`
            LEFT JOIN `player` AS `guest_player_2`
            ON `guest_player_2`.`player_id`=`guestlineup`.`lineupcurrent_player_id_2`
            LEFT JOIN `player` AS `guest_player_3`
            ON `guest_player_3`.`player_id`=`guestlineup`.`lineupcurrent_player_id_3`
            LEFT JOIN `player` AS `guest_player_4`
            ON `guest_player_4`.`player_id`=`guestlineup`.`lineupcurrent_player_id_4`
            LEFT JOIN `player` AS `guest_player_5`
            ON `guest_player_5`.`player_id`=`guestlineup`.`lineupcurrent_player_id_5`
            LEFT JOIN `player` AS `guest_player_6`
            ON `guest_player_6`.`player_id`=`guestlineup`.`lineupcurrent_player_id_6`
            LEFT JOIN `player` AS `guest_player_7`
            ON `guest_player_7`.`player_id`=`guestlineup`.`lineupcurrent_player_id_7`
            LEFT JOIN `player` AS `guest_player_8`
            ON `guest_player_8`.`player_id`=`guestlineup`.`lineupcurrent_player_id_8`
            LEFT JOIN `player` AS `guest_player_9`
            ON `guest_player_9`.`player_id`=`guestlineup`.`lineupcurrent_player_id_9`
            LEFT JOIN `player` AS `guest_player_10`
            ON `guest_player_10`.`player_id`=`guestlineup`.`lineupcurrent_player_id_10`
            LEFT JOIN `player` AS `guest_player_11`
            ON `guest_player_11`.`player_id`=`guestlineup`.`lineupcurrent_player_id_11`
            LEFT JOIN `player` AS `guest_player_12`
            ON `guest_player_12`.`player_id`=`guestlineup`.`lineupcurrent_player_id_12`
            LEFT JOIN `player` AS `guest_player_13`
            ON `guest_player_13`.`player_id`=`guestlineup`.`lineupcurrent_player_id_13`
            LEFT JOIN `player` AS `guest_player_14`
            ON `guest_player_14`.`player_id`=`guestlineup`.`lineupcurrent_player_id_14`
            LEFT JOIN `player` AS `guest_player_15`
            ON `guest_player_15`.`player_id`=`guestlineup`.`lineupcurrent_player_id_15`
            LEFT JOIN `player` AS `guest_player_16`
            ON `guest_player_16`.`player_id`=`guestlineup`.`lineupcurrent_player_id_16`
            LEFT JOIN `player` AS `guest_player_17`
            ON `guest_player_17`.`player_id`=`guestlineup`.`lineupcurrent_player_id_17`
            LEFT JOIN `player` AS `guest_player_18`
            ON `guest_player_18`.`player_id`=`guestlineup`.`lineupcurrent_player_id_18`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];

        for ($j=1; $j<=18; $j++)
        {
            $home_player_injury_sql = 'home_player_injury_' . $j;
            $home_player_injury     = $game_array[$i][$home_player_injury_sql];
            $home_player_team_sql   = 'home_player_team_id_' . $j;
            $home_player_team_id    = $game_array[$i][$home_player_team_sql];
            $home_player_rent_sql   = 'home_player_rent_team_id_' . $j;
            $home_player_rent_id    = $game_array[$i][$home_player_rent_sql];

            if (0 < $home_player_injury ||
               (0 != $home_player_rent_id &&
                $home_team_id != $home_player_rent_id) ||
               (0 == $home_player_rent_id &&
                $home_team_id != $home_player_team_id))
            {
                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_player_id_" . $j . "`='0'
                        WHERE `lineupcurrent_team_id`='$home_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $guest_player_injury_sql = 'guest_player_injury_' . $j;
            $guest_player_injury     = $game_array[$i][$guest_player_injury_sql];
            $guest_player_team_sql   = 'guest_player_team_id_' . $j;
            $guest_player_team_id     = $game_array[$i][$guest_player_team_sql];
            $guest_player_rent_sql   = 'guest_player_rent_team_id_' . $j;
            $guest_player_rent_id     = $game_array[$i][$guest_player_rent_sql];

            if (0 < $guest_player_injury ||
               (0 != $guest_player_rent_id &&
                $guest_team_id != $guest_player_rent_id) ||
               (0 == $guest_player_rent_id &&
                $guest_team_id != $guest_player_team_id))
            {
                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_player_id_" . $j . "`='0'
                        WHERE `lineupcurrent_team_id`='$guest_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }
}

function f_igosja_generator_lineup_current_check()
//Проверяем финально составы
{
    global $mysqli;

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `guestlineup`.`lineupcurrent_formation_id` AS `guest_formation_id`,
                   `guestlineup`.`lineupcurrent_gamemood_id` AS `guest_gamemood_id`,
                   `guestlineup`.`lineupcurrent_gamestyle_id` AS `guest_gamestyle_id`,
                   `guestlineup`.`lineupcurrent_player_id_1` AS `guest_player_id_1`,
                   `guestlineup`.`lineupcurrent_player_id_2` AS `guest_player_id_2`,
                   `guestlineup`.`lineupcurrent_player_id_3` AS `guest_player_id_3`,
                   `guestlineup`.`lineupcurrent_player_id_4` AS `guest_player_id_4`,
                   `guestlineup`.`lineupcurrent_player_id_5` AS `guest_player_id_5`,
                   `guestlineup`.`lineupcurrent_player_id_6` AS `guest_player_id_6`,
                   `guestlineup`.`lineupcurrent_player_id_7` AS `guest_player_id_7`,
                   `guestlineup`.`lineupcurrent_player_id_8` AS `guest_player_id_8`,
                   `guestlineup`.`lineupcurrent_player_id_9` AS `guest_player_id_9`,
                   `guestlineup`.`lineupcurrent_player_id_10` AS `guest_player_id_10`,
                   `guestlineup`.`lineupcurrent_player_id_11` AS `guest_player_id_11`,
                   `guestlineup`.`lineupcurrent_player_id_12` AS `guest_player_id_12`,
                   `guestlineup`.`lineupcurrent_player_id_13` AS `guest_player_id_13`,
                   `guestlineup`.`lineupcurrent_player_id_14` AS `guest_player_id_14`,
                   `guestlineup`.`lineupcurrent_player_id_15` AS `guest_player_id_15`,
                   `guestlineup`.`lineupcurrent_player_id_16` AS `guest_player_id_16`,
                   `guestlineup`.`lineupcurrent_player_id_17` AS `guest_player_id_17`,
                   `guestlineup`.`lineupcurrent_player_id_18` AS `guest_player_id_18`,
                   `guest_player_1`.`player_team_id` AS `guest_player_team_id_1`,
                   `guest_player_2`.`player_team_id` AS `guest_player_team_id_2`,
                   `guest_player_3`.`player_team_id` AS `guest_player_team_id_3`,
                   `guest_player_4`.`player_team_id` AS `guest_player_team_id_4`,
                   `guest_player_5`.`player_team_id` AS `guest_player_team_id_5`,
                   `guest_player_6`.`player_team_id` AS `guest_player_team_id_6`,
                   `guest_player_7`.`player_team_id` AS `guest_player_team_id_7`,
                   `guest_player_8`.`player_team_id` AS `guest_player_team_id_8`,
                   `guest_player_9`.`player_team_id` AS `guest_player_team_id_9`,
                   `guest_player_10`.`player_team_id` AS `guest_player_team_id_10`,
                   `guest_player_11`.`player_team_id` AS `guest_player_team_id_11`,
                   `guest_player_12`.`player_team_id` AS `guest_player_team_id_12`,
                   `guest_player_13`.`player_team_id` AS `guest_player_team_id_13`,
                   `guest_player_14`.`player_team_id` AS `guest_player_team_id_14`,
                   `guest_player_15`.`player_team_id` AS `guest_player_team_id_15`,
                   `guest_player_16`.`player_team_id` AS `guest_player_team_id_16`,
                   `guest_player_17`.`player_team_id` AS `guest_player_team_id_17`,
                   `guest_player_18`.`player_team_id` AS `guest_player_team_id_18`,
                   `guestlineup`.`lineupcurrent_position_id_1` AS `guest_position_id_1`,
                   `guestlineup`.`lineupcurrent_position_id_2` AS `guest_position_id_2`,
                   `guestlineup`.`lineupcurrent_position_id_3` AS `guest_position_id_3`,
                   `guestlineup`.`lineupcurrent_position_id_4` AS `guest_position_id_4`,
                   `guestlineup`.`lineupcurrent_position_id_5` AS `guest_position_id_5`,
                   `guestlineup`.`lineupcurrent_position_id_6` AS `guest_position_id_6`,
                   `guestlineup`.`lineupcurrent_position_id_7` AS `guest_position_id_7`,
                   `guestlineup`.`lineupcurrent_position_id_8` AS `guest_position_id_8`,
                   `guestlineup`.`lineupcurrent_position_id_9` AS `guest_position_id_9`,
                   `guestlineup`.`lineupcurrent_position_id_10` AS `guest_position_id_10`,
                   `guestlineup`.`lineupcurrent_position_id_11` AS `guest_position_id_11`,
                   `guestlineup`.`lineupcurrent_position_id_12` AS `guest_position_id_12`,
                   `guestlineup`.`lineupcurrent_position_id_13` AS `guest_position_id_13`,
                   `guestlineup`.`lineupcurrent_position_id_14` AS `guest_position_id_14`,
                   `guestlineup`.`lineupcurrent_position_id_15` AS `guest_position_id_15`,
                   `guestlineup`.`lineupcurrent_position_id_16` AS `guest_position_id_16`,
                   `guestlineup`.`lineupcurrent_position_id_17` AS `guest_position_id_17`,
                   `guestlineup`.`lineupcurrent_position_id_18` AS `guest_position_id_18`,
                   `guestlineup`.`lineupcurrent_role_id_1` AS `guest_role_id_1`,
                   `guestlineup`.`lineupcurrent_role_id_2` AS `guest_role_id_2`,
                   `guestlineup`.`lineupcurrent_role_id_3` AS `guest_role_id_3`,
                   `guestlineup`.`lineupcurrent_role_id_4` AS `guest_role_id_4`,
                   `guestlineup`.`lineupcurrent_role_id_5` AS `guest_role_id_5`,
                   `guestlineup`.`lineupcurrent_role_id_6` AS `guest_role_id_6`,
                   `guestlineup`.`lineupcurrent_role_id_7` AS `guest_role_id_7`,
                   `guestlineup`.`lineupcurrent_role_id_8` AS `guest_role_id_8`,
                   `guestlineup`.`lineupcurrent_role_id_9` AS `guest_role_id_9`,
                   `guestlineup`.`lineupcurrent_role_id_10` AS `guest_role_id_10`,
                   `guestlineup`.`lineupcurrent_role_id_11` AS `guest_role_id_11`,
                   `homelineup`.`lineupcurrent_formation_id` AS `home_formation_id`,
                   `homelineup`.`lineupcurrent_gamemood_id` AS `home_gamemood_id`,
                   `homelineup`.`lineupcurrent_gamestyle_id` AS `home_gamestyle_id`,
                   `homelineup`.`lineupcurrent_player_id_1` AS `home_player_id_1`,
                   `homelineup`.`lineupcurrent_player_id_2` AS `home_player_id_2`,
                   `homelineup`.`lineupcurrent_player_id_3` AS `home_player_id_3`,
                   `homelineup`.`lineupcurrent_player_id_4` AS `home_player_id_4`,
                   `homelineup`.`lineupcurrent_player_id_5` AS `home_player_id_5`,
                   `homelineup`.`lineupcurrent_player_id_6` AS `home_player_id_6`,
                   `homelineup`.`lineupcurrent_player_id_7` AS `home_player_id_7`,
                   `homelineup`.`lineupcurrent_player_id_8` AS `home_player_id_8`,
                   `homelineup`.`lineupcurrent_player_id_9` AS `home_player_id_9`,
                   `homelineup`.`lineupcurrent_player_id_10` AS `home_player_id_10`,
                   `homelineup`.`lineupcurrent_player_id_11` AS `home_player_id_11`,
                   `homelineup`.`lineupcurrent_player_id_12` AS `home_player_id_12`,
                   `homelineup`.`lineupcurrent_player_id_13` AS `home_player_id_13`,
                   `homelineup`.`lineupcurrent_player_id_14` AS `home_player_id_14`,
                   `homelineup`.`lineupcurrent_player_id_15` AS `home_player_id_15`,
                   `homelineup`.`lineupcurrent_player_id_16` AS `home_player_id_16`,
                   `homelineup`.`lineupcurrent_player_id_17` AS `home_player_id_17`,
                   `homelineup`.`lineupcurrent_player_id_18` AS `home_player_id_18`,
                   `home_player_1`.`player_team_id` AS `home_player_team_id_1`,
                   `home_player_2`.`player_team_id` AS `home_player_team_id_2`,
                   `home_player_3`.`player_team_id` AS `home_player_team_id_3`,
                   `home_player_4`.`player_team_id` AS `home_player_team_id_4`,
                   `home_player_5`.`player_team_id` AS `home_player_team_id_5`,
                   `home_player_6`.`player_team_id` AS `home_player_team_id_6`,
                   `home_player_7`.`player_team_id` AS `home_player_team_id_7`,
                   `home_player_8`.`player_team_id` AS `home_player_team_id_8`,
                   `home_player_9`.`player_team_id` AS `home_player_team_id_9`,
                   `home_player_10`.`player_team_id` AS `home_player_team_id_10`,
                   `home_player_11`.`player_team_id` AS `home_player_team_id_11`,
                   `home_player_12`.`player_team_id` AS `home_player_team_id_12`,
                   `home_player_13`.`player_team_id` AS `home_player_team_id_13`,
                   `home_player_14`.`player_team_id` AS `home_player_team_id_14`,
                   `home_player_15`.`player_team_id` AS `home_player_team_id_15`,
                   `home_player_16`.`player_team_id` AS `home_player_team_id_16`,
                   `home_player_17`.`player_team_id` AS `home_player_team_id_17`,
                   `home_player_18`.`player_team_id` AS `home_player_team_id_18`,
                   `homelineup`.`lineupcurrent_position_id_1` AS `home_position_id_1`,
                   `homelineup`.`lineupcurrent_position_id_2` AS `home_position_id_2`,
                   `homelineup`.`lineupcurrent_position_id_3` AS `home_position_id_3`,
                   `homelineup`.`lineupcurrent_position_id_4` AS `home_position_id_4`,
                   `homelineup`.`lineupcurrent_position_id_5` AS `home_position_id_5`,
                   `homelineup`.`lineupcurrent_position_id_6` AS `home_position_id_6`,
                   `homelineup`.`lineupcurrent_position_id_7` AS `home_position_id_7`,
                   `homelineup`.`lineupcurrent_position_id_8` AS `home_position_id_8`,
                   `homelineup`.`lineupcurrent_position_id_9` AS `home_position_id_9`,
                   `homelineup`.`lineupcurrent_position_id_10` AS `home_position_id_10`,
                   `homelineup`.`lineupcurrent_position_id_11` AS `home_position_id_11`,
                   `homelineup`.`lineupcurrent_position_id_12` AS `home_position_id_12`,
                   `homelineup`.`lineupcurrent_position_id_13` AS `home_position_id_13`,
                   `homelineup`.`lineupcurrent_position_id_14` AS `home_position_id_14`,
                   `homelineup`.`lineupcurrent_position_id_15` AS `home_position_id_15`,
                   `homelineup`.`lineupcurrent_position_id_16` AS `home_position_id_16`,
                   `homelineup`.`lineupcurrent_position_id_17` AS `home_position_id_17`,
                   `homelineup`.`lineupcurrent_position_id_18` AS `home_position_id_18`,
                   `homelineup`.`lineupcurrent_role_id_1` AS `home_role_id_1`,
                   `homelineup`.`lineupcurrent_role_id_2` AS `home_role_id_2`,
                   `homelineup`.`lineupcurrent_role_id_3` AS `home_role_id_3`,
                   `homelineup`.`lineupcurrent_role_id_4` AS `home_role_id_4`,
                   `homelineup`.`lineupcurrent_role_id_5` AS `home_role_id_5`,
                   `homelineup`.`lineupcurrent_role_id_6` AS `home_role_id_6`,
                   `homelineup`.`lineupcurrent_role_id_7` AS `home_role_id_7`,
                   `homelineup`.`lineupcurrent_role_id_8` AS `home_role_id_8`,
                   `homelineup`.`lineupcurrent_role_id_9` AS `home_role_id_9`,
                   `homelineup`.`lineupcurrent_role_id_10` AS `home_role_id_10`,
                   `homelineup`.`lineupcurrent_role_id_11` AS `home_role_id_11`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineupcurrent` AS `homelineup`
            ON `homelineup`.`lineupcurrent_team_id`=`game_home_team_id`
            LEFT JOIN `player` AS `home_player_1`
            ON `home_player_1`.`player_id`=`homelineup`.`lineupcurrent_player_id_1`
            LEFT JOIN `player` AS `home_player_2`
            ON `home_player_2`.`player_id`=`homelineup`.`lineupcurrent_player_id_2`
            LEFT JOIN `player` AS `home_player_3`
            ON `home_player_3`.`player_id`=`homelineup`.`lineupcurrent_player_id_3`
            LEFT JOIN `player` AS `home_player_4`
            ON `home_player_4`.`player_id`=`homelineup`.`lineupcurrent_player_id_4`
            LEFT JOIN `player` AS `home_player_5`
            ON `home_player_5`.`player_id`=`homelineup`.`lineupcurrent_player_id_5`
            LEFT JOIN `player` AS `home_player_6`
            ON `home_player_6`.`player_id`=`homelineup`.`lineupcurrent_player_id_6`
            LEFT JOIN `player` AS `home_player_7`
            ON `home_player_7`.`player_id`=`homelineup`.`lineupcurrent_player_id_7`
            LEFT JOIN `player` AS `home_player_8`
            ON `home_player_8`.`player_id`=`homelineup`.`lineupcurrent_player_id_8`
            LEFT JOIN `player` AS `home_player_9`
            ON `home_player_9`.`player_id`=`homelineup`.`lineupcurrent_player_id_9`
            LEFT JOIN `player` AS `home_player_10`
            ON `home_player_10`.`player_id`=`homelineup`.`lineupcurrent_player_id_10`
            LEFT JOIN `player` AS `home_player_11`
            ON `home_player_11`.`player_id`=`homelineup`.`lineupcurrent_player_id_11`
            LEFT JOIN `player` AS `home_player_12`
            ON `home_player_12`.`player_id`=`homelineup`.`lineupcurrent_player_id_12`
            LEFT JOIN `player` AS `home_player_13`
            ON `home_player_13`.`player_id`=`homelineup`.`lineupcurrent_player_id_13`
            LEFT JOIN `player` AS `home_player_14`
            ON `home_player_14`.`player_id`=`homelineup`.`lineupcurrent_player_id_14`
            LEFT JOIN `player` AS `home_player_15`
            ON `home_player_15`.`player_id`=`homelineup`.`lineupcurrent_player_id_15`
            LEFT JOIN `player` AS `home_player_16`
            ON `home_player_16`.`player_id`=`homelineup`.`lineupcurrent_player_id_16`
            LEFT JOIN `player` AS `home_player_17`
            ON `home_player_17`.`player_id`=`homelineup`.`lineupcurrent_player_id_17`
            LEFT JOIN `player` AS `home_player_18`
            ON `home_player_18`.`player_id`=`homelineup`.`lineupcurrent_player_id_18`
            LEFT JOIN `lineupcurrent` AS `guestlineup`
            ON `guestlineup`.`lineupcurrent_team_id`=`game_guest_team_id`
            LEFT JOIN `player` AS `guest_player_1`
            ON `guest_player_1`.`player_id`=`guestlineup`.`lineupcurrent_player_id_1`
            LEFT JOIN `player` AS `guest_player_2`
            ON `guest_player_2`.`player_id`=`guestlineup`.`lineupcurrent_player_id_2`
            LEFT JOIN `player` AS `guest_player_3`
            ON `guest_player_3`.`player_id`=`guestlineup`.`lineupcurrent_player_id_3`
            LEFT JOIN `player` AS `guest_player_4`
            ON `guest_player_4`.`player_id`=`guestlineup`.`lineupcurrent_player_id_4`
            LEFT JOIN `player` AS `guest_player_5`
            ON `guest_player_5`.`player_id`=`guestlineup`.`lineupcurrent_player_id_5`
            LEFT JOIN `player` AS `guest_player_6`
            ON `guest_player_6`.`player_id`=`guestlineup`.`lineupcurrent_player_id_6`
            LEFT JOIN `player` AS `guest_player_7`
            ON `guest_player_7`.`player_id`=`guestlineup`.`lineupcurrent_player_id_7`
            LEFT JOIN `player` AS `guest_player_8`
            ON `guest_player_8`.`player_id`=`guestlineup`.`lineupcurrent_player_id_8`
            LEFT JOIN `player` AS `guest_player_9`
            ON `guest_player_9`.`player_id`=`guestlineup`.`lineupcurrent_player_id_9`
            LEFT JOIN `player` AS `guest_player_10`
            ON `guest_player_10`.`player_id`=`guestlineup`.`lineupcurrent_player_id_10`
            LEFT JOIN `player` AS `guest_player_11`
            ON `guest_player_11`.`player_id`=`guestlineup`.`lineupcurrent_player_id_11`
            LEFT JOIN `player` AS `guest_player_12`
            ON `guest_player_12`.`player_id`=`guestlineup`.`lineupcurrent_player_id_12`
            LEFT JOIN `player` AS `guest_player_13`
            ON `guest_player_13`.`player_id`=`guestlineup`.`lineupcurrent_player_id_13`
            LEFT JOIN `player` AS `guest_player_14`
            ON `guest_player_14`.`player_id`=`guestlineup`.`lineupcurrent_player_id_14`
            LEFT JOIN `player` AS `guest_player_15`
            ON `guest_player_15`.`player_id`=`guestlineup`.`lineupcurrent_player_id_15`
            LEFT JOIN `player` AS `guest_player_16`
            ON `guest_player_16`.`player_id`=`guestlineup`.`lineupcurrent_player_id_16`
            LEFT JOIN `player` AS `guest_player_17`
            ON `guest_player_17`.`player_id`=`guestlineup`.`lineupcurrent_player_id_17`
            LEFT JOIN `player` AS `guest_player_18`
            ON `guest_player_18`.`player_id`=`guestlineup`.`lineupcurrent_player_id_18`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $home_update_sql    = 0;
        $home_formation_id  = $game_array[$i]['home_formation_id'];

        if (0 == $home_formation_id)
        {
            $home_formation_id = FOUR_FOUR_TWO_FORMATION;
            $home_update_sql   = 1;
        }

        $home_gamemood_id = $game_array[$i]['home_gamemood_id'];

        if (0 == $home_gamemood_id)
        {
            $home_gamemood_id = NORMAL_GAMEMOOD;
            $home_update_sql  = 1;
        }

        $home_gamestyle_id = $game_array[$i]['home_gamestyle_id'];

        if (0 == $home_gamestyle_id)
        {
            $home_gamestyle_id = NORMAL_GAMESTYLE;
            $home_update_sql   = 1;
        }

        if (1 == $home_update_sql)
        {
            $sql = "UPDATE `lineupcurrent`
                    SET `lineupcurrent_formation_id`='$home_formation_id',
                        `lineupcurrent_gamemood_id`='$home_gamemood_id',
                        `lineupcurrent_gamestyle_id`='$home_gamestyle_id'
                    WHERE `lineupcurrent_team_id`='$home_team_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $guest_update_sql   = 0;
        $guest_formation_id = $game_array[$i]['guest_formation_id'];

        if (0 == $guest_formation_id)
        {
            $guest_formation_id = FOUR_FOUR_TWO_FORMATION;
            $guest_update_sql   = 1;
        }

        $guest_gamemood_id = $game_array[$i]['guest_gamemood_id'];

        if (0 == $guest_gamemood_id)
        {
            $guest_gamemood_id = NORMAL_GAMEMOOD;
            $guest_update_sql  = 1;
        }

        $guest_gamestyle_id = $game_array[$i]['guest_gamestyle_id'];

        if (0 == $guest_gamestyle_id)
        {
            $guest_gamestyle_id = NORMAL_GAMESTYLE;
            $guest_update_sql   = 1;
        }

        if (1 == $guest_update_sql)
        {
            $sql = "UPDATE `lineupcurrent`
                    SET `lineupcurrent_formation_id`='$guest_formation_id',
                        `lineupcurrent_gamemood_id`='$guest_gamemood_id',
                        `lineupcurrent_gamestyle_id`='$guest_gamestyle_id'
                    WHERE `lineupcurrent_team_id`='$guest_team_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $home_player_id_array   = array();
        $guest_player_id_array  = array();

        for ($j=1; $j<=18; $j++)
        {
            $home_player_id_sql         = 'home_player_id_' . $j;
            $home_player_id_array[$j]   = $game_array[$i][$home_player_id_sql];
            $guest_player_id_sql        = 'guest_player_id_' . $j;
            $guest_player_id_array[$j]  = $game_array[$i][$guest_player_id_sql];
        }

        for ($j=1; $j<=18; $j++)
        {
            $home_player_team_sql   = 'home_player_team_id_' . $j;
            $home_player_team_id    = $game_array[$i][$home_player_team_sql];

            if ($home_player_team_id != $home_team_id)
            {
                $home_player_id_implode = implode(',', $home_player_id_array);

                $sql = "SELECT `player_id`
                        FROM `player`
                        WHERE `player_team_id`='$home_team_id'
                        AND `player_id` NOT IN ($home_player_id_implode)
                        AND `player_injury`='0'
                        AND `player_rent_team_id`='0'
                        ORDER BY `player_condition` DESC
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id                  = $player_array[0]['player_id'];
                $home_player_id_array[$j]   = $player_id;

                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_player_id_" . $j . "`='$player_id'
                        WHERE `lineupcurrent_team_id`='$home_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $guest_player_team_sql  = 'guest_player_team_id_' . $j;
            $guest_player_team_id   = $game_array[$i][$guest_player_team_sql];

            if ($guest_player_team_id != $guest_team_id)
            {
                $guest_player_id_implode = implode(',', $guest_player_id_array);

                $sql = "SELECT `player_id`
                        FROM `player`
                        WHERE `player_team_id`='$guest_team_id'
                        AND `player_id` NOT IN ($guest_player_id_implode)
                        AND `player_injury`='0'
                        AND `player_rent_team_id`='0'
                        ORDER BY `player_condition` DESC
                        LIMIT 1";
                $player_sql = $mysqli->query($sql);

                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id                  = $player_array[0]['player_id'];
                $guest_player_id_array[$j]  = $player_id;

                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_player_id_" . $j . "`='$player_id'
                        WHERE `lineupcurrent_team_id`='$guest_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            if     (1  == $j) {$position = 1;}
            elseif (2  == $j) {$position = 3;}
            elseif (3  == $j) {$position = 4;}
            elseif (4  == $j) {$position = 6;}
            elseif (5  == $j) {$position = 7;}
            elseif (6  == $j) {$position = 13;}
            elseif (7  == $j) {$position = 14;}
            elseif (8  == $j) {$position = 16;}
            elseif (9  == $j) {$position = 17;}
            elseif (10 == $j) {$position = 23;}
            elseif (11 == $j) {$position = 25;}
            elseif (12 == $j) {$position = 26;}
            elseif (13 == $j) {$position = 27;}
            elseif (14 == $j) {$position = 28;}
            elseif (15 == $j) {$position = 29;}
            elseif (16 == $j) {$position = 30;}
            elseif (17 == $j) {$position = 31;}
            else              {$position = 32;}

            $home_player_position_sql   = 'home_position_id_' . $j;
            $home_player_position_id    = $game_array[$i][$home_player_position_sql];

            if (0 == $home_player_position_id)
            {
                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_position_id_" . $j . "`='$position'
                        WHERE `lineupcurrent_team_id`='$home_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            $guest_player_position_sql  = 'guest_position_id_' . $j;
            $guest_player_position_id   = $game_array[$i][$guest_player_position_sql];

            if (0 == $guest_player_position_id)
            {
                $sql = "UPDATE `lineupcurrent`
                        SET `lineupcurrent_position_id_" . $j . "`='$position'
                        WHERE `lineupcurrent_team_id`='$guest_team_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }

            if     (1  == $j) {$role = 1;}
            elseif (2  == $j) {$role = 5;}
            elseif (3  == $j) {$role = 9;}
            elseif (4  == $j) {$role = 9;}
            elseif (5  == $j) {$role = 5;}
            elseif (6  == $j) {$role = 18;}
            elseif (7  == $j) {$role = 21;}
            elseif (8  == $j) {$role = 21;}
            elseif (9  == $j) {$role = 18;}
            else              {$role = 30;}

            if (11 >= $j)
            {
                $home_player_role_sql   = 'home_role_id_' . $j;
                $home_player_role_id    = $game_array[$i][$home_player_role_sql];

                if (0 == $home_player_role_id)
                {
                    $sql = "UPDATE `lineupcurrent`
                            SET `lineupcurrent_role_id_" . $j . "`='$role'
                            WHERE `lineupcurrent_team_id`='$home_team_id'
                            LIMIT 1";
                    $mysqli->query($sql);
                }

                $guest_player_role_sql  = 'guest_role_id_' . $j;
                $guest_player_role_id   = $game_array[$i][$guest_player_role_sql];

                if (0 == $guest_player_role_id)
                {
                    $sql = "UPDATE `lineupcurrent`
                            SET `lineupcurrent_role_id_" . $j . "`='$role'
                            WHERE `lineupcurrent_team_id`='$guest_team_id'
                            LIMIT 1";
                    $mysqli->query($sql);
                }
            }
        }
    }
}

function f_igosja_generator_lineup_current_to_lineup()
//Переносим составы команд на матчи
{
    global $mysqli;

    for ($i=1; $i<=11; $i++)
    {
        $sql = "INSERT INTO `lineup` 
                (
                    `lineup_player_id`,
                    `lineup_position_id`,
                    `lineup_game_id`,
                    `lineup_team_id`
                )
                SELECT `lineupcurrent_player_id_" . $i . "`,
                       `lineupcurrent_position_id_" . $i . "`,
                       `game_id`,
                       `game_home_team_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                LEFT JOIN `lineupcurrent`
                ON `lineupcurrent_team_id`=`game_home_team_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                ORDER BY `game_id` ASC";
        $mysqli->query($sql);

        $sql = "INSERT INTO `lineup`
                (
                    `lineup_player_id`,
                    `lineup_position_id`,
                    `lineup_game_id`,
                    `lineup_team_id`
                )
                SELECT `lineupcurrent_player_id_" . $i . "`,
                       `lineupcurrent_position_id_" . $i . "`,
                       `game_id`,
                       `game_guest_team_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                LEFT JOIN `lineupcurrent`
                ON `lineupcurrent_team_id`=`game_guest_team_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                ORDER BY `game_id` ASC";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_lineup_to_disqualification()
//Добавляем игроков в таблицы дисквалификации
{
    global $mysqli;

    $sql = "SELECT `game_id`,
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

        $sql = "SELECT `lineup_player_id`
                FROM `game`
                LEFT JOIN `lineup`
                ON `game_id`=`lineup_game_id`
                WHERE `game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $player_sql = $mysqli->query($sql);

        $count_player = $player_sql->num_rows;

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_player; $j++)
        {
            $player_id = $player_array[$j]['lineup_player_id'];

            $sql = "SELECT COUNT(`disqualification_id`) AS `count_disqualification`
                    FROM `disqualification`
                    WHERE `disqualification_player_id`='$player_id'
                    AND `disqualification_tournament_id`='$tournament_id'";
            $check_sql = $mysqli->query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count_disqualification'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `disqualification`
                        SET `disqualification_player_id`='$player_id',
                            `disqualification_tournament_id`='$tournament_id'";
                $mysqli->query($sql);
            }
        }
    }
}

function f_igosja_generator_lineup_to_statistic()
//Добавляем игроков в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
                   `game_home_team_id`,
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
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];

        $sql = "SELECT `lineup_player_id`
                FROM `game`
                LEFT JOIN `lineup`
                ON (`game_id`=`lineup_game_id`
                AND `game_home_team_id`=`lineup_team_id`)
                WHERE `game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $home_player_sql = $mysqli->query($sql);

        $count_home_player = $home_player_sql->num_rows;

        $home_player_array = $home_player_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_home_player; $j++)
        {
            $player_id = $home_player_array[$j]['lineup_player_id'];

            $sql = "SELECT COUNT(`statisticplayer_id`) AS `count_statistic`
                    FROM `statisticplayer`
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$home_team_id'";
            $check_sql = $mysqli->query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count_statistic'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `statisticplayer`
                        SET `statisticplayer_player_id`='$player_id',
                            `statisticplayer_tournament_id`='$tournament_id',
                            `statisticplayer_season_id`='$igosja_season_id',
                            `statisticplayer_team_id`='$home_team_id'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `lineup_player_id`
                FROM `game`
                LEFT JOIN `lineup`
                ON (`game_id`=`lineup_game_id`
                AND `game_guest_team_id`=`lineup_team_id`)
                WHERE `game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $guest_player_sql = $mysqli->query($sql);

        $count_guest_player = $guest_player_sql->num_rows;

        $guest_player_array = $guest_player_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_guest_player; $j++)
        {
            $player_id = $guest_player_array[$j]['lineup_player_id'];

            $sql = "SELECT COUNT(`statisticplayer_id`) AS `count_statistic`
                    FROM `statisticplayer`
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$guest_team_id'";
            $check_sql = $mysqli->query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count_statistic'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `statisticplayer`
                        SET `statisticplayer_player_id`='$player_id',
                            `statisticplayer_tournament_id`='$tournament_id',
                            `statisticplayer_season_id`='$igosja_season_id',
                            `statisticplayer_team_id`='$guest_team_id'";
                $mysqli->query($sql);
            }
        }
    }
}

function f_igosja_generator_referee_to_statistic()
//Добавляем судей в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_referee_id`,
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
        $referee_id     = $game_array[$i]['game_referee_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];

        $sql = "SELECT COUNT(`statisticreferee_id`) AS `count_statistic`
                FROM `statisticreferee`
                WHERE `statisticreferee_referee_id`='$referee_id'
                AND `statisticreferee_tournament_id`='$tournament_id'
                AND `statisticreferee_season_id`='$igosja_season_id'";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $count_check = $check_array[0]['count_statistic'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `statisticreferee`
                    SET `statisticreferee_tournament_id`='$tournament_id',
                        `statisticreferee_season_id`='$igosja_season_id',
                        `statisticreferee_referee_id`='$referee_id'";
            $mysqli->query($sql);
        }
    }
}

function f_igosja_generator_team_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
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
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];

        $sql = "SELECT COUNT(`statisticteam_id`) AS `count_statistic`
                FROM `statisticteam`
                WHERE `statisticteam_team_id`='$home_team_id'
                AND `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $count_check = $check_array[0]['count_statistic'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `statisticteam`
                    SET `statisticteam_tournament_id`='$tournament_id',
                        `statisticteam_season_id`='$igosja_season_id',
                        `statisticteam_team_id`='$home_team_id'";
            $mysqli->query($sql);
        }

        $sql = "SELECT COUNT(`statisticteam_id`) AS `count_statistic`
                FROM `statisticteam`
                WHERE `statisticteam_team_id`='$guest_team_id'
                AND `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $count_check = $check_array[0]['count_statistic'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `statisticteam`
                    SET `statisticteam_tournament_id`='$tournament_id',
                        `statisticteam_season_id`='$igosja_season_id',
                        `statisticteam_team_id`='$guest_team_id'";
            $mysqli->query($sql);
        }
    }
}

function f_igosja_generator_user_to_statistic()
//Добавляем команды в статистические таблицы
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `guest_team`.`team_user_id` AS `guest_user_id`,
                   `home_team`.`team_user_id` AS `home_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_user_id   = $game_array[$i]['home_user_id'];
        $guest_user_id  = $game_array[$i]['guest_user_id'];

        $sql = "SELECT COUNT(`statisticuser_id`) AS `count_statistic`
                FROM `statisticuser`
                WHERE `statisticuser_user_id`='$home_user_id'
                AND `statisticuser_season_id`='$igosja_season_id'";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $count_check = $check_array[0]['count_statistic'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `statisticuser`
                    SET `statisticuser_season_id`='$igosja_season_id',
                        `statisticuser_user_id`='$home_user_id'";
            $mysqli->query($sql);
        }

        $sql = "SELECT COUNT(`statisticuser_id`) AS `count_statistic`
                FROM `statisticuser`
                WHERE `statisticuser_user_id`='$guest_user_id'
                AND `statisticuser_season_id`='$igosja_season_id'";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $count_check = $check_array[0]['count_statistic'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `statisticuser`
                    SET `statisticuser_season_id`='$igosja_season_id',
                        `statisticuser_user_id`='$guest_user_id'";
            $mysqli->query($sql);
        }
    }
}

function f_igosja_generator_game_result($minute)
//Генерируем матч
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
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
        $game_id        = $game_array[$i]['game_id'];
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];

        $data                                   = array();
        $data['minute']                         = $minute;
        $data['season']                         = $igosja_season_id;
        $data['air']                            = '';
        $data['decision']                       = '';
        $data['pass']                           = 0;
        $data['take']                           = 0;
        $data['team']                           = 'home';
        $data['opponent']                       = 'guest';
        $data['tournament']['tournament_id']    = $game_array[$i]['game_tournament_id'];
        $data['game_id']                        = $game_id;
        $data['home']['team']['team_id']        = $home_team_id;
        $data['guest']['team']['team_id']       = $guest_team_id;

        $sql = "SELECT `lineup_id`,
                       `lineup_position_id`,
                       `player_condition`,
                       `player_id`,
                       `player_height`,
                       `player_practice`
                FROM `lineup`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_lineup; $j++)
        {
            $player_id = $lineup_array[$j]['player_id'];

            $data['home']['player'][$j]['lineup_id']        = $lineup_array[$j]['lineup_id'];
            $data['home']['player'][$j]['lineup_position']  = $lineup_array[$j]['lineup_position_id'];
            $data['home']['player'][$j]['player_id']        = $player_id;
            $data['home']['player'][$j]['condition']        = $lineup_array[$j]['player_condition'];
            $data['home']['player'][$j]['practice']         = $lineup_array[$j]['player_practice'];
            $data['home']['player'][$j]['height']           = $lineup_array[$j]['player_height'];

            $sql = "SELECT `playerattribute_attribute_id`,
                           `playerattribute_value`
                    FROM `playerattribute`
                    WHERE `playerattribute_player_id`='$player_id'
                    ORDER BY `playerattribute_attribute_id` ASC";
            $attribute_sql = $mysqli->query($sql);

            $count_attribute = $attribute_sql->num_rows;

            $attaribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_attribute; $k++)
            {
                $data['home']['player'][$j]['attribute'][$attaribute_array[$k]['playerattribute_attribute_id']] = $attaribute_array[$k]['playerattribute_value'];
            }

            $sql = "SELECT `playerposition_position_id`,
                           `playerposition_value`
                    FROM `playerposition`
                    WHERE `playerposition_player_id`='$player_id'
                    ORDER BY `playerposition_position_id` ASC";
            $position_sql = $mysqli->query($sql);

            $count_position = $position_sql->num_rows;

            $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_position; $k++)
            {
                $data['home']['player'][$j]['posititon'][$position_array[$k]['playerposition_position_id']] = $position_array[$k]['playerposition_value'];
            }
        }

        $sql = "SELECT `lineup_id`,
                       `lineup_position_id`,
                       `player_condition`,
                       `player_id`,
                       `player_height`,
                       `player_practice`
                FROM `lineup`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_lineup; $j++)
        {
            $player_id = $lineup_array[$j]['player_id'];

            $data['guest']['player'][$j]['lineup_id']       = $lineup_array[$j]['lineup_id'];
            $data['guest']['player'][$j]['lineup_position'] = $lineup_array[$j]['lineup_position_id'];
            $data['guest']['player'][$j]['player_id']       = $player_id;
            $data['guest']['player'][$j]['condition']       = $lineup_array[$j]['player_condition'];
            $data['guest']['player'][$j]['practice']        = $lineup_array[$j]['player_practice'];
            $data['guest']['player'][$j]['height']          = $lineup_array[$j]['player_height'];

            $sql = "SELECT `playerattribute_attribute_id`,
                           `playerattribute_value`
                    FROM `playerattribute`
                    WHERE `playerattribute_player_id`='$player_id'
                    ORDER BY `playerattribute_attribute_id` ASC";
            $attribute_sql = $mysqli->query($sql);

            $count_attribute = $attribute_sql->num_rows;

            $attaribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_attribute; $k++)
            {
                $data['guest']['player'][$j]['attribute'][$attaribute_array[$k]['playerattribute_attribute_id']] = $attaribute_array[$k]['playerattribute_value'];
            }

            $sql = "SELECT `playerposition_position_id`,
                           `playerposition_value`
                    FROM `playerposition`
                    WHERE `playerposition_player_id`='$player_id'
                    ORDER BY `playerposition_position_id` ASC";
            $position_sql = $mysqli->query($sql);

            $count_position = $position_sql->num_rows;

            $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

            for ($k=0; $k<$count_position; $k++)
            {
                $data['guest']['player'][$j]['posititon'][$position_array[$k]['playerposition_position_id']] = $position_array[$k]['playerposition_value'];
            }
        }

        f_igosja_generator_decision($data);

        $data['minute'] = $minute + 1;
        $data['team'] = 'guest';
        $data['opponent'] = 'home';

        f_igosja_generator_decision($data);
    }
}

function f_igosja_generator_decision($data)
//Игрок принимает решение
{
    $decision = rand(1,6);

    $data['decision'] = $decision;

    f_igosja_generator_decision_result($data);
}

function f_igosja_generator_decision_result($data)
//Игрок пытается воплотить решение в жизнь
{
    global $mysqli;

    $decision   = $data['decision'];
    $game_id    = $data['game_id'];
    $minute     = $data['minute'];
    $team_id    = $data[$data['team']]['team']['team_id'];

    if (0 == $data['take'])
    {
        $player = rand(1, 10);
    }
    else
    {
        $player       = $data['take'];
        $data['take'] = 0;
    }

    $player_id  = $data[$data['team']]['player'][$player]['player_id'];
    $char       = $data[$data['team']]['player'][$player]['attribute'][ATTRIBUTE_FIELD_VIEW];
    $vision     = rand($char, 200);

    if (200 == $vision)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='выводит передачей партнера один в один.'";
        $mysqli->query($sql);

        $data['pass'] = $player;

        f_igosja_generator_one_on_one($data);
    }
    elseif (1 == $decision) //Удар
    {
        $data['air'] = f_igosja_generator_air_before_shot();

        f_igosja_generator_shot($data);
    }
    elseif (2 == $decision) //Навес
    {
        f_igosja_generator_air_pass($data);
    }
    elseif (3 == $decision) //Прострел
    {
        f_igosja_generator_fast_pass($data);
    }
    elseif (4 == $decision) //Пас длинный
    {
        f_igosja_generator_long_pass($data);
    }
    elseif (5 == $decision) //Пас короткий
    {
        f_igosja_generator_pass($data);
    }
    elseif (6 == $decision) //Дриблинг
    {
        f_igosja_generator_dribling($data);
    }
}

function f_igosja_generator_air_before_shot()
//Высота передачи (верхом/низом)
{
    $air = rand(1,2);

    return $air;
}

function f_igosja_generator_shot($data)
//Удар по воротам
{
    global $mysqli;

    $player_opponent    = rand(1,10);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];
    $gk_player_id       = $data[$data['opponent']]['player'][0]['player_id'];
    $tournament_id      = $data['tournament']['tournament_id'];
    $season_id          = $data['season'];
    $minute             = $data['minute'];
    $air                = $data['air'];
    $player_pass        = $data['pass'];

    if (0 == $data['take'])
    {
        $player_shot = rand(1, 10);
    }
    else
    {
        $player_shot  = $data['take'];
        $data['take'] = 0;
    }

    $lineup_id = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $player_id = $data[$data['team']]['player'][$player_shot]['player_id'];

    if (0 < $player_pass)
    {
        $pass_player_id = $data[$data['team']]['player'][$player_pass]['player_id'];
        $pass_lineup_id = $data[$data['team']]['player'][$player_pass]['lineup_id'];
    }

    if ($air == 1) //Удар с земли
    {
        $distance = rand(1,2);

        if (1 == $distance) //Близкое расстояние
        {
            $char_1 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_SHOT];
            $char_2 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
            $char_3 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='пытается пробить с близкого расстояния.'";
            $mysqli->query($sql);

            $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

            $success = f_igosja_generator_success($char);

            if (1 == $success)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team_id',
                            `broadcasting_text`='наносит удар с близкого расстояния.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$season_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $opposition = f_igosja_generator_opposition($data);

                if (0 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='пробивает в створ.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                                `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_ontarget`=`lineup_ontarget`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $goalkeeper = f_igosja_generator_goalkeeper_opposition($data);

                    if (0 == $goalkeeper)
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$team_id',
                                    `broadcasting_text`='отправляет мяч в сетку.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                                    `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                WHERE `statisticplayer_player_id`='$player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$season_id'
                                AND `statisticplayer_team_id`='$team_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_goal`=`lineup_goal`+'1'
                                WHERE `lineup_id`='$lineup_id'";
                        $mysqli->query($sql);

                        if (0 != $player_pass)
                        {
                            $sql = "UPDATE `statisticplayer`
                                    SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                                    WHERE `statisticplayer_player_id`='$pass_player_id'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$season_id'
                                    AND `statisticplayer_team_id`='$team_id'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                    WHERE `lineup_id`='$pass_lineup_id'
                                    LIMIT 1";
                            $mysqli->query($sql);
                        }

                        $sql = "INSERT INTO `event`
                                SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                    `event_game_id`='$game_id',
                                    `event_minute`='$minute',
                                    `event_player_id`='$player_id',
                                    `event_team_id`='$team_id'";
                        $mysqli->query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$gk_player_id',
                                    `broadcasting_team_id`='$opponent_id',
                                    `broadcasting_text`='нейтрализирует угрозу.'";
                        $mysqli->query($sql);

                        f_igosja_generator_corner($data);
                    }
                }
                else
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='пробивает мимо ворот.'";
                    $mysqli->query($sql);
                }
            }
            else
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$opponent_player_id',
                            `broadcasting_text`='блокирует удар.'";
                $mysqli->query($sql);
            }
        }
        else //Дальний удар
        {
            $char_1 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_LONG_SHOT];
            $char_2 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
            $char_3 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='пытается нанести дальний удар.'";
            $mysqli->query($sql);

            $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 3);

            $success = f_igosja_generator_success($char);

            if (1 == $success)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team_id',
                            `broadcasting_text`='наносит дальний удар.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$season_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $opposition = f_igosja_generator_opposition($data);

                if (0 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='пробивает в створ.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                                `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_ontarget`=`lineup_ontarget`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $goalkeeper = f_igosja_generator_goalkeeper_opposition($data);

                    if (0 == $goalkeeper)
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$team_id',
                                    `broadcasting_text`='отправляет мяч в сетку.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                                    `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                WHERE `statisticplayer_player_id`='$player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$season_id'
                                AND `statisticplayer_team_id`='$team_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_goal`=`lineup_goal`+'1'
                                WHERE `lineup_id`='$lineup_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        if (0 != $player_pass)
                        {
                            $sql = "UPDATE `statisticplayer`
                                    SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                                    WHERE `statisticplayer_player_id`='$pass_player_id'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$season_id'
                                    AND `statisticplayer_team_id`='$team_id'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                    WHERE `lineup_id`='$pass_lineup_id'
                                    LIMIT 1";
                            $mysqli->query($sql);
                        }

                        $sql = "INSERT INTO `event`
                                SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                    `event_game_id`='$game_id',
                                    `event_minute`='$minute',
                                    `event_player_id`='$player_id',
                                    `event_team_id`='$team_id'";
                        $mysqli->query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$gk_player_id',
                                    `broadcasting_team_id`='$opponent_id',
                                    `broadcasting_text`='нейтрализирует угрозу.'";
                        $mysqli->query($sql);

                        f_igosja_generator_corner($data);
                    }
                }
                else
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='пробивает мимо ворот.'";
                    $mysqli->query($sql);
                }
            }
            else
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$opponent_player_id',
                            `broadcasting_team_id`='$opponent_id',
                            `broadcasting_text`='блокируют удар.'";
                $mysqli->query($sql);
            }
        }
    }
    else //Удар головой
    {
        $data['air'] = 1;

        $char_1 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_HEAD];
        $char_2 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CHOISE_POSITION];
        $char_3 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_JUMP];
        $char_4 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];
        $char_5 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COORDINATE];
        $char_6 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_DEXTERITY];
        $char_7 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
        $char_8 = $data[$data['team']]['player'][$player_shot]['height'];

        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='пытается сыграть головой.'";
        $mysqli->query($sql);

        $char = ($char_1 + ($char_2 + $char_3 + $char_8 / 2) * 50 / 100 + ($char_4 + $char_5 + $char_6 + $char_7) * 25 / 100) / 3.5;

        $success = f_igosja_generator_success($char);

        if (1 == $success)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='провибает головой.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                        `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1')
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$season_id'
                    AND `statisticplayer_team_id`='$team_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_shot`=`lineup_shot`+'1'
                    WHERE `lineup_id`='$lineup_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $opposition = f_igosja_generator_opposition($data);

            if (0 == $opposition)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team_id',
                            `broadcasting_text`='мяч летит в створ ворот.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                            `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$season_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_ontarget`=`lineup_ontarget`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $goalkeeper = f_igosja_generator_goalkeeper_opposition($data);

                if (0 == $goalkeeper)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='забивает мяч в ворота.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                                `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_goal`=`lineup_goal`+'1'
                            WHERE `lineup_id`='$lineup_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    if (0 != $player_pass)
                    {
                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                                WHERE `statisticplayer_player_id`='$pass_player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$season_id'
                                AND `statisticplayer_team_id`='$team_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                WHERE `lineup_id`='$pass_lineup_id'
                                LIMIT 1";
                        $mysqli->query($sql);
                    }

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$team_id'";
                    $mysqli->query($sql);
                }
                else
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$gk_player_id',
                                `broadcasting_team_id`='$opponent_id',
                                `broadcasting_text`='читает ситуацию.'";
                    $mysqli->query($sql);

                    f_igosja_generator_corner($data);
                }
            }
            else
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team_id',
                            `broadcasting_text`='пробивает мимо ворот.'";
                $mysqli->query($sql);
            }
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$opponent_player_id',
                        `broadcasting_team_id`='$opponent_id',
                        `broadcasting_text`='снимает мяч с головы соперника.'";
            $mysqli->query($sql);
        }
    }
}

function f_igosja_generator_success($char)
//Успешность действия
{
    $success = rand($char, 200);

    if (160 < $success)
    {
        $result = 1;
    }
    else
    {
        $result = 0;
    }

    return $result;
}

function f_igosja_generator_air_pass($data)
//Навес
{
    global $mysqli;

    if (0 == $data['take'])
    {
        $player_air_pass = rand(1, 10);
    }
    else
    {
        $player_air_pass = $data['take'];
        $data['take']    = 0;
    }

    $game_id   = $data['game_id'];
    $team_id   = $data[$data['team']]['team']['team_id'];
    $minute    = $data['minute'];
    $player_id = $data[$data['team']]['player'][$player_air_pass]['player_id'];

    $char_1 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $air_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team_id',
                `broadcasting_text`='пытается сделать навес в штрафную.'";
    $mysqli->query($sql);

    if (150 < $air_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='навешивает в сторону штрафной площадки.'";
        $mysqli->query($sql);

        $data['pass'] = $player_air_pass;
        $data['air']  = 2;

        f_igosja_generator_shot($data);
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='неудачно навешивает.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_fast_pass($data)
//Простел
{
    global $mysqli;

    if (0 == $data['take'])
    {
        $player_fast_pass = rand(1, 10);
    }
    else
    {
        $player_fast_pass = $data['take'];
        $data['take']     = 0;
    }

    $player_opponent    = rand(1, 10);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_fast_pass]['player_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];

    $char_1 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_PASS];
    $char_3 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);

    $fast_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team_id',
                `broadcasting_text`='пытается прострелить.'";
    $mysqli->query($sql);

    if (150 < $fast_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='простеливает в штрафную.'";
        $mysqli->query($sql);

        $opposition = f_igosja_generator_opposition($data);

        if (0 == $opposition)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='удачно находит партнера своим прострелом.'";
            $mysqli->query($sql);

            $data['air']  = 1;
            $data['pass'] = $player_fast_pass;

            f_igosja_generator_shot($data);
        }
        elseif (1 == $opposition)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$opponent_player_id',
                        `broadcasting_team_id`='$opponent_id',
                        `broadcasting_text`='читает прострел.'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='простреливает крайне неточно.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_long_pass($data)
//Диагональная передача
{
    global $mysqli;

    if (0 == $data['take'])
    {
        $player_long_pass = rand(1, 10);
    }
    else
    {
        $player_long_pass = $data['take'];
        $data['take']     = 0;
    }

    $player_opponent    = rand(1, 10);
    $player_take        = rand(1, 10);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_long_pass]['player_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];
    $take_player_id     = $data[$data['opponent']]['player'][$player_take]['player_id'];

    $data['take'] = $player_take;

    $char_1 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_PASS];
    $char_3 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);

    $long_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team_id',
                `broadcasting_text`='пытается отдать длинную диагональ.'";
    $mysqli->query($sql);

    if (150 < $long_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='отдает передачу, что надо.'";
        $mysqli->query($sql);

        $taking = f_igosja_generator_taking($data);

        if (1 == $taking)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$take_player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='качественно принимает длинный пас.'";
            $mysqli->query($sql);

            $opposition = f_igosja_generator_opposition($data);

            if (0 == $opposition)
            {
                f_igosja_generator_decision($data);
            }
            else
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$opponent_player_id',
                            `broadcasting_team_id`='$opponent_id',
                            `broadcasting_text`='прессингует и отбирает мяч.'";
                $mysqli->query($sql);
            }
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$take_player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='не справляется с приемом мяча.'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='отдает передачу очень не точно.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_pass($data)
//Обостряющий пас в разрез
{
    global $mysqli;

    if (0 == $data['take'])
    {
        $player_pass = rand(1, 10);
    }
    else
    {
        $player_pass  = $data['take'];
        $data['take'] = 0;
    }

    $player_take        = rand(1, 10);
    $data['take']       = $player_take;
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_pass]['player_id'];
    $take_player_id     = $data[$data['opponent']]['player'][$player_take]['player_id'];

    $char_1 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_PASS];
    $char_2 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team_id',
                `broadcasting_text`='пытается отдать обостряющую передачу.'";
    $mysqli->query($sql);

    if (150 < $pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='хорошо пасует на партнера.'";
        $mysqli->query($sql);

        $taking = f_igosja_generator_taking($data);

        if (1 == $taking)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$take_player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='хорошо обрабатывает мяч.'";
            $mysqli->query($sql);

            f_igosja_generator_decision($data);
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$take_player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='ошибается с приемом мяча.'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='отдает мяч сопернику.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_dribling($data)
//Обводка соперника
{
    global $mysqli;

    if (0 == $data['take'])
    {
        $player_dribling = rand(1, 10);
    }
    else
    {
        $player_dribling = $data['take'];
        $data['take']    = 0;
    }

    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_dribling]['player_id'];

    $char_1 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_DRIBLING];
    $char_2 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $dribling = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team_id',
                `broadcasting_text`='идет в обыгрыш.'";
    $mysqli->query($sql);

    if (150 < $dribling)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='технично освобождается от опеки соперника.'";
        $mysqli->query($sql);

        f_igosja_generator_decision($data);
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='теряет мяч при попытке дриблинга.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_taking($data)
//Прием мяча
{
    if (0 == $data['take'])
    {
        $player_taking = rand(1, 10);
    }
    else
    {
        $player_taking = $data['take'];
        $data['take']    = 0;
    }

    $char_1 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_TAKING];
    $char_2 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $taking = rand($char, 200);

    if (150 < $taking)
    {
        $result = 1;
    }
    else
    {
        $result = 0;
    }

    return $result;
}

function f_igosja_generator_opposition($data)
//Отбор мяча
{
    global $mysqli;

    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $gk_player_id       = $data[$data['opponent']]['player'][0]['player_id'];
    $tournament_id      = $data['tournament']['tournament_id'];
    $season_id          = $data['season'];
    $minute             = $data['minute'];
    $player_shot        = rand(1, 10);
    $shot_player_id     = $data[$data['team']]['player'][$player_shot]['player_id'];
    $shot_lineup_id     = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $player_opposition  = rand(1, 10);
    $lineup_id          = $data[$data['opponent']]['player'][$player_opposition]['lineup_id'];
    $player_id          = $data[$data['opponent']]['player'][$player_opposition]['player_id'];

    $char_1     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_PRESSING];
    $char_2     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_FAMBLE];
    $char_3     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_CONCENTRATION];
    $char_5     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_CHOISE_POSITION];
    $char_6     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_COORDINATE];
    $char_7     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_DEXTERITY];
    $char_8     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_SERVICEABILITY];
    $char_9     = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_BRAVE];
    $char_10    = $data[$data['opponent']]['player'][$player_opposition]['attribute'][ATTRIBUTE_AGRESSION];
    $char_11    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_PENALTY];
    $char_12    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_13    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];
    $char_14    = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_GK_PENALTY];
    $char_15    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_FREE_KICK];
    $char_16    = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_GK_FREE_KICK];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4 + $char_5 + $char_6 + $char_7 + $char_8 + $char_9) * 25 / 100) / 3.75);

    $opposition = rand($char, 200);

    if (130 < $opposition)
    {
        $result = 1;

        $foul_char = rand(100, 100 + $char_10);

        if (150 > $foul_char)
        {
            $result = 2;

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$opponent_id',
                        `broadcasting_text`='отбирает мяч с нарушением правил.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_foul`=IF(`game_home_team_id`='$team_id',`game_home_foul`,`game_home_foul`+'1'),
                        `game_guest_foul`=IF(`game_home_team_id`='$team_id',`game_guest_foul`+'1',`game_guest_foul`)
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_foul`=`statisticplayer_foul`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$season_id'
                    AND `statisticplayer_team_id`='$opponent_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_foul_made`=`lineup_foul_made`+'1'
                    WHERE `lineup_id`='$lineup_id'";
            $mysqli->query($sql);

            if (100 == $foul_char)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$opponent_id',
                            `broadcasting_text`='фолит в своей штрафной. Пенальти.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_penalty`=IF(`game_home_team_id`='$team_id',`game_home_penalty`+'1',`game_home_penalty`),
                            `game_guest_penalty`=IF(`game_home_team_id`='$team_id',`game_guest_penalty`,`game_guest_penalty`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $char = round(($char_11 + ($char_12 + $char_13) * 25 / 100) / 1.5) * 10;

                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                            `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1'),
                            `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_penalty`=`statisticplayer_penalty`+'1',
                            `statisticplayer_shot`=`statisticplayer_shot`+'1',
                            `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$shot_player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$season_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1',
                            `lineup_ontarget`=`lineup_ontarget`+'1',
                            `lineup_penalty`=`lineup_penalty`+'1'
                        WHERE `lineup_id`='$shot_lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $goalkeeper = rand($char_14, 200);

                if ($char > $goalkeeper)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$shot_player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='реализовывает пенальти.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                                `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`+'1',
                                `statisticplayer_goal`=`statisticplayer_goal`+'1'
                            WHERE `statisticplayer_player_id`='$shot_player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$shot_player_id',
                                `event_team_id`='$team_id'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_goal`=`lineup_goal`+'1',
                                `lineup_penalty_goal`=`lineup_penalty_goal`+'1'
                            WHERE `lineup_id`='$shot_lineup_id'";
                    $mysqli->query($sql);
                }
                else
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$gk_player_id',
                                `broadcasting_team_id`='$opponent_id',
                                `broadcasting_text`='спасает команду.'";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_NO_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$shot_player_id',
                                `event_team_id`='$team_id'";
                    $mysqli->query($sql);

                    f_igosja_generator_corner($data);
                }
            }
            else
            {
                if (101 == $foul_char)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$opponent_id',
                                `broadcasting_text`='отправляется в раздевалку. Красная карточка.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_red`=IF(`game_home_team_id`='$opponent_id',`game_home_red`+'1',`game_home_red`),
                                `game_guest_red`=IF(`game_home_team_id`='$opponent_id',`game_guest_red`,`game_guest_red`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_red`=`statisticplayer_red`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$opponent_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_RED . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$opponent_id'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_red`=`lineup_red`+'1'
                            WHERE `lineup_id`='$lineup_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `disqualification`
                            SET `disqualification_red`=`disqualification_red`+'1'
                            WHERE `disqualification_tournament_id`='$tournament_id'
                            AND `disqualification_player_id`='$player_id'";
                    $mysqli->query($sql);
                }
                elseif (115 > $foul_char)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$opponent_id',
                                `broadcasting_text`='получает желтую.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_yellow`=IF(`game_home_team_id`='$opponent_id',`game_home_yellow`+'1',`game_home_yellow`),
                                `game_guest_yellow`=IF(`game_home_team_id`='$opponent_id',`game_guest_yellow`,`game_guest_yellow`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_yellow`=`statisticplayer_yellow`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$opponent_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_YELLOW . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$opponent_id'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_yellow`=`lineup_yellow`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `disqualification`
                            SET `disqualification_yellow`=`disqualification_yellow`+'1'
                            WHERE `disqualification_tournament_id`='$tournament_id'
                            AND `disqualification_player_id`='$player_id'";
                    $mysqli->query($sql);
                }

                $char = round(($char_15 + ($char_12 + $char_13) * 25 / 100) / 1.5);

                $success = f_igosja_generator_success($char);

                if (1 == $success)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$shot_player_id',
                                `broadcasting_team_id`='$team_id',
                                `broadcasting_text`='пробивает со штрафного.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                                `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                            WHERE `statisticplayer_player_id`='$shot_player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$opponent_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_shot`=`lineup_shot`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $opposition = f_igosja_generator_success($char);

                    if (0 == $opposition)
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$shot_player_id',
                                    `broadcasting_team_id`='$team_id',
                                    `broadcasting_text`='направляет мяч в створ ворот.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                                    `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                                WHERE `statisticplayer_player_id`='$shot_player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$season_id'
                                AND `statisticplayer_team_id`='$team_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_ontarget`=`lineup_ontarget`+'1'
                                WHERE `lineup_id`='$shot_lineup_id'";
                        $mysqli->query($sql);

                        $player_free    = rand($char_15, 200);
                        $gk_free        = rand($char_16, 200);

                        if ($player_free > $gk_free)
                        {
                            $sql = "INSERT INTO `broadcasting`
                                    SET `broadcasting_game_id`='$game_id',
                                        `broadcasting_minute`='$minute',
                                        `broadcasting_player_id`='$shot_player_id',
                                        `broadcasting_team_id`='$team_id',
                                        `broadcasting_text`='забивает гол.'";
                            $mysqli->query($sql);

                            $sql = "UPDATE `game`
                                    SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                                        `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                                    WHERE `game_id`='$game_id'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `statisticplayer`
                                    SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                    WHERE `statisticplayer_player_id`='$shot_player_id'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$season_id'
                                    AND `statisticplayer_team_id`='$team_id'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_goal`=`lineup_goal`+'1'
                                    WHERE `lineup_id`='$shot_lineup_id'";
                            $mysqli->query($sql);

                            $sql = "INSERT INTO `event`
                                    SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                        `event_game_id`='$game_id',
                                        `event_minute`='$minute',
                                        `event_player_id`='$shot_player_id',
                                        `event_team_id`='$team_id'";
                            $mysqli->query($sql);
                        }
                        else
                        {
                            $sql = "INSERT INTO `broadcasting`
                                    SET `broadcasting_game_id`='$game_id',
                                        `broadcasting_minute`='$minute',
                                        `broadcasting_player_id`='$gk_player_id',
                                        `broadcasting_team_id`='$opponent_id',
                                        `broadcasting_text`='нейтрализирует угрозу.'";
                            $mysqli->query($sql);

                            f_igosja_generator_corner($data);
                        }
                    }
                }
            }
        }
    }
    else
    {
        $result = 0;
    }

    return $result;
}

function f_igosja_generator_goalkeeper_opposition($data)
//Игра вратаря
{
    $char_1 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_REACTION];
    $char_2 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_HANDS];
    $char_3 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_IN_AREA];
    $char_4 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_CATCH];
    $char_5 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_DEXTERITY];
    $char_6 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_COORDINATE];

    $char = round(($char_1 + $char_2 * 50 / 100 + ($char_3 + $char_4 + $char_5 + $char_6) * 25 / 100) / 2.5);

    $gk_play = rand($char, 200);

    if (125 < $gk_play)
    {
        $result = 1;
    }
    else
    {
        $result = 0;
    }

    return $result;
}

function f_igosja_generator_corner($data)
//Угловой
{
    global $mysqli;

    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $gk_player_id       = $data[$data['opponent']]['player'][0]['player_id'];
    $minute             = $data['minute'];
    $player_corner      = rand(1, 10);
    $corner_player_id   = $data[$data['team']]['player'][$player_corner]['player_id'];
    $player_defence     = rand(1, 10);
    $defence_player_id  = $data[$data['opponent']]['player'][$player_defence]['player_id'];

    $char_1 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_CATCH];
    $char_2 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_CORNER];
    $char_3 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_CONCENTRATION];

    $gk_play = rand(100, 100 + $char_1);

    if (150 < $gk_play)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$gk_player_id',
                    `broadcasting_team_id`='$opponent_id',
                    `broadcasting_text`='переводит мяч на угловой.'";
        $mysqli->query($sql);

        $sql = "UPDATE `game`
                SET `game_home_corner`=IF(`game_home_team_id`='$team_id',`game_home_corner`+'1',`game_home_corner`),
                    `game_guest_corner`=IF(`game_home_team_id`='$team_id',`game_guest_corner`,`game_guest_corner`+'1')
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        $char = round(($char_2 + ($char_3 + $char_4) * 25 / 100) / 1.5);

        $air_pass = rand($char, 200);

        if (170 < $air_pass)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$corner_player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='навешивает с углового на партнера.'";
            $mysqli->query($sql);

            $data['air']  = 2;
            $data['pass'] = $player_corner;

            f_igosja_generator_shot($data);
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$defence_player_id',
                        `broadcasting_team_id`='$opponent_id',
                        `broadcasting_text`='выбивает мяч после углового.'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$gk_player_id',
                    `broadcasting_team_id`='$opponent_id',
                    `broadcasting_text`='забирает мяч в руки.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_one_on_one($data)
//Выход 1 в 1
{
    global $mysqli;

    $game_id        = $data['game_id'];
    $team_id        = $data[$data['team']]['team']['team_id'];
    $opponent_id    = $data[$data['opponent']]['team']['team_id'];
    $gk_player_id   = $data[$data['opponent']]['player'][0]['player_id'];
    $tournament_id  = $data['tournament']['tournament_id'];
    $season_id      = $data['season'];
    $minute         = $data['minute'];
    $player_pass    = $data['pass'];
    $pass_player_id = $data[$data['team']]['player'][$player_pass]['player_id'];
    $pass_lineup_id = $data[$data['team']]['player'][$player_pass]['lineup_id'];

    if (0 == $data['take'])
    {
        $player_shot = rand(1, 10);
    }
    else
    {
        $player_shot  = $data['take'];
        $data['take'] = 0;
    }

    $lineup_id      = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $player_id      = $data[$data['team']]['player'][$player_shot]['player_id'];

    $char_1 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_SHOT];
    $char_2 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];
    $char_4 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_ONE_ON_ONE];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $success = f_igosja_generator_success($char);

    if (1 == $success)
    {
        $sql = "UPDATE `game`
                SET `game_home_shot`=IF(`game_home_team_id`='$team_id',`game_home_shot`+'1',`game_home_shot`),
                    `game_home_ontarget`=IF(`game_home_team_id`='$team_id',`game_home_ontarget`+'1',`game_home_ontarget`),
                    `game_guest_shot`=IF(`game_home_team_id`='$team_id',`game_guest_shot`,`game_guest_shot`+'1'),
                    `game_guest_ontarget`=IF(`game_home_team_id`='$team_id',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='пытается переиграть вратаря.'";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_shot`=`statisticplayer_shot`+'1',
                    `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_season_id`='$season_id'
                AND `statisticplayer_team_id`='$team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_shot`=`lineup_shot`+'1',
                    `lineup_ontarget`=`lineup_ontarget`+'1'
                WHERE `lineup_id`='$lineup_id'";
        $mysqli->query($sql);

        $gk_play = rand($char_4, 200);

        if (150 < $gk_play)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$gk_player_id',
                        `broadcasting_team_id`='$opponent_id',
                        `broadcasting_text`='спасает команду.'";
            $mysqli->query($sql);

            f_igosja_generator_corner($data);
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team_id',
                        `broadcasting_text`='реализует выход 1 на 1.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_score`=IF(`game_home_team_id`='$team_id',`game_home_score`+'1',`game_home_score`),
                        `game_guest_score`=IF(`game_home_team_id`='$team_id',`game_guest_score`,`game_guest_score`+'1')
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$season_id'
                    AND `statisticplayer_team_id`='$team_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                    WHERE `statisticplayer_player_id`='$pass_player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$season_id'
                    AND `statisticplayer_team_id`='$team_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                    WHERE `lineup_id`='$pass_lineup_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_goal`=`lineup_goal`+'1'
                    WHERE `lineup_id`='$lineup_id'";
            $mysqli->query($sql);

            $sql = "INSERT INTO `event`
                    SET `event_eventtype_id`='" . EVENT_GOAL . "',
                        `event_game_id`='$game_id',
                        `event_minute`='$minute',
                        `event_player_id`='$player_id',
                        `event_team_id`='$team_id'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team_id',
                    `broadcasting_text`='не успевает к мячу.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_statistic_player()
//Обновляем статистику игроков
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
                   `game_home_team_id`,
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

        $sql = "SELECT `lineup_player_id`
                FROM `game`
                LEFT JOIN `lineup`
                ON (`game_id`=`lineup_game_id`
                AND `game_home_team_id`=`lineup_team_id`)
                WHERE `game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $home_player_sql = $mysqli->query($sql);

        $count_home_player = $home_player_sql->num_rows;

        $home_player_array = $home_player_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_home_player; $j++)
        {
            $player_id      = $home_player_array[$j]['lineup_player_id'];
            $distance       = 5000 + rand(0,5000);
            $mark           = 5 + (rand(0, 10) + rand(0, 10) + rand(0, 10) + rand(0, 10) + rand(0, 10)) / 10;
            $pass           = 30 + rand(0, 30);
            $pass_accurate  = $pass - rand(0, 20);
            $condition      = rand(20, 50);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_game`=`statisticplayer_game`+'1',
                        `statisticplayer_mark`=`statisticplayer_mark`+'$mark',
                        `statisticplayer_pass`=`statisticplayer_pass`+'$pass',
                        `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+'$pass_accurate',
                        `statisticplayer_win`=`statisticplayer_win`+RAND()
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_distance`='$distance',
                        `lineup_mark`='$mark',
                        `lineup_pass`='$pass',
                        `lineup_pass_accurate`='$pass_accurate',
                        `lineup_condition`=
                        (
                            SELECT `player_condition`-'$condition'
                            FROM `player`
                            WHERE `player_id`='$player_id'
                            LIMIT 1
                        )
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_player_id`='$player_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $sql = "SELECT `lineup_player_id`
                FROM `game`
                LEFT JOIN `lineup`
                ON (`game_id`=`lineup_game_id`
                AND `game_guest_team_id`=`lineup_team_id`)
                WHERE `game_id`='$game_id'
                ORDER BY `lineup_position_id` ASC";
        $guest_player_sql = $mysqli->query($sql);

        $count_guest_player = $guest_player_sql->num_rows;

        $guest_player_array = $guest_player_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_guest_player; $j++)
        {
            $player_id      = $guest_player_array[$j]['lineup_player_id'];
            $distance       = 5000 + rand(0,5000);
            $mark           = 5 + (rand(0, 10) + rand(0, 10) + rand(0, 10) + rand(0, 10) + rand(0, 10)) / 10;
            $pass           = 30 + rand(0, 30);
            $pass_accurate  = $pass - rand(0, 20);
            $condition      = 50 + rand(0, 30);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_game`=`statisticplayer_game`+'1',
                        `statisticplayer_mark`=`statisticplayer_mark`+'$mark',
                        `statisticplayer_pass`=`statisticplayer_pass`+'$pass',
                        `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+'$pass_accurate',
                        `statisticplayer_win`=`statisticplayer_win`+RAND()
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_distance`='$distance',
                        `lineup_mark`='$mark',
                        `lineup_pass`='$pass',
                        `lineup_pass_accurate`='$pass_accurate',
                        `lineup_condition`='$condition'
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_player_id`='$player_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_best`=`statisticplayer_best`+'1'
                WHERE `statisticplayer_player_id`=
                (
                    SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    ORDER BY `lineup_mark` DESC
                    LIMIT 1
                )
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_player_condition_practice()
//Обновляем статистику команд и менеджеров
{
    global $mysqli;

    $sql = "UPDATE `player`
            SET `player_condition`=`player_condition`-'8'-'4'*RAND(),
                `player_practice`=`player_practice`+'10'+'5'*RAND()
            WHERE `player_id` IN 
            (
                SELECT `lineup_player_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `game_id`=`lineup_game_id`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                WHERE `game_played`='0'
                AND `shedule_date`=CURDATE()
                ORDER BY `lineup_player_id` ASC
            )";
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
            SET `player_condition`='0'
            WHERE `player_condition`<'0'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='100'
            WHERE `player_practice`>'100'";
    $mysqli->query($sql);

    $sql = "UPDATE `player`
            SET `player_practice`='0'
            WHERE `player_practice`<'0'";
    $mysqli->query($sql);
}

function f_igosja_generator_statistic_team_user_referee()
//Обновляем статистику команд и менеджеров
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
                   `game_guest_score`,
                   `game_home_team_id`,
                   `game_home_score`,
                   `game_referee_id`,
                   `game_tournament_id`,
                   `guest_team`.`team_user_id` AS `guest_user_id`,
                   `home_team`.`team_user_id` AS `home_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
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
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_user_id  = $game_array[$i]['guest_user_id'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $referee_id     = $game_array[$i]['game_referee_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;

        $sql = "UPDATE `statisticreferee`
                SET `statisticreferee_game`=`statisticreferee_game`+'1'
                WHERE `statisticreferee_tournament_id`='$tournament_id'
                AND `statisticreferee_season_id`='$igosja_season_id'
                AND `statisticreferee_referee_id`='$referee_id'";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_game`=`statisticteam_game`+'1'
                WHERE `statisticteam_tournament_id`='$tournament_id'
                AND `statisticteam_season_id`='$igosja_season_id'
                AND `statisticteam_team_id` IN ('$home_team_id', '$guest_team_id')";
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
    }
}

function f_igosja_generator_standing()
//Обновляем турнирніе таблицы
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
}