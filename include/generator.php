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
            $home_player_id_sql     = 'home_player_id_' . $j;
            $home_player_id         = $game_array[$i][$home_player_id_sql];

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

            $count_check = $check_array[0]['count_statistic'];

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
        $tournament_id  = $game_array[$i]['game_guest_team_id'];

        f_igosja_generator_decision($game_id, $home_team_id, $guest_team_id, $minute, $tournament_id);
        f_igosja_generator_decision($game_id, $guest_team_id, $home_team_id, $minute + 1, $tournament_id);
    }
}

function f_igosja_generator_decision($game_id, $team, $opponent, $minute, $tournament_id)
//Игрок принимает решение
{
    $decision = rand(1,6);

    f_igosja_generator_decision_result($game_id, $decision, $team, $opponent, $minute, $tournament_id);
}

function f_igosja_generator_decision_result($game_id, $decision, $team, $opponent, $minute, $tournament_id)
//Игрок пытается воплотить решение в жизнь
{
    global $mysqli;

    $player = rand(0, 10);

    $sql = "SELECT `lineup_player_id`,
                   `playerattribute_value`
            FROM `playerattribute`
            LEFT JOIN `lineup`
            ON `playerattribute_player_id`=`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_FIELD_VIEW . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char       = $char_array[0]['playerattribute_value'];

    $vision = rand($char, 200);

    if (200 == $vision)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='выводит передачей партнера один в один.'";
        $mysqli->query($sql);

        f_igosja_generator_one_on_one($game_id, $team, $opponent, $minute, $tournament_id, $player_id);
    }
    elseif (1 == $decision) //Удар
    {
        $air = f_igosja_generator_air_before_shot();
        f_igosja_generator_shot($game_id, $air, $team, $opponent, $minute, $tournament_id);
    }
    elseif (2 == $decision) //Навес
    {
        f_igosja_generator_air_pass($game_id, $team, $opponent, $minute, $tournament_id);
    }
    elseif (3 == $decision) //Прострел
    {
        f_igosja_generator_fast_pass($game_id, $team, $opponent, $minute, $tournament_id);
    }
    elseif (4 == $decision) //Пас длинный
    {
        f_igosja_generator_long_pass($game_id, $team, $opponent, $minute, $tournament_id);
    }
    elseif (5 == $decision) //Пас короткий
    {
        f_igosja_generator_pass($game_id, $team, $opponent, $minute, $tournament_id);
    }
    elseif (6 == $decision) //Дриблинг
    {
        f_igosja_generator_dribling($game_id, $team, $opponent, $minute, $tournament_id);
    }
}

function f_igosja_generator_air_before_shot()
//Высота передачи (верхом/низом)
{
    $air = rand(1,2);

    return $air;
}

function f_igosja_generator_shot($game_id, $air, $team, $opponent, $minute, $tournament_id, $player_pass = 0)
//Удар по воротам
{
    global $mysqli;
    global $igosja_season_id;

    if ($air == 1) //Удар с земли
    {
        $distance = rand(1,2);

        if (1 == $distance) //Близкое расстояние
        {
            if (0 == $player_pass)
            {
                $player_shot = rand(0, 9);
            }
            else
            {
                $player_shot = rand(0, 8);
            }

            $sql = "SELECT `lineup_id`,
                           `t2`.`lineup_player_id` AS `lineup_player_id`,
                           `playerattribute_composure`,
                           `playerattribute_concentration`,
                           `t1`.`playerattribute_value` AS `playerattribute_shot`
                    FROM `playerattribute` AS `t1`
                    LEFT JOIN `lineup` AS `t2`
                    ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                    LEFT JOIN
                    (
                        SELECT `lineup_player_id`,
                               `playerattribute_value` AS `playerattribute_composure`
                        FROM `playerattribute`
                        LEFT JOIN `lineup`
                        ON `playerattribute_player_id`=`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                        ORDER BY `lineup_position_id` ASC
                    ) AS `t3`
                    ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                    LEFT JOIN
                    (
                        SELECT `lineup_player_id`,
                               `playerattribute_value` AS `playerattribute_concentration`
                        FROM `playerattribute`
                        LEFT JOIN `lineup`
                        ON `playerattribute_player_id`=`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                        ORDER BY `lineup_position_id` ASC
                    ) AS `t4`
                    ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `t2`.`lineup_player_id`!='$player_pass'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_SHOT . "'
                    AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                    ORDER BY `lineup_position_id` ASC
                    LIMIT $player_shot, 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $lineup_id  = $char_array[0]['lineup_id'];
            $player_id  = $char_array[0]['lineup_player_id'];
            $char_1     = $char_array[0]['playerattribute_shot'];
            $char_2     = $char_array[0]['playerattribute_composure'];
            $char_3     = $char_array[0]['playerattribute_concentration'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
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
                            `broadcasting_team_id`='$team',
                            `broadcasting_text`='наносит удар с близкого расстояния.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_team_id`='$team'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $opposition = f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id);

                if (0 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='пробивает в створ.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                                `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$team'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_ontarget`=`lineup_ontarget`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $goalkeeper = f_igosja_generator_goalkeeper_opposition($game_id, $opponent);

                    if (0 == $goalkeeper)
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$team',
                                    `broadcasting_text`='отправляет мяч в сетку.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                                    `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                WHERE `statisticplayer_player_id`='$player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$igosja_season_id'
                                AND `statisticplayer_team_id`='$team'
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
                                    WHERE `statisticplayer_player_id`='$player_pass'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$igosja_season_id'
                                    AND `statisticplayer_team_id`='$team'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                    WHERE `lineup_player_id`='$player_pass'
                                    AND `lineup_game_id`='$game_id'";
                            $mysqli->query($sql);
                        }

                        $sql = "INSERT INTO `event`
                                SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                    `event_game_id`='$game_id',
                                    `event_minute`='$minute',
                                    `event_player_id`='$player_id',
                                    `event_team_id`='$team'";
                        $mysqli->query($sql);
                    }
                    else
                    {
                        $sql = "SELECT `lineup_player_id`
                                FROM `lineup`
                                WHERE `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$opponent'
                                AND `lineup_position_id`='" . GK_POSITION_ID . "'
                                LIMIT 1";
                        $char_sql = $mysqli->query($sql);

                        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                        $player_id = $char_array[0]['lineup_player_id'];

                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$opponent',
                                    `broadcasting_text`='нейтрализирует угрозу.'";
                        $mysqli->query($sql);

                        f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
                    }
                }
                elseif (1 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='пробивает мимо ворот.'";
                    $mysqli->query($sql);
                }
            }
            else
            {
                $sql = "SELECT `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$opponent'
                        AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                        ORDER BY RAND()
                        LIMIT 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $char_array[0]['lineup_player_id'];

                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$opponent',
                            `broadcasting_text`='блокируют удар.'";
                $mysqli->query($sql);
            }
        }
        else //Дальний удар
        {
            if (0 == $player_pass)
            {
                $player_shot = rand(0, 9);
            }
            else
            {
                $player_shot = rand(0, 8);
            }

            $sql = "SELECT `lineup_id`,
                           `t2`.`lineup_player_id` AS `lineup_player_id`,
                           `playerattribute_composure`,
                           `playerattribute_concentration`,
                           `t1`.`playerattribute_value` AS `playerattribute_long_shot`
                    FROM `playerattribute` AS `t1`
                    LEFT JOIN `lineup` AS `t2`
                    ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                    LEFT JOIN
                    (
                        SELECT `lineup_player_id`,
                               `playerattribute_value` AS `playerattribute_composure`
                        FROM `playerattribute`
                        LEFT JOIN `lineup`
                        ON `playerattribute_player_id`=`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                        ORDER BY `lineup_position_id` ASC
                    ) AS `t3`
                    ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                    LEFT JOIN
                    (
                        SELECT `lineup_player_id`,
                               `playerattribute_value` AS `playerattribute_concentration`
                        FROM `playerattribute`
                        LEFT JOIN `lineup`
                        ON `playerattribute_player_id`=`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                        ORDER BY `lineup_position_id` ASC
                    ) AS `t4`
                    ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_LONG_SHOT . "'
                    AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                    AND `t2`.`lineup_player_id`!='$player_pass'
                    ORDER BY `lineup_position_id` ASC
                    LIMIT $player_shot, 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $lineup_id  = $char_array[0]['lineup_id'];
            $player_id  = $char_array[0]['lineup_player_id'];
            $char_1     = $char_array[0]['playerattribute_long_shot'];
            $char_2     = $char_array[0]['playerattribute_composure'];
            $char_3     = $char_array[0]['playerattribute_concentration'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
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
                            `broadcasting_team_id`='$team',
                            `broadcasting_text`='наносит дальний удар.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_team_id`='$team'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $opposition = f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id);

                if (0 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='пробивает в створ.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                                `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$team'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_ontarget`=`lineup_ontarget`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);

                    $goalkeeper = f_igosja_generator_goalkeeper_opposition($game_id, $opponent);

                    if (0 == $goalkeeper)
                    {
                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$team',
                                    `broadcasting_text`='мяч в сетке.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                                    `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                WHERE `statisticplayer_player_id`='$player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$igosja_season_id'
                                AND `statisticplayer_team_id`='$team'
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
                                    WHERE `statisticplayer_player_id`='$player_pass'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$igosja_season_id'
                                    AND `statisticplayer_team_id`='$team'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                    WHERE `lineup_player_id`='$player_pass'
                                    AND `lineup_game_id`='$game_id'";
                            $mysqli->query($sql);
                        }

                        $sql = "INSERT INTO `event`
                                SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                    `event_game_id`='$game_id',
                                    `event_minute`='$minute',
                                    `event_player_id`='$player_id',
                                    `event_team_id`='$team'";
                        $mysqli->query($sql);
                    }
                    else
                    {
                        $sql = "SELECT `lineup_player_id`
                                FROM `lineup`
                                WHERE `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$opponent'
                                AND `lineup_position_id`='" . GK_POSITION_ID . "'
                                LIMIT 1";
                        $char_sql = $mysqli->query($sql);

                        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                        $player_id = $char_array[0]['lineup_player_id'];

                        $sql = "INSERT INTO `broadcasting`
                                SET `broadcasting_game_id`='$game_id',
                                    `broadcasting_minute`='$minute',
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$opponent',
                                    `broadcasting_text`='нейтрализирует угрозу.'";
                        $mysqli->query($sql);

                        f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
                    }
                }
                elseif (1 == $opposition)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='пробивает мимо ворот.'";
                    $mysqli->query($sql);
                }
            }
            else
            {
                $sql = "SELECT `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$opponent'
                        AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                        ORDER BY RAND()
                        LIMIT 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $char_array[0]['lineup_player_id'];

                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$opponent',
                            `broadcasting_text`='блокируют удар.'";
                $mysqli->query($sql);
            }
        }
    }
    else //Удар головой
    {
        if (0 == $player_pass)
        {
            $player_shot = rand(0, 9);
        }
        else
        {
            $player_shot = rand(0, 8);
        }

        $sql = "SELECT `lineup_id`,
                       `t2`.`lineup_player_id` AS `lineup_player_id`,
                       `player_height`,
                       `playerattribute_choise_position`,
                       `playerattribute_composure`,
                       `playerattribute_concentration`,
                       `playerattribute_coordinate`,
                       `playerattribute_dexterity`,
                       `playerattribute_jump`,
                       `t1`.`playerattribute_value` AS `playerattribute_head`
                FROM `playerattribute` AS `t1`
                LEFT JOIN `lineup` AS `t2`
                ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN `player`
                ON `player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_composure`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t3`
                ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_concentration`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t4`
                ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_choise_position`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CHOISE_POSITION . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t5`
                ON `t5`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_jump`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_JUMP . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t6`
                ON `t6`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_coordinate`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_COORDINATE . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t7`
                ON `t7`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_dexterity`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_DEXTERITY . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t8`
                ON `t8`.`lineup_player_id`=`t2`.`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_HEAD . "'
                AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                AND `t2`.`lineup_player_id`!='$player_pass'
                ORDER BY `lineup_position_id` ASC
                LIMIT $player_shot, 1";
        $char_sql = $mysqli->query($sql);

        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

        $lineup_id  = $char_array[0]['lineup_id'];
        $player_id  = $char_array[0]['lineup_player_id'];
        $char_1     = $char_array[0]['playerattribute_head'];
        $char_2     = $char_array[0]['playerattribute_choise_position'];
        $char_3     = $char_array[0]['playerattribute_jump'];
        $char_4     = $char_array[0]['playerattribute_concentration'];
        $char_5     = $char_array[0]['playerattribute_coordinate'];
        $char_6     = $char_array[0]['playerattribute_dexterity'];
        $char_7     = $char_array[0]['playerattribute_composure'];
        $char_8     = $char_array[0]['player_height'];

        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='пытается сыгать головой.'";
        $mysqli->query($sql);

        $char = ($char_1 + ($char_2 + $char_3 + $char_8 / 2) * 50 / 100 + ($char_4 + $char_5 + $char_6 + $char_7) * 25 / 100) / 3.5;

        $success = f_igosja_generator_success($char);

        if (1 == $success)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='провибает головой.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                        `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1')
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$team'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_shot`=`lineup_shot`+'1'
                    WHERE `lineup_id`='$lineup_id'";
            $mysqli->query($sql);

            $opposition = f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id);

            if (0 == $opposition)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team',
                            `broadcasting_text`='мяч летит в створ ворот.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                            `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_team_id`='$team'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_ontarget`=`lineup_ontarget`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $goalkeeper = f_igosja_generator_goalkeeper_opposition($game_id, $opponent);

                if (0 == $goalkeeper)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='забивает мяч в ворота.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                                `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$team'
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
                                WHERE `statisticplayer_player_id`='$player_pass'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$igosja_season_id'
                                AND `statisticplayer_team_id`='$team'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                                WHERE `lineup_player_id`='$player_pass'
                                AND `lineup_game_id`='$game_id'";
                        $mysqli->query($sql);
                    }

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$team'";
                    $mysqli->query($sql);
                }
                else
                {
                    $sql = "SELECT `lineup_player_id`
                            FROM `lineup`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$opponent'
                            AND `lineup_position_id`='" . GK_POSITION_ID . "'
                            LIMIT 1";
                    $char_sql = $mysqli->query($sql);

                    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                    $player_id = $char_array[0]['lineup_player_id'];

                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$player_id',
                                `broadcasting_team_id`='$opponent',
                                `broadcasting_text`='читает ситуацию.'";
                    $mysqli->query($sql);

                    f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
                }
            }
            elseif (1 == $opposition)
            {
                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$team',
                            `broadcasting_text`='мяч летит мимо ворот.'";
                $mysqli->query($sql);
            }
        }
        else
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$opponent'
                    AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$opponent',
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

function f_igosja_generator_air_pass($game_id, $team, $opponent, $minute, $tournament_id)
//Навес
{
    global $mysqli;

    $player_air_pass = rand(0, 9);

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `t1`.`playerattribute_value` AS `playerattribute_air_pass`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_AIR_PASS . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_air_pass, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_air_pass'];
    $char_2     = $char_array[0]['playerattribute_composure'];
    $char_3     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $air_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team',
                `broadcasting_text`='пытается сделать навес в штрафную.'";
    $mysqli->query($sql);

    if (150 < $air_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='навешивает в сторону штрафной площадки.'";
        $mysqli->query($sql);

        f_igosja_generator_shot($game_id, 2, $team, $opponent, $minute, $tournament_id, $player_id);
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='неудачно навешивает.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_fast_pass($game_id, $team, $opponent, $minute, $tournament_id)
//Простел
{
    global $mysqli;

    $player_fast_pass = rand(0, 9);

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `t1`.`playerattribute_value` AS `playerattribute_air_pass`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `playerattribute_pass`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_pass`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_PASS . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t5`
            ON `t5`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_AIR_PASS . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_fast_pass, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_air_pass'];
    $char_2     = $char_array[0]['playerattribute_pass'];
    $char_3     = $char_array[0]['playerattribute_composure'];
    $char_4     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);

    $fast_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team',
                `broadcasting_text`='пытается прострелить.'";
    $mysqli->query($sql);

    if (150 < $fast_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='простеливает в штрафную.'";
        $mysqli->query($sql);

        $opposition = f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id);

        if (0 == $opposition)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='удачно находит партнера своим прострелом.'";
            $mysqli->query($sql);

            f_igosja_generator_shot($game_id, 1, $team, $opponent, $minute, $tournament_id, $player_id);
        }
        elseif (1 == $opposition)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$opponent'
                    AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$opponent',
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
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='простреливает крайне неточно.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_long_pass($game_id, $team, $opponent, $minute, $tournament_id)
//Диагональная передача
{
    global $mysqli;

    $player_long_pass = rand(0, 9);

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `t1`.`playerattribute_value` AS `playerattribute_air_pass`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `playerattribute_pass`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_pass`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_PASS . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t5`
            ON `t5`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_AIR_PASS . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_long_pass, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_air_pass'];
    $char_2     = $char_array[0]['playerattribute_pass'];
    $char_3     = $char_array[0]['playerattribute_composure'];
    $char_4     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);

    $long_pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team',
                `broadcasting_text`='пытается отдать длинную диагональ.'";
    $mysqli->query($sql);

    if (150 < $long_pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='отдает передачу, что надо.'";
        $mysqli->query($sql);

        $taking = f_igosja_generator_taking($game_id, $team);

        if (1 == $taking)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `lineup_position_id` NOT IN ('" . GK_POSITION_ID . "', '$player_id')
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='качественно принимает длинный пас.'";
            $mysqli->query($sql);

            $opposition = f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id);

            if (0 == $opposition)
            {
                f_igosja_generator_decision($game_id, $team, $opponent, $minute, $tournament_id);
            }
            elseif (1 == $opposition)
            {
                $sql = "SELECT `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$opponent'
                        AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                        ORDER BY RAND()
                        LIMIT 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $player_id = $char_array[0]['lineup_player_id'];

                $sql = "INSERT INTO `broadcasting`
                        SET `broadcasting_game_id`='$game_id',
                            `broadcasting_minute`='$minute',
                            `broadcasting_player_id`='$player_id',
                            `broadcasting_team_id`='$opponent',
                            `broadcasting_text`='прессингует и отбирает мяч.'";
                $mysqli->query($sql);
            }
        }
        else
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `lineup_position_id` NOT IN ('" . GK_POSITION_ID . "', '$player_id')
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
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
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='отдает передачу очень не точно.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_pass($game_id, $team, $opponent, $minute, $tournament_id)
//Обостряющий пас в разрез
{
    global $mysqli;

    $player_pass = rand(0, 9);

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `t1`.`playerattribute_value` AS `playerattribute_pass`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_PASS . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_pass, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_pass'];
    $char_2     = $char_array[0]['playerattribute_composure'];
    $char_3     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $pass = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team',
                `broadcasting_text`='пытается отдать обостряющую передачу.'";
    $mysqli->query($sql);

    if (150 < $pass)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='хорошо пасует на партнера.'";
        $mysqli->query($sql);

        $taking = f_igosja_generator_taking($game_id, $team);

        if (1 == $taking)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `lineup_position_id` NOT IN ('" . GK_POSITION_ID . "', '$player_id')
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='хорошо обрабатывает мяч.'";
            $mysqli->query($sql);

            f_igosja_generator_decision($game_id, $team, $opponent, $minute, $tournament_id);
        }
        else
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `lineup_position_id` NOT IN ('" . GK_POSITION_ID . "', '$player_id')
                    ORDER BY RAND()
                    LIMIT 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
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
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='отдает мяч сопернику.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_dribling($game_id, $team, $opponent, $minute, $tournament_id)
//Обводка соперника
{
    global $mysqli;

    $player_dribling = rand(0, 9);

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `t1`.`playerattribute_value` AS `playerattribute_dribling`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_DRIBLING . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_dribling, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_dribling'];
    $char_2     = $char_array[0]['playerattribute_composure'];
    $char_3     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $dribling = rand($char, 200);

    $sql = "INSERT INTO `broadcasting`
            SET `broadcasting_game_id`='$game_id',
                `broadcasting_minute`='$minute',
                `broadcasting_player_id`='$player_id',
                `broadcasting_team_id`='$team',
                `broadcasting_text`='идет в обыгрыш.'";
    $mysqli->query($sql);

    if (150 < $dribling)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='технично освобождается от опеки соперника.'";
        $mysqli->query($sql);

        f_igosja_generator_decision($game_id, $team, $opponent, $minute, $tournament_id);
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='теряет мяч при попытке дриблинга.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_taking($game_id, $team)
//Прием мяча
{
    global $mysqli;

    $player_taking = rand(0, 9);

    $sql = "SELECT `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `t1`.`playerattribute_value` AS `playerattribute_taking`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_TAKING . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_taking, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $char_1 = $char_array[0]['playerattribute_taking'];
    $char_2 = $char_array[0]['playerattribute_composure'];
    $char_3 = $char_array[0]['playerattribute_concentration'];

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

function f_igosja_generator_opposition($game_id, $team, $opponent, $minute, $tournament_id)
//Отбор мяча
{
    global $mysqli;
    global $igosja_season_id;

    $player_opposition = rand(0, 9);

    $sql = "SELECT `lineup_id`,
                   `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `playerattribute_agression`,
                   `playerattribute_brave`,
                   `playerattribute_choise_position`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `playerattribute_coordinate`,
                   `playerattribute_dexterity`,
                   `playerattribute_famble`,
                   `playerattribute_serviceability`,
                   `t1`.`playerattribute_value` AS `playerattribute_pressing`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_famble`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_FAMBLE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t5`
            ON `t5`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_choise_position`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CHOISE_POSITION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t6`
            ON `t6`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_coordinate`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COORDINATE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t7`
            ON `t7`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_dexterity`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_DEXTERITY . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t8`
            ON `t8`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_serviceability`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_SERVICEABILITY . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t9`
            ON `t9`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_brave`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_BRAVE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t10`
            ON `t10`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_agression`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_AGRESSION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t11`
            ON `t11`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$opponent'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_PRESSING . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_opposition, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $lineup_id  = $char_array[0]['lineup_id'];
    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_pressing'];
    $char_2     = $char_array[0]['playerattribute_famble'];
    $char_3     = $char_array[0]['playerattribute_composure'];
    $char_4     = $char_array[0]['playerattribute_concentration'];
    $char_5     = $char_array[0]['playerattribute_choise_position'];
    $char_6     = $char_array[0]['playerattribute_coordinate'];
    $char_7     = $char_array[0]['playerattribute_dexterity'];
    $char_8     = $char_array[0]['playerattribute_serviceability'];
    $char_9     = $char_array[0]['playerattribute_brave'];
    $char_10    = $char_array[0]['playerattribute_agression'];

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
                        `broadcasting_team_id`='$opponent',
                        `broadcasting_text`='отбирает мяч с нарушением правил.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_foul`=IF(`game_home_team_id`='$team',`game_home_foul`,`game_home_foul`+'1'),
                        `game_guest_foul`=IF(`game_home_team_id`='$team',`game_guest_foul`+'1',`game_guest_foul`)
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_foul`=`statisticplayer_foul`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$opponent'
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
                            `broadcasting_team_id`='$opponent',
                            `broadcasting_text`='фолит в своей штрафной. Пенальти.'";
                $mysqli->query($sql);

                $sql = "UPDATE `game`
                        SET `game_home_penalty`=IF(`game_home_team_id`='$team',`game_home_penalty`+'1',`game_home_penalty`),
                            `game_guest_penalty`=IF(`game_home_team_id`='$team',`game_guest_penalty`,`game_guest_penalty`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $player_shot = rand(0, 9);

                $sql = "SELECT `lineup_id`,
                               `t2`.`lineup_player_id` AS `lineup_player_id`,
                               `playerattribute_composure`,
                               `playerattribute_concentration`,
                               `t1`.`playerattribute_value` AS `playerattribute_penalty`
                        FROM `playerattribute` AS `t1`
                        LEFT JOIN `lineup` AS `t2`
                        ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                        LEFT JOIN
                        (
                            SELECT `lineup_player_id`,
                                   `playerattribute_value` AS `playerattribute_composure`
                            FROM `playerattribute`
                            LEFT JOIN `lineup`
                            ON `playerattribute_player_id`=`lineup_player_id`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$team'
                            AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                            ORDER BY `lineup_position_id` ASC
                        ) AS `t3`
                        ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                        LEFT JOIN
                        (
                            SELECT `lineup_player_id`,
                                   `playerattribute_value` AS `playerattribute_concentration`
                            FROM `playerattribute`
                            LEFT JOIN `lineup`
                            ON `playerattribute_player_id`=`lineup_player_id`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$team'
                            AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                            ORDER BY `lineup_position_id` ASC
                        ) AS `t4`
                        ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_PENALTY . "'
                        AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                        ORDER BY `lineup_position_id` ASC
                        LIMIT $player_shot, 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $lineup_id  = $char_array[0]['lineup_id'];
                $pl_id      = $char_array[0]['lineup_player_id'];
                $char_1     = $char_array[0]['playerattribute_penalty'];
                $char_2     = $char_array[0]['playerattribute_composure'];
                $char_3     = $char_array[0]['playerattribute_concentration'];

                $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5) * 10;
    
                $sql = "UPDATE `game`
                        SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                            `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                            `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1'),
                            `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                        WHERE `game_id`='$game_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_penalty`=`statisticplayer_penalty`+'1',
                            `statisticplayer_shot`=`statisticplayer_shot`+'1',
                            `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$pl_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_team_id`='$team'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1',
                            `lineup_ontarget`=`lineup_ontarget`+'1',
                            `lineup_penalty`=`lineup_penalty`+'1'
                        WHERE `lineup_id`='$lineup_id'";
                $mysqli->query($sql);

                $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                               `t1`.`playerattribute_value` AS `playerattribute_penalty`
                        FROM `playerattribute` AS `t1`
                        LEFT JOIN `lineup` AS `t2`
                        ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$opponent'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_GK_PENALTY . "'
                        AND `lineup_position_id`='" . GK_POSITION_ID . "'
                        ORDER BY RAND()
                        LIMIT 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $gk_id  = $char_array[0]['lineup_player_id'];
                $char_1 = $char_array[0]['playerattribute_penalty'];

                $goalkeeper = rand($char_1, 200);

                if ($char > $goalkeeper)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$pl_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='реализовывает пенальти.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                                `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`+'1',
                                `statisticplayer_goal`=`statisticplayer_goal`+'1'
                            WHERE `statisticplayer_player_id`='$pl_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$team'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$pl_id',
                                `event_team_id`='$team'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_goal`=`lineup_goal`+'1',
                                `lineup_penalty_goal`=`lineup_penalty_goal`+'1'
                            WHERE `lineup_id`='$lineup_id'";
                    $mysqli->query($sql);
                }
                else
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$gk_id',
                                `broadcasting_team_id`='$opponent',
                                `broadcasting_text`='спасает команду.'";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_NO_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$pl_id',
                                `event_team_id`='$team'";
                    $mysqli->query($sql);

                    f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
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
                                `broadcasting_team_id`='$opponent',
                                `broadcasting_text`='отправляется в раздевалку. Красная карточка.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_red`=IF(`game_home_team_id`='$opponent',`game_home_red`+'1',`game_home_red`),
                                `game_guest_red`=IF(`game_home_team_id`='$opponent',`game_guest_red`,`game_guest_red`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_red`=`statisticplayer_red`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$opponent'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_RED . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$opponent'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_red`=`lineup_red`+'1'
                            WHERE `lineup_id`='$lineup_id'";
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
                                `broadcasting_team_id`='$opponent',
                                `broadcasting_text`='получает желтую.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_yellow`=IF(`game_home_team_id`='$opponent',`game_home_yellow`+'1',`game_home_yellow`),
                                `game_guest_yellow`=IF(`game_home_team_id`='$opponent',`game_guest_yellow`,`game_guest_yellow`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_yellow`=`statisticplayer_yellow`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$opponent'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_YELLOW . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$player_id',
                                `event_team_id`='$opponent'";
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

                $player_shot = rand(0, 9);

                $sql = "SELECT `lineup_id`,
                               `t2`.`lineup_player_id` AS `lineup_player_id`,
                               `playerattribute_composure`,
                               `playerattribute_concentration`,
                               `t1`.`playerattribute_value` AS `playerattribute_free_kick`
                        FROM `playerattribute` AS `t1`
                        LEFT JOIN `lineup` AS `t2`
                        ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                        LEFT JOIN
                        (
                            SELECT `lineup_player_id`,
                                   `playerattribute_value` AS `playerattribute_composure`
                            FROM `playerattribute`
                            LEFT JOIN `lineup`
                            ON `playerattribute_player_id`=`lineup_player_id`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$team'
                            AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                            ORDER BY `lineup_position_id` ASC
                        ) AS `t3`
                        ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                        LEFT JOIN
                        (
                            SELECT `lineup_player_id`,
                                   `playerattribute_value` AS `playerattribute_concentration`
                            FROM `playerattribute`
                            LEFT JOIN `lineup`
                            ON `playerattribute_player_id`=`lineup_player_id`
                            WHERE `lineup_game_id`='$game_id'
                            AND `lineup_team_id`='$team'
                            AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                            ORDER BY `lineup_position_id` ASC
                        ) AS `t4`
                        ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team'
                        AND `playerattribute_attribute_id`='" . ATTRIBUTE_FREE_KICK . "'
                        AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                        ORDER BY `lineup_position_id` ASC
                        LIMIT $player_shot, 1";
                $char_sql = $mysqli->query($sql);

                $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                $lineup_id  = $char_array[0]['lineup_id'];
                $pl_id      = $char_array[0]['lineup_player_id'];
                $char_1     = $char_array[0]['playerattribute_free_kick'];
                $char_2     = $char_array[0]['playerattribute_composure'];
                $char_3     = $char_array[0]['playerattribute_concentration'];

                $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

                $success = f_igosja_generator_success($char);

                if (1 == $success)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$pl_id',
                                `broadcasting_team_id`='$team',
                                `broadcasting_text`='пробивает со штрафного.'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `game`
                            SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                                `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1')
                            WHERE `game_id`='$game_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "UPDATE `statisticplayer`
                            SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                            WHERE `statisticplayer_player_id`='$player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$igosja_season_id'
                            AND `statisticplayer_team_id`='$opponent'
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
                                    `broadcasting_player_id`='$player_id',
                                    `broadcasting_team_id`='$team',
                                    `broadcasting_text`='направляет мяч в створ ворот.'";
                        $mysqli->query($sql);

                        $sql = "UPDATE `game`
                                SET `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                                    `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                                WHERE `game_id`='$game_id'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `statisticplayer`
                                SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                                WHERE `statisticplayer_player_id`='$player_id'
                                AND `statisticplayer_tournament_id`='$tournament_id'
                                AND `statisticplayer_season_id`='$igosja_season_id'
                                AND `statisticplayer_team_id`='$opponent'
                                LIMIT 1";
                        $mysqli->query($sql);

                        $sql = "UPDATE `lineup`
                                SET `lineup_ontarget`=`lineup_ontarget`+'1'
                                WHERE `lineup_id`='$lineup_id'";
                        $mysqli->query($sql);

                        $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                                       `t1`.`playerattribute_value` AS `playerattribute_free_kick`
                                FROM `playerattribute` AS `t1`
                                LEFT JOIN `lineup` AS `t2`
                                ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                                WHERE `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$opponent'
                                AND `playerattribute_attribute_id`='" . ATTRIBUTE_GK_FREE_KICK . "'
                                AND `lineup_position_id`='" . GK_POSITION_ID . "'
                                LIMIT 1";
                        $char_sql = $mysqli->query($sql);

                        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

                        $gk_id          = $char_array[0]['lineup_player_id'];
                        $char_g         = $char_array[0]['playerattribute_free_kick'];
                        $player_free    = rand($char_1, 200);
                        $gk_free        = rand($char_g, 200);

                        if ($player_free > $gk_free)
                        {
                            $sql = "INSERT INTO `broadcasting`
                                    SET `broadcasting_game_id`='$game_id',
                                        `broadcasting_minute`='$minute',
                                        `broadcasting_player_id`='$pl_id',
                                        `broadcasting_team_id`='$team',
                                        `broadcasting_text`='забивает гол.'";
                            $mysqli->query($sql);
    
                            $sql = "UPDATE `game`
                                    SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                                        `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                                    WHERE `game_id`='$game_id'
                                    LIMIT 1";
                            $mysqli->query($sql);

                            $sql = "UPDATE `statisticplayer`
                                    SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                                    WHERE `statisticplayer_player_id`='$pl_id'
                                    AND `statisticplayer_tournament_id`='$tournament_id'
                                    AND `statisticplayer_season_id`='$igosja_season_id'
                                    AND `statisticplayer_team_id`='$team'
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
                                        `event_player_id`='$pl_id',
                                        `event_team_id`='$team'";
                            $mysqli->query($sql);
                        }
                        else
                        {
                            $sql = "INSERT INTO `broadcasting`
                                    SET `broadcasting_game_id`='$game_id',
                                        `broadcasting_minute`='$minute',
                                        `broadcasting_player_id`='$gk_id',
                                        `broadcasting_team_id`='$opponent',
                                        `broadcasting_text`='нейтрализирует угрозу.'";
                            $mysqli->query($sql);

                            f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
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

function f_igosja_generator_goalkeeper_opposition($game_id, $opponent, $tournament_id)
//Игра вратаря
{
    global $mysqli;

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `playerattribute_catch`,
                   `playerattribute_coordinate`,
                   `playerattribute_dexterity`,
                   `playerattribute_hands`,
                   `playerattribute_in_area`,
                   `t1`.`playerattribute_value` AS `playerattribute_reaction`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_coordinate`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COORDINATE . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_hands`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_HANDS . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_in_area`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_IN_AREA . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
            ) AS `t5`
            ON `t5`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_catch`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CATCH . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
            ) AS `t6`
            ON `t6`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_dexterity`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_DEXTERITY . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
            ) AS `t7`
            ON `t7`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$opponent'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_REACTION . "'
            AND `lineup_position_id`='" . GK_POSITION_ID . "'
            LIMIT 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $char_1 = $char_array[0]['playerattribute_reaction'];
    $char_2 = $char_array[0]['playerattribute_hands'];
    $char_3 = $char_array[0]['playerattribute_in_area'];
    $char_4 = $char_array[0]['playerattribute_catch'];
    $char_5 = $char_array[0]['playerattribute_dexterity'];
    $char_6 = $char_array[0]['playerattribute_coordinate'];

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

function f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id)
//Угловой
{
    global $mysqli;

    $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `t1`.`playerattribute_value` AS `playerattribute_catch`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$opponent'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_CATCH . "'
            AND `lineup_position_id`='" . GK_POSITION_ID . "'
            LIMIT 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $player_id  = $char_array[0]['lineup_player_id'];
    $char       = $char_array[0]['playerattribute_catch'];

    $gk_play = rand(100, 100 + $char);

    if (150 < $gk_play)
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$opponent',
                    `broadcasting_text`='переводит мяч на угловой.'";
        $mysqli->query($sql);

        $sql = "UPDATE `game`
                SET `game_home_corner`=IF(`game_home_team_id`='$team',`game_home_corner`+'1',`game_home_corner`),
                    `game_guest_corner`=IF(`game_home_team_id`='$team',`game_guest_corner`,`game_guest_corner`+'1')
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        $player_corner = rand(0, 9);

        $sql = "SELECT `t2`.`lineup_player_id` AS `lineup_player_id`,
                       `playerattribute_composure`,
                       `playerattribute_concentration`,
                       `t1`.`playerattribute_value` AS `playerattribute_corner`
                FROM `playerattribute` AS `t1`
                LEFT JOIN `lineup` AS `t2`
                ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_composure`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t3`
                ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
                LEFT JOIN
                (
                    SELECT `lineup_player_id`,
                           `playerattribute_value` AS `playerattribute_concentration`
                    FROM `playerattribute`
                    LEFT JOIN `lineup`
                    ON `playerattribute_player_id`=`lineup_player_id`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                    ORDER BY `lineup_position_id` ASC
                ) AS `t4`
                ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CORNER . "'
                AND `lineup_position_id`!='" . GK_POSITION_ID . "'
                ORDER BY `lineup_position_id` ASC
                LIMIT $player_corner, 1";
        $char_sql = $mysqli->query($sql);

        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

        $player_id  = $char_array[0]['lineup_player_id'];
        $char_1     = $char_array[0]['playerattribute_corner'];
        $char_2     = $char_array[0]['playerattribute_composure'];
        $char_3     = $char_array[0]['playerattribute_concentration'];

        $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

        $air_pass = rand($char, 200);

        if (170 < $air_pass)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='навешивает с углового на партнера.'";
            $mysqli->query($sql);

            f_igosja_generator_shot($game_id, 2, $team, $opponent, $minute, $tournament_id, $player_id);
        }
        else
        {
            $player_defence = rand(0, 9);

            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$opponent'
                    ORDER BY `lineup_position_id` ASC
                    LIMIT $player_defence, 1";
            $char_sql = $mysqli->query($sql);

            $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

            $player_id = $char_array[0]['lineup_player_id'];

            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$opponent',
                        `broadcasting_text`='выбивает мяч после углового.'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$opponent',
                    `broadcasting_text`='забирает мяч в руки.'";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_one_on_one($game_id, $team, $opponent, $minute, $tournament_id, $player_pass)
//Выход 1 в 1
{
    global $mysqli;
    global $igosja_season_id;

    $player_shot = rand(0, 8);

    $sql = "SELECT `lineup_id`,
                   `t2`.`lineup_player_id` AS `lineup_player_id`,
                   `playerattribute_composure`,
                   `playerattribute_concentration`,
                   `t1`.`playerattribute_value` AS `playerattribute_shot`
            FROM `playerattribute` AS `t1`
            LEFT JOIN `lineup` AS `t2`
            ON `t1`.`playerattribute_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_composure`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_COMPOSURE . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t3`
            ON `t3`.`lineup_player_id`=`t2`.`lineup_player_id`
            LEFT JOIN
            (
                SELECT `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_concentration`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_CONCENTRATION . "'
                ORDER BY `lineup_position_id` ASC
            ) AS `t4`
            ON `t4`.`lineup_player_id`=`t2`.`lineup_player_id`
            WHERE `lineup_game_id`='$game_id'
            AND `lineup_team_id`='$team'
            AND `playerattribute_attribute_id`='" . ATTRIBUTE_SHOT . "'
            AND `lineup_position_id`!='" . GK_POSITION_ID . "'
            AND `t2`.`lineup_player_id`!='$player_pass'
            ORDER BY `lineup_position_id` ASC
            LIMIT $player_shot, 1";
    $char_sql = $mysqli->query($sql);

    $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

    $lineup_id  = $char_array[0]['lineup_id'];
    $player_id  = $char_array[0]['lineup_player_id'];
    $char_1     = $char_array[0]['playerattribute_shot'];
    $char_2     = $char_array[0]['playerattribute_composure'];
    $char_3     = $char_array[0]['playerattribute_concentration'];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);

    $success = f_igosja_generator_success($char);

    if (1 == $success)
    {
        $sql = "UPDATE `game`
                SET `game_home_shot`=IF(`game_home_team_id`='$team',`game_home_shot`+'1',`game_home_shot`),
                    `game_home_ontarget`=IF(`game_home_team_id`='$team',`game_home_ontarget`+'1',`game_home_ontarget`),
                    `game_guest_shot`=IF(`game_home_team_id`='$team',`game_guest_shot`,`game_guest_shot`+'1'),
                    `game_guest_ontarget`=IF(`game_home_team_id`='$team',`game_guest_ontarget`,`game_guest_ontarget`+'1')
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
                    `broadcasting_text`='пытается переиграть вратаря.'";
        $mysqli->query($sql);

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_shot`=`statisticplayer_shot`+'1',
                    `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_team_id`='$team'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_shot`=`lineup_shot`+'1',
                    `lineup_ontarget`=`lineup_ontarget`+'1'
                WHERE `lineup_id`='$lineup_id'";
        $mysqli->query($sql);

        $sql = "SELECT `lineup_player_id` AS `lineup_player_id`,
                       `playerattribute_value` AS `playerattribute_one_on_one`
                FROM `playerattribute`
                LEFT JOIN `lineup`
                ON `playerattribute_player_id`=`lineup_player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$opponent'
                AND `playerattribute_attribute_id`='" . ATTRIBUTE_ONE_ON_ONE . "'
                AND `lineup_position_id`='" . GK_POSITION_ID . "'
                LIMIT 1";
        $char_sql = $mysqli->query($sql);

        $char_array = $char_sql->fetch_all(MYSQLI_ASSOC);

        $gk_id  = $char_array[0]['lineup_player_id'];
        $char_1 = $char_array[0]['playerattribute_one_on_one'];

        $gk_play = rand($char_1, 200);

        if (150 < $gk_play)
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$gk_id',
                        `broadcasting_team_id`='$opponent',
                        `broadcasting_text`='спасает команду.'";
            $mysqli->query($sql);

            f_igosja_generator_corner($game_id, $team, $opponent, $minute, $tournament_id);
        }
        else
        {
            $sql = "INSERT INTO `broadcasting`
                    SET `broadcasting_game_id`='$game_id',
                        `broadcasting_minute`='$minute',
                        `broadcasting_player_id`='$player_id',
                        `broadcasting_team_id`='$team',
                        `broadcasting_text`='реализует выход 1 на 1.'";
            $mysqli->query($sql);

            $sql = "UPDATE `game`
                    SET `game_home_score`=IF(`game_home_team_id`='$team',`game_home_score`+'1',`game_home_score`),
                        `game_guest_score`=IF(`game_home_team_id`='$team',`game_guest_score`,`game_guest_score`+'1')
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                    WHERE `statisticplayer_player_id`='$player_id'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$team'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                    WHERE `statisticplayer_player_id`='$player_pass'
                    AND `statisticplayer_tournament_id`='$tournament_id'
                    AND `statisticplayer_season_id`='$igosja_season_id'
                    AND `statisticplayer_team_id`='$team'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                    WHERE `lineup_player_id`='$payer_pass'
                    AND `lineup_game_id`='$game_id'";
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
                        `event_team_id`='$team'";
            $mysqli->query($sql);
        }
    }
    else
    {
        $sql = "INSERT INTO `broadcasting`
                SET `broadcasting_game_id`='$game_id',
                    `broadcasting_minute`='$minute',
                    `broadcasting_player_id`='$player_id',
                    `broadcasting_team_id`='$team',
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