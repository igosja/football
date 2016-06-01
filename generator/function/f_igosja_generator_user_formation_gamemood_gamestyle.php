<?php

function f_igosja_generator_user_formation_gamemood_gamestyle()
//Обновляем предпочтения пользователя по стилям/тактике
{
    $sql = "SELECT `guest_team`.`team_user_id` AS `guest_user_id`,
                   `guest_lineup`.`lineupmain_formation_id` AS `guest_formation_id`,
                   `guest_lineup`.`lineupmain_gamemood_id` AS `guest_gamemood_id`,
                   `guest_lineup`.`lineupmain_gamestyle_id` AS `guest_gamestyle_id`,
                   `home_team`.`team_user_id` AS `home_user_id`,
                   `home_lineup`.`lineupmain_formation_id` AS `home_formation_id`,
                   `home_lineup`.`lineupmain_gamemood_id` AS `home_gamemood_id`,
                   `home_lineup`.`lineupmain_gamestyle_id` AS `home_gamestyle_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `lineupmain` AS `home_lineup`
            ON (`home_lineup`.`lineupmain_team_id`=`game_home_team_id`
            AND `home_lineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `lineupmain` AS `guest_lineup`
            ON (`guest_lineup`.`lineupmain_team_id`=`game_guest_team_id`
            AND `guest_lineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_home_team_id`!='0'
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        for ($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $user       = 'home_user_id';
                $formation  = 'home_formation_id';
                $gamemood   = 'home_gamemood_id';
                $gamestyle  = 'home_gamestyle_id';
            }
            else
            {
                $user       = 'guest_user_id';
                $formation  = 'guest_formation_id';
                $gamemood   = 'guest_gamemood_id';
                $gamestyle  = 'guest_gamestyle_id';
            }

            $user_id        = $game_array[$i][$user];
            $formation_id   = $game_array[$i][$formation];
            $gamemood_id    = $game_array[$i][$gamemood];
            $gamestyle_id   = $game_array[$i][$gamestyle];

            if (0 != $user_id)
            {
                $sql = "SELECT COUNT(`userformation_id`) AS `count`
                        FROM `userformation`
                        WHERE `userformation_user_id`='$user_id'
                        AND `userformation_formation_id`='$formation_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `userformation`
                            SET `userformation_formation_id`='$formation_id',
                                `userformation_user_id`='$user_id',
                                `userformation_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `userformation`
                            SET `userformation_value`=`userformation_value`+'1'
                            WHERE `userformation_formation_id`='$formation_id'
                            AND `userformation_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT COUNT(`usergamemood_id`) AS `count`
                        FROM `usergamemood`
                        WHERE `usergamemood_user_id`='$user_id'
                        AND `usergamemood_gamemood_id`='$gamemood_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `usergamemood`
                            SET `usergamemood_gamemood_id`='$gamemood_id',
                                `usergamemood_user_id`='$user_id',
                                `usergamemood_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `usergamemood`
                            SET `usergamemood_value`=`usergamemood_value`+'1'
                            WHERE `usergamemood_gamemood_id`='$gamemood_id'
                            AND `usergamemood_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT COUNT(`usergamestyle_id`) AS `count`
                        FROM `usergamestyle`
                        WHERE `usergamestyle_user_id`='$user_id'
                        AND `usergamestyle_gamestyle_id`='$gamestyle_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `usergamestyle`
                            SET `usergamestyle_gamestyle_id`='$gamestyle_id',
                                `usergamestyle_user_id`='$user_id',
                                `usergamestyle_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `usergamestyle`
                            SET `usergamestyle_value`=`usergamestyle_value`+'1'
                            WHERE `usergamestyle_gamestyle_id`='$gamestyle_id'
                            AND `usergamestyle_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }

    $sql = "SELECT `guest_country`.`country_user_id` AS `guest_user_id`,
                   `guest_lineup`.`lineupmain_formation_id` AS `guest_formation_id`,
                   `guest_lineup`.`lineupmain_gamemood_id` AS `guest_gamemood_id`,
                   `guest_lineup`.`lineupmain_gamestyle_id` AS `guest_gamestyle_id`,
                   `home_country`.`country_user_id` AS `home_user_id`,
                   `home_lineup`.`lineupmain_formation_id` AS `home_formation_id`,
                   `home_lineup`.`lineupmain_gamemood_id` AS `home_gamemood_id`,
                   `home_lineup`.`lineupmain_gamestyle_id` AS `home_gamestyle_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `lineupmain` AS `home_lineup`
            ON (`home_lineup`.`lineupmain_country_id`=`game_home_country_id`
            AND `home_lineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `lineupmain` AS `guest_lineup`
            ON (`guest_lineup`.`lineupmain_country_id`=`game_guest_country_id`
            AND `guest_lineup`.`lineupmain_game_id`=`game_id`)
            LEFT JOIN `country` AS `home_country`
            ON `home_country`.`country_id`=`game_home_country_id`
            LEFT JOIN `country` AS `guest_country`
            ON `guest_country`.`country_id`=`game_guest_country_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_home_team_id`='0'
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        for ($j=0; $j<HOME_GUEST_LOOP; $j++)
        {
            if (0 == $j)
            {
                $user       = 'home_user_id';
                $formation  = 'home_formation_id';
                $gamemood   = 'home_gamemood_id';
                $gamestyle  = 'home_gamestyle_id';
            }
            else
            {
                $user       = 'guest_user_id';
                $formation  = 'guest_formation_id';
                $gamemood   = 'guest_gamemood_id';
                $gamestyle  = 'guest_gamestyle_id';
            }

            $user_id        = $game_array[$i][$user];
            $formation_id   = $game_array[$i][$formation];
            $gamemood_id    = $game_array[$i][$gamemood];
            $gamestyle_id   = $game_array[$i][$gamestyle];

            if (0 != $user_id)
            {
                $sql = "SELECT COUNT(`userformation_id`) AS `count`
                        FROM `userformation`
                        WHERE `userformation_user_id`='$user_id'
                        AND `userformation_formation_id`='$formation_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `userformation`
                            SET `userformation_formation_id`='$formation_id',
                                `userformation_user_id`='$user_id',
                                `userformation_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `userformation`
                            SET `userformation_value`=`userformation_value`+'1'
                            WHERE `userformation_formation_id`='$formation_id'
                            AND `userformation_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT COUNT(`usergamemood_id`) AS `count`
                        FROM `usergamemood`
                        WHERE `usergamemood_user_id`='$user_id'
                        AND `usergamemood_gamemood_id`='$gamemood_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `usergamemood`
                            SET `usergamemood_gamemood_id`='$gamemood_id',
                                `usergamemood_user_id`='$user_id',
                                `usergamemood_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `usergamemood`
                            SET `usergamemood_value`=`usergamemood_value`+'1'
                            WHERE `usergamemood_gamemood_id`='$gamemood_id'
                            AND `usergamemood_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT COUNT(`usergamestyle_id`) AS `count`
                        FROM `usergamestyle`
                        WHERE `usergamestyle_user_id`='$user_id'
                        AND `usergamestyle_gamestyle_id`='$gamestyle_id'";
                $count_sql = f_igosja_mysqli_query($sql);

                $count_array = $count_sql->fetch_all(1);

                $count = $count_array[0]['count'];

                if (0 == $count)
                {
                    $sql = "INSERT INTO `usergamestyle`
                            SET `usergamestyle_gamestyle_id`='$gamestyle_id',
                                `usergamestyle_user_id`='$user_id',
                                `usergamestyle_value`='1'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `usergamestyle`
                            SET `usergamestyle_value`=`usergamestyle_value`+'1'
                            WHERE `usergamestyle_gamestyle_id`='$gamestyle_id'
                            AND `usergamestyle_user_id`='$user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }

    usleep(1);

    print '.';
    flush();
}