<?php

include (__DIR__ . '/include/include.php');

/*$sql = "SELECT `game_id`,
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
        ON `shedule_id`=`game_shedule_id`
        WHERE `shedule_date`='2016-05-09'
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

        $team_fix_id    = 0;
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

        $sql = "SELECT COUNT(`lineup_id`) AS `count`
                FROM `lineup`
                WHERE `lineup_team_id`='$team_id'
                AND `lineup_game_id`='$game_id'
                AND `lineup_position_id`!='0'";
        $lineup_sql = $mysqli->query($sql);

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        $count_lineup = $lineup_array[0]['count'];

        if (11 > $count_lineup)
        {
            $team_fix_id = $team_id;

            for ($k=0; $k<18; $k++)
            {
                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`='$game_id'
                        AND `lineup_team_id`='$team_id'
                        LIMIT $k, 1";
                $lineup_sql = $mysqli->query($sql);

                $count_lineup = $lineup_sql->num_rows;

                if (0 != $count_lineup)
                {
                    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

                    $lineup_id      = $lineup_array[0]['lineup_id'];
                    $player_id      = $lineup_array[0]['lineup_player_id'];

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
                    $mysqli->query($sql);
                }
            }
        }
        else
        {
            $team_fix_id = 0;
        }

        if (0 != $team_fix_id)
        {
        for ($j=0; $j<2; $j++) //Вратарям ставим меньше беготни и передач
        {
            if (0 == $j)
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
                    LEFT JOIN `player`
                    ON `player_id`=`lineup_player_id`
                    SET `lineup_distance`=" . $distance . ",
                        `lineup_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND(),
                        `lineup_pass`=" . $pass . ",
                        `lineup_pass_accurate`=" . $accurate . "
                    WHERE `lineup_game_id`='$game_id'
                    AND `lineup_team_id`='$team_id'
                    AND `lineup_position_id`" . $position;
            $mysqli->query($sql);
        }

        $sql = "UPDATE `lineup`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                SET `lineup_condition`=`player_condition`,
                    `lineup_practice`=`player_practice`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$team_id'";
        $mysqli->query($sql);

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
            $penalty_array = f_igosja_penalty_player_select($team_id, $game_id);

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
            }

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

            $sql = "UPDATE `event`
                    SET `event_player_id`='$player_id'
                    WHERE `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "'
                    AND `event_game_id`='$game_id'
                    AND `event_team_id`='$team_id'
                    AND `event_player_id`='0'
                    LIMIT 1";
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
                    ORDER BY `lineup_ontarget`-`lineup_goal` DESC, RAND()
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

            $sql = "UPDATE `event`
                    SET `event_player_id`='$player_id'
                    WHERE `event_eventtype_id`='" . EVENT_GOAL . "'
                    AND `event_game_id`='$game_id'
                    AND `event_team_id`='$team_id'
                    AND `event_player_id`='0'
                    LIMIT 1";
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

            if (!isset($player_array[0]))
            {
                print $game_id . '..' . $team_id;
            }

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

            $sql = "UPDATE `event`
                    SET `event_player_id`='$player_id'
                    WHERE `event_eventtype_id`='" . EVENT_YELLOW . "'
                    AND `event_game_id`='$game_id'
                    AND `event_team_id`='$team_id'
                    AND `event_player_id`='0'
                    LIMIT 1";
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
                    AND `lineup_goal`='0'
                    AND `lineup_penalty_goal`='0'
                    AND `lineup_penalty`='0'
                    AND `lineup_pass_scoring`='0'
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

            $sql = "UPDATE `event`
                    SET `event_player_id`='$player_id'
                    WHERE `event_eventtype_id`='" . EVENT_RED . "'
                    AND `event_game_id`='$game_id'
                    AND `event_team_id`='$team_id'
                    AND `event_player_id`='0'
                    LIMIT 1";
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
                    AND `lineup_position_id` BETWEEN '2' AND '25'
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
        }
    }
}

$sql = "UPDATE `game`
        SET `game_home_moment`='0'
        WHERE `game_home_moment`<'0'";
$mysqli->query($sql);

$sql = "UPDATE `game`
        SET `game_guest_moment`='0'
        WHERE `game_guest_moment`<'0'";
$mysqli->query($sql);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';