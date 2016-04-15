<?php

function f_igosja_generator_statistic_team_user_referee()
//Обновляем статистику команд, пользоватей и судей
{
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_country_id`,
                   `game_guest_foul`,
                   `game_guest_ontarget`,
                   `game_guest_penalty`,
                   `game_guest_red`,
                   `game_guest_shot`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_guest_yellow`,
                   `game_home_country_id`,
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
                   `guest_country`.`country_user_id` AS `guest_country_user_id`,
                   `home_team`.`team_user_id` AS `home_user_id`,
                   `home_country`.`country_user_id` AS `home_country_user_id`,
                   `stadium_capacity`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            LEFT JOIN `country` AS `home_country`
            ON `home_country`.`country_id`=`game_home_country_id`
            LEFT JOIN `country` AS `guest_country`
            ON `guest_country`.`country_id`=`game_guest_country_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id                = $game_array[$i]['game_id'];
        $home_country_id        = $game_array[$i]['game_home_country_id'];
        $home_team_id           = $game_array[$i]['game_home_team_id'];
        $home_user_id           = $game_array[$i]['home_user_id'];
        $home_country_user_id   = $game_array[$i]['home_country_user_id'];
        $home_foul              = $game_array[$i]['game_home_foul'];
        $home_ontarget          = $game_array[$i]['game_home_ontarget'];
        $home_score             = $game_array[$i]['game_home_score'];
        $home_shot              = $game_array[$i]['game_home_shot'];
        $home_penalty           = $game_array[$i]['game_home_penalty'];
        $home_red               = $game_array[$i]['game_home_red'];
        $home_yellow            = $game_array[$i]['game_home_yellow'];
        $guest_country_id       = $game_array[$i]['game_guest_country_id'];
        $guest_team_id          = $game_array[$i]['game_guest_team_id'];
        $guest_user_id          = $game_array[$i]['guest_user_id'];
        $guest_country_user_id  = $game_array[$i]['guest_country_user_id'];
        $guest_foul             = $game_array[$i]['game_guest_foul'];
        $guest_ontarget         = $game_array[$i]['game_guest_ontarget'];
        $guest_score            = $game_array[$i]['game_guest_score'];
        $guest_shot             = $game_array[$i]['game_guest_shot'];
        $guest_penalty          = $game_array[$i]['game_guest_penalty'];
        $guest_red              = $game_array[$i]['game_guest_red'];
        $guest_yellow           = $game_array[$i]['game_guest_yellow'];
        $referee_id             = $game_array[$i]['game_referee_id'];
        $referee_mark           = $game_array[$i]['game_referee_mark'];
        $tournament_id          = $game_array[$i]['game_tournament_id'];
        $visitor                = $game_array[$i]['game_visitor'];
        $stadium                = $game_array[$i]['stadium_capacity'];
        $home_win               = 0;
        $home_draw              = 0;
        $home_loose             = 0;
        $guest_win              = 0;
        $guest_draw             = 0;
        $guest_loose            = 0;
        $full_house             = 0;

        if ($visitor == $stadium)
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
        f_igosja_mysqli_query($sql);

        if (0 != $home_team_id)
        {
            $sql = "UPDATE `statisticteam`
                    SET `statisticteam_game`=`statisticteam_game`+'1'
                    WHERE `statisticteam_tournament_id`='$tournament_id'
                    AND `statisticteam_season_id`='$igosja_season_id'
                    AND `statisticteam_team_id` IN ('$home_team_id', '$guest_team_id')";
            f_igosja_mysqli_query($sql);

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
            f_igosja_mysqli_query($sql);

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
            f_igosja_mysqli_query($sql);

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
                f_igosja_mysqli_query($sql);
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
                f_igosja_mysqli_query($sql);
            }
        }
        else
        {
            $sql = "UPDATE `statisticcountry`
                    SET `statisticcountry_game`=`statisticcountry_game`+'1'
                    WHERE `statisticcountry_tournament_id`='$tournament_id'
                    AND `statisticcountry_season_id`='$igosja_season_id'
                    AND `statisticcountry_country_id` IN ('$home_country_id', '$guest_country_id')";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `statisticcountry`
                    SET `statisticcountry_foul`=`statisticcountry_foul`+'$home_foul',
                        `statisticcountry_full_house`=`statisticcountry_full_house`+'$full_house',
                        `statisticcountry_goal`=`statisticcountry_goal`+'$home_score',
                        `statisticcountry_ontarget`=`statisticcountry_ontarget`+'$home_ontarget',
                        `statisticcountry_pass`=`statisticcountry_pass`+'$guest_score',
                        `statisticcountry_penalty`=`statisticcountry_penalty`+'$home_penalty',
                        `statisticcountry_penalty_goal`=`statisticcountry_penalty_goal`+'$home_penalty',
                        `statisticcountry_red`=`statisticcountry_red`+'$home_red',
                        `statisticcountry_shot`=`statisticcountry_shot`+'$home_shot',
                        `statisticcountry_visitor`=`statisticcountry_visitor`+'$visitor',
                        `statisticcountry_yellow`=`statisticcountry_yellow`+'$home_yellow'
                    WHERE `statisticcountry_tournament_id`='$tournament_id'
                    AND `statisticcountry_season_id`='$igosja_season_id'
                    AND `statisticcountry_country_id`='$home_country_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `statisticcountry`
                    SET `statisticcountry_foul`=`statisticcountry_foul`+'$guest_foul',
                        `statisticcountry_full_house`=`statisticcountry_full_house`+'$full_house',
                        `statisticcountry_goal`=`statisticcountry_goal`+'$guest_score',
                        `statisticcountry_ontarget`=`statisticcountry_ontarget`+'$guest_ontarget',
                        `statisticcountry_pass`=`statisticcountry_pass`+'$home_score',
                        `statisticcountry_penalty`=`statisticcountry_penalty`+'$guest_penalty',
                        `statisticcountry_red`=`statisticcountry_red`+'$guest_red',
                        `statisticcountry_shot`=`statisticcountry_shot`+'$guest_shot',
                        `statisticcountry_visitor`=`statisticcountry_visitor`+'$visitor',
                        `statisticcountry_yellow`=`statisticcountry_yellow`+'$guest_yellow'
                    WHERE `statisticcountry_tournament_id`='$tournament_id'
                    AND `statisticcountry_season_id`='$igosja_season_id'
                    AND `statisticcountry_country_id`='$guest_country_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

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
                            AND `game_home_country_id`=`lineup_country_id`)
                            WHERE `game_id`='$game_id'
                            ORDER BY `lineup_position_id` ASC
                        )
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
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
                            AND `game_guest_country_id`=`lineup_country_id`)
                            WHERE `game_id`='$game_id'
                            ORDER BY `lineup_position_id` ASC
                        )
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'";
                f_igosja_mysqli_query($sql);
            }
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
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "UPDATE `statisticuser`
                    SET `statisticuser_game`=`statisticuser_game`+'1',
                        `statisticuser_win`=`statisticuser_win`+'$home_win',
                        `statisticuser_draw`=`statisticuser_draw`+'$home_draw',
                        `statisticuser_loose`=`statisticuser_loose`+'$home_loose',
                        `statisticuser_score`=`statisticuser_score`+'$home_score',
                        `statisticuser_pass`=`statisticuser_pass`+'$guest_score'
                    WHERE `statisticuser_user_id`='$home_country_user_id'
                    AND `statisticuser_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
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
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "UPDATE `statisticuser`
                    SET `statisticuser_game`=`statisticuser_game`+'1',
                        `statisticuser_win`=`statisticuser_win`+'$guest_win',
                        `statisticuser_draw`=`statisticuser_draw`+'$guest_draw',
                        `statisticuser_loose`=`statisticuser_loose`+'$guest_loose',
                        `statisticuser_score`=`statisticuser_score`+'$guest_score',
                        `statisticuser_pass`=`statisticuser_pass`+'$home_score'
                    WHERE `statisticuser_user_id`='$guest_country_user_id'
                    AND `statisticuser_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}