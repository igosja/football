<?php

function f_igosja_generator_lineup_main_create()
//Создинае составов в командах, где их нет
{
    $sql_insert = array();

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_id`,
                   `guestlineup`.`lineupmain_id` AS `guestlineup_id`,
                   `homelineup`.`lineupmain_id` AS `homelineup_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineupmain` AS `homelineup`
            ON (`homelineup`.`lineupmain_team_id`=`game_home_team_id`
            AND `homelineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `lineupmain` AS `guestlineup`
            ON (`guestlineup`.`lineupmain_team_id`=`game_guest_team_id`
            AND `guestlineup`.`lineupmain_game_id`=`game_id`)
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND `game_home_team_id`!='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_lineup_id  = $game_array[$i]['homelineup_id'];
        $guest_lineup_id = $game_array[$i]['guestlineup_id'];
        $game_id         = $game_array[$i]['game_id'];

        if (!$home_lineup_id)
        {
            $home_team_id = $game_array[$i]['game_home_team_id'];
            $sql_insert[] = "('$game_id', '19', '4', '3', '0', '$home_team_id')";
        }

        if (!$guest_lineup_id)
        {
            $guest_team_id = $game_array[$i]['game_guest_team_id'];
            $sql_insert[]  = "('$game_id', '19', '4', '3', '0', '$guest_team_id')";
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `game_guest_country_id`,
                   `game_home_country_id`,
                   `game_id`,
                   `guestlineup`.`lineupmain_id` AS `guestlineup_id`,
                   `homelineup`.`lineupmain_id` AS `homelineup_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineupmain` AS `homelineup`
            ON (`homelineup`.`lineupmain_country_id`=`game_home_country_id`
            AND `homelineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `lineupmain` AS `guestlineup`
            ON (`guestlineup`.`lineupmain_country_id`=`game_guest_country_id`
            AND `guestlineup`.`lineupmain_game_id`=`game_id`)
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND `game_home_country_id`!='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_lineup_id  = $game_array[$i]['homelineup_id'];
        $guest_lineup_id = $game_array[$i]['guestlineup_id'];
        $game_id         = $game_array[$i]['game_id'];

        if (!$home_lineup_id)
        {
            $home_team_id = $game_array[$i]['game_home_country_id'];
            $sql_insert[] = "('$game_id', '19', '4', '3', '$home_team_id', '0')";
        }

        if (!$guest_lineup_id)
        {
            $guest_team_id = $game_array[$i]['game_guest_country_id'];
            $sql_insert[]  = "('$game_id', '19', '4', '3', '$guest_team_id', '0')";
        }

        usleep(1);

        print '.';
        flush();
    }

    $count_sql_insert = count($sql_insert);

    if (0 < $count_sql_insert)
    {
        $sql_insert = implode(',', $sql_insert);

        $sql = "INSERT INTO `lineupmain`
                (
                    `lineupmain_game_id`,
                    `lineupmain_formation_id`,
                    `lineupmain_gamemood_id`,
                    `lineupmain_gamestyle_id`,
                    `lineupmain_country_id`,
                    `lineupmain_team_id`
                )
                VALUES " . $sql_insert . ";";
        f_igosja_mysqli_query($sql);
    }
}