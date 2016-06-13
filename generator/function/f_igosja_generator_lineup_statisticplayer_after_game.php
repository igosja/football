<?php

function f_igosja_generator_lineup_statisticplayer_after_game()
//Записываем данные матча в таблицу сосотавов, обновляем статистику игроков
{
    global $igosja_season_id;

    $sql = "SELECT `game_id`,
                   `game_guest_country_id`,
                   `game_guest_foul`,
                   `game_guest_offside`,
                   `game_guest_ontarget`,
                   `game_guest_penalty`,
                   `game_guest_red`,
                   `game_guest_shot`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_guest_yellow`,
                   `game_home_country_id`,
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
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

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
            $country_id     = $game_array[$i]['game_' . $team . '_country_id'];
            $opponent_id    = $game_array[$i]['game_' . $opponent . '_team_id'];
            $country_opp_id = $game_array[$i]['game_' . $opponent . '_country_id'];
            $foul           = $game_array[$i]['game_' . $team . '_foul'];
            $offside        = $game_array[$i]['game_' . $team . '_offside'];
            $ontarget       = $game_array[$i]['game_' . $team . '_ontarget'];
            $score          = $game_array[$i]['game_' . $team . '_score'];
            $shot           = $game_array[$i]['game_' . $team . '_shot'];
            $penalty        = $game_array[$i]['game_' . $team . '_penalty'];
            $red            = $game_array[$i]['game_' . $team . '_red'];
            $yellow         = $game_array[$i]['game_' . $team . '_yellow'];

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
                        AND `lineup_country_id`='$country_id'
                        AND (`lineup_position_id` BETWEEN '2' AND '25'
                        OR `lineup_in`!='0')
                        AND `lineup_game_id`='$game_id'
                        ORDER BY `lineup_position_id` DESC
                        LIMIT $offset, 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_shot`=`statisticplayer_shot`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$ontarget; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND (`lineup_position_id` BETWEEN '2' AND '25'
                        OR `lineup_in`!='0')
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_shot`>`lineup_ontarget`
                        ORDER BY `lineup_shot`-`lineup_ontarget` DESC, RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_ontarget`=`statisticplayer_ontarget`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_ontarget`=`lineup_ontarget`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$penalty; $j++)
            {
                $sql = "SELECT `event_id`,
                               `event_minute`
                        FROM `event`
                        WHERE `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "'
                        AND `event_game_id`='$game_id'
                        AND `event_team_id`='$team_id'
                        AND `event_country_id`='$country_id'
                        AND `event_player_id`='0'
                        LIMIT 1";
                $event_sql = f_igosja_mysqli_query($sql);

                $event_array = $event_sql->fetch_all(1);

                $event_id       = $event_array[0]['event_id'];
                $event_minute   = $event_array[0]['event_minute'];

                $penalty_array = f_igosja_penalty_player_select($team_id, $country_id, $game_id, $event_minute);

                if (isset($penalty_array['player_id']))
                {
                    $player_id = $penalty_array['player_id'];
                    $lineup_id = $penalty_array['lineup_id'];
                }
                else
                {
                    $sql = "SELECT `lineup_id`,
                                   `lineup_player_id`
                            FROM `lineup`
                            WHERE `lineup_team_id`='$team_id'
                            AND `lineup_country_id`='$country_id'
                            AND ((`lineup_position_id` BETWEEN '2' AND '25'
                            AND (`lineup_out`='0'
                            OR `lineup_out`>='$event_minute'))
                            OR (`lineup_in`<='$event_minute'
                            AND `lineup_in`!='0'))
                            AND `lineup_game_id`='$game_id'
                            AND `lineup_red`='0'
                            AND `lineup_yellow`<'2'
                            AND `lineup_ontarget`>`lineup_goal`
                            ORDER BY RAND()
                            LIMIT 1";
                    $player_sql = f_igosja_mysqli_query($sql);

                    $player_array = $player_sql->fetch_all(1);

                    $player_id = $player_array[0]['lineup_player_id'];
                    $lineup_id = $player_array[0]['lineup_id'];
                }

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`+'1',
                            `statisticplayer_penalty`=`statisticplayer_penalty`+'1',
                            `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`+'1',
                            `lineup_penalty`=`lineup_penalty`+'1',
                            `lineup_penalty_goal`=`lineup_penalty_goal`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `event`
                        SET `event_player_id`='$player_id'
                        WHERE `event_id`='$event_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$opponent_id'
                        AND `lineup_country_id`='$country_opp_id'
                        AND ((`lineup_position_id`='1'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        LIMIT 1";
                $gk_sql = f_igosja_mysqli_query($sql);

                $gk_array = $gk_sql->fetch_all(1);

                $player_id = $gk_array[0]['lineup_player_id'];
                $lineup_id = $gk_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`-'1',
                            `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`-'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$opponent_id'
                        AND `statisticplayer_country_id`='$country_opp_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`-'1',
                            `lineup_penalty_goal`=`lineup_penalty_goal`-'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$score-$penalty; $j++)
            {
                $sql = "SELECT `event_id`,
                               `event_minute`
                        FROM `event`
                        WHERE `event_eventtype_id`='" . EVENT_GOAL . "'
                        AND `event_game_id`='$game_id'
                        AND `event_team_id`='$team_id'
                        AND `event_country_id`='$country_id'
                        AND `event_player_id`='0'
                        LIMIT 1";
                $event_sql = f_igosja_mysqli_query($sql);

                $event_array = $event_sql->fetch_all(1);

                $event_id       = $event_array[0]['event_id'];
                $event_minute   = $event_array[0]['event_minute'];

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND ((`lineup_position_id` BETWEEN '2' AND '25'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_ontarget`>`lineup_goal`
                        ORDER BY `lineup_ontarget`-`lineup_goal` DESC, RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `event`
                        SET `event_player_id`='$player_id'
                        WHERE `event_id`='$event_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND ((`lineup_position_id` BETWEEN '2' AND '25'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_id`!='$lineup_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$opponent_id'
                        AND `lineup_country_id`='$country_opp_id'
                        AND ((`lineup_position_id`='1'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        LIMIT 1";
                $gk_sql = f_igosja_mysqli_query($sql);

                $gk_array = $gk_sql->fetch_all(1);

                $player_id = $gk_array[0]['lineup_player_id'];
                $lineup_id = $gk_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_goal`=`statisticplayer_goal`-'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$opponent_id'
                        AND `statisticplayer_country_id`='$country_opp_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_goal`=`lineup_goal`-'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$foul; $j++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND (`lineup_position_id` BETWEEN '2' AND '25'
                        OR `lineup_in`!='0')
                        AND `lineup_game_id`='$game_id'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_foul`=`statisticplayer_foul`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_foul_made`=`lineup_foul_made`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_foul_recieve`=`lineup_foul_recieve`+'1'
                        WHERE `lineup_team_id`='$opponent_id'
                        AND `lineup_country_id`='$country_opp_id'
                        AND `lineup_position_id` BETWEEN '2' AND '25'
                        AND `lineup_game_id`='$game_id'
                        ORDER BY RAND()
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$yellow; $j++)
            {
                $sql = "SELECT `event_id`,
                               `event_minute`
                        FROM `event`
                        WHERE `event_eventtype_id`='" . EVENT_YELLOW . "'
                        AND `event_game_id`='$game_id'
                        AND `event_team_id`='$team_id'
                        AND `event_country_id`='$country_id'
                        AND `event_player_id`='0'
                        LIMIT 1";
                $event_sql = f_igosja_mysqli_query($sql);

                $event_array = $event_sql->fetch_all(1);

                $event_id       = $event_array[0]['event_id'];
                $event_minute   = $event_array[0]['event_minute'];

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND ((`lineup_position_id` BETWEEN '2' AND '25'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_foul_made`>'0'
                        AND `lineup_yellow`='0'
                        AND `lineup_red`='0'
                        ORDER BY RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                if (!isset($player_array[0]))
                {
                    $sql = "SELECT `lineup_id`,
                                   `lineup_player_id`
                            FROM `lineup`
                            WHERE `lineup_team_id`='$team_id'
                            AND `lineup_country_id`='$country_id'
                            AND (`lineup_position_id` BETWEEN '2' AND '25'
                            OR `lineup_in`!='0')
                            AND `lineup_game_id`='$game_id'
                            AND `lineup_yellow`='0'
                            AND `lineup_red`='0'
                            ORDER BY RAND()
                            LIMIT 1";
                    $player_sql = f_igosja_mysqli_query($sql);

                    $player_array = $player_sql->fetch_all(1);
                }

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `disqualification`
                        SET `disqualification_yellow`=`disqualification_yellow`+'1'
                        WHERE `disqualification_player_id`='$player_id'
                        AND `disqualification_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_yellow`=`statisticplayer_yellow`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_yellow`=`lineup_yellow`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `event`
                        SET `event_player_id`='$player_id'
                        WHERE `event_id`='$event_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            for ($j=0; $j<$red; $j++)
            {
                $sql = "SELECT `event_id`,
                               `event_minute`
                        FROM `event`
                        WHERE `event_eventtype_id`='" . EVENT_RED . "'
                        AND `event_game_id`='$game_id'
                        AND `event_team_id`='$team_id'
                        AND `event_country_id`='$country_id'
                        AND `event_player_id`='0'
                        LIMIT 1";
                $event_sql = f_igosja_mysqli_query($sql);

                $event_array = $event_sql->fetch_all(1);

                $event_id       = $event_array[0]['event_id'];
                $event_minute   = $event_array[0]['event_minute'];

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_team_id`='$team_id'
                        AND `lineup_country_id`='$country_id'
                        AND ((`lineup_position_id` BETWEEN '2' AND '25'
                        AND (`lineup_out`='0'
                        OR `lineup_out`>='$event_minute'))
                        OR (`lineup_in`<='$event_minute'
                        AND `lineup_in`!='0'))
                        AND `lineup_game_id`='$game_id'
                        AND `lineup_foul_made`>`lineup_yellow`
                        AND `lineup_red`='0'
                        AND `lineup_yellow`<'2'
                        AND `lineup_goal`='0'
                        AND `lineup_penalty_goal`='0'
                        AND `lineup_penalty`='0'
                        AND `lineup_pass_scoring`='0'
                        ORDER BY `lineup_yellow` ASC, RAND()
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                $player_array = $player_sql->fetch_all(1);

                $player_id = $player_array[0]['lineup_player_id'];
                $lineup_id = $player_array[0]['lineup_id'];

                $sql = "UPDATE `disqualification`
                        SET `disqualification_red`=`disqualification_red`+'1'
                        WHERE `disqualification_player_id`='$player_id'
                        AND `disqualification_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_red`=`statisticplayer_red`+'1'
                        WHERE `statisticplayer_player_id`='$player_id'
                        AND `statisticplayer_season_id`='$igosja_season_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_team_id`='$team_id'
                        AND `statisticplayer_country_id`='$country_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_red`=`lineup_red`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `event`
                        SET `event_player_id`='$player_id'
                        WHERE `event_id`='$event_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
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
                        AND `lineup_country_id`='$country_id'
                        AND (`lineup_position_id` BETWEEN '2' AND '25'
                        OR `lineup_in`!='0')
                        AND `lineup_game_id`='$game_id'
                        ORDER BY `lineup_position_id` DESC
                        LIMIT $offset, 1";
                $lineup_sql = f_igosja_mysqli_query($sql);

                $lineup_array = $lineup_sql->fetch_all(1);

                $lineup_id = $lineup_array[0]['lineup_id'];

                $sql = "UPDATE `lineup`
                        SET `lineup_offside`=`lineup_offside`+'1'
                        WHERE `lineup_id`='$lineup_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}