<?php

$start_time = microtime(true);

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

//тут собственно генерируем счет в матче
/*
$koef_1 = 100000;
$koef_2 = 100000;
$koef_3 = 100000;
$koef_4 = 100000;
$koef_5 = 10000;

$sql = "SELECT `game_id`,
               `game_home_team_id`,
               `game_guest_team_id`
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
    $game_id        = $game_array[$i]['game_id'];
    $home_team_id   = $game_array[$i]['game_home_team_id'];
    $guest_team_id  = $game_array[$i]['game_guest_team_id'];

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

    for ($j=0; $j<2; $j++)
    {
        if (0 == $j)
        {
            $team = 'home';
        }
        else
        {
            $team = 'guest';
        }

        $team_id = $team . '_team_id';
        $team_id = $$team_id;

        $sql = "SELECT `player_power`,
                       `lineup_position_id`
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
                ORDER BY `lineup_position_id` ASC";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;
        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        for ($k=0; $k<$count_lineup; $k++)
        {
            $player_power = $lineup_array[$k]['player_power'];
            $position_id  = $lineup_array[$k]['lineup_position_id'];

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
                $home_gk = $home_gk + $player_power;
            }
            elseif (2 == $position_id)
            {
                $$defence_left    = $$defence_left    + $player_power;
                $$defence_center  = $$defence_center  + $player_power;
                $$defence_right   = $$defence_right   + $player_power;
            }
            elseif (3 == $position_id)
            {
                $$defence_center  = $$defence_center  + $player_power;
                $$defence_right   = $$defence_right   + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
            }
            elseif (in_array($position_id, array(4, 5, 6)))
            {
                $$defence_left    = $$defence_left    + $player_power;
                $$defence_center  = $$defence_center  + $player_power;
                $$defence_right   = $$defence_right   + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
            }
            elseif (7 == $position_id)
            {
                $$defence_left    = $$defence_left    + $player_power;
                $$defence_center  = $$defence_center  + $player_power;
                $$halfback_left   = $$halfback_left   + $player_power;
            }
            elseif (8 == $position_id)
            {
                $$defence_right   = $$defence_right   + $player_power;
                $$defence_center  = $$defence_center  + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
            }
            elseif (in_array($position_id, array(9, 10, 11)))
            {
                $$defence_center  = $$defence_center  + $player_power;
                $$halfback_left   = $$halfback_left   + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
            }
            elseif (12 == $position_id)
            {
                $$defence_left    = $$defence_left    + $player_power;
                $$defence_center  = $$defence_center  + $player_power;
                $$halfback_left   = $$halfback_left   + $player_power;
            }
            elseif (13 == $position_id)
            {
                $$defence_right   = $$defence_right   + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
                $$forward_right   = $$forward_right   + $player_power;
            }
            elseif (in_array($position_id, array(14, 15, 16)))
            {
                $$defence_center  = $$defence_center  + $player_power;
                $$halfback_left   = $$halfback_left   + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
                $$forward_center  = $$forward_center  + $player_power;
            }
            elseif (17 == $position_id)
            {
                $$defence_left    = $$defence_left    + $player_power;
                $$halfback_left   = $$halfback_left   + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
                $$forward_left    = $$forward_left    + $player_power;
            }
            elseif (18 == $position_id)
            {
                $$halfback_right  = $$halfback_right  + $player_power;
                $$forward_right   = $$forward_right   + $player_power;
                $$forward_center  = $$forward_center  + $player_power;
            }
            elseif (in_array($position_id, array(19, 20, 21)))
            {
                $$halfback_left   = $$halfback_left   + $player_power;
                $$halfback_center = $$halfback_center + $player_power;
                $$halfback_right  = $$halfback_right  + $player_power;
                $$forward_center  = $$forward_center  + $player_power;
            }
            elseif (22 == $position_id)
            {
                $$halfback_left   = $$halfback_left   + $player_power;
                $$forward_left    = $$forward_left    + $player_power;
                $$forward_center  = $$forward_center  + $player_power;
            }
            elseif (in_array($position_id, array(23, 24, 25)))
            {
                $$halfback_center = $$halfback_center + $player_power;
                $$forward_left    = $$forward_left    + $player_power;
                $$forward_center  = $$forward_center  + $player_power;
                $$forward_right   = $$forward_right   + $player_power;
            }
        }
    }

    $home_score     = $guest_score      = 0;
    $home_moment    = $guest_moment     = 0;
    $home_on_target = $guest_on_target  = 0;
    $home_shot      = $guest_shot       = 0;
    $home_pass      = $guest_pass       = 0;
    $home_possesion = $guest_possesion  = 0;
    $home_corner    = $guest_corner     = 0;
    $home_offside   = $guest_offside    = 0;
    $home_foul      = $guest_foul       = 0;
    $home_penalty   = $guest_penalty    = 0;
    $home_yellow    = $guest_yellow     = 0;
    $home_red       = $guest_red        = 0;

    for ($j=0; $j<90; $j++)
    {
        for ($k=0; $k<2; $k++)
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
}

*/

//тут добавляем доп данные в составы матча (дистанция, оценки)
/*
$sql = "UPDATE `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `player`
        ON `player_id`=`lineup_player_id`
        SET `lineup_distance`='3000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND(),
            `lineup_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND(),
            `lineup_pass`='30'+'10'*RAND()+'10'*RAND()+'10'*RAND(),
            `lineup_pass_accurate`='15'+'5'*RAND()+'5'*RAND()+'5'*RAND(),
            `lineup_condition`=`player_condition`
        WHERE `shedule_date`=CURDATE()
        AND `game_played`='0'
        AND `lineup_position_id`>'1'
        AND `lineup_position_id`<'26'";
$mysqli->query($sql);

$sql = "UPDATE `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `player`
        ON `player_id`=`lineup_player_id`
        SET `lineup_distance`='2000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND(),
            `lineup_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND(),
            `lineup_pass`='15'+'2'*RAND()+'2'*RAND()+'2'*RAND(),
            `lineup_pass_accurate`='9'+'2'*RAND()+'2'*RAND()+'2'*RAND(),
            `lineup_condition`=`player_condition`
        WHERE `shedule_date`=CURDATE()
        AND `game_played`='0'
        AND `lineup_position_id`='1'";
$mysqli->query($sql);
*/

//тут записываем данные матча в таблицу сосотавов, обновляем статистику игроков и создаем события матча
/*
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
    $home_team_id   = $game_array[$i]['game_home_team_id'];
    $home_foul      = $game_array[$i]['game_home_foul'];//
    $home_offside   = $game_array[$i]['game_home_offside'];
    $home_ontarget  = $game_array[$i]['game_home_ontarget'];
    $home_score     = $game_array[$i]['game_home_score'];
    $home_shot      = $game_array[$i]['game_home_shot'];
    $home_penalty   = $game_array[$i]['game_home_penalty'];
    $home_red       = $game_array[$i]['game_home_red'];//
    $home_yellow    = $game_array[$i]['game_home_yellow'];//
    $guest_team_id  = $game_array[$i]['game_guest_team_id'];
    $guest_foul     = $game_array[$i]['game_guest_foul'];
    $guest_offside  = $game_array[$i]['game_guest_offside'];
    $guest_ontarget = $game_array[$i]['game_guest_ontarget'];
    $guest_score    = $game_array[$i]['game_guest_score'];
    $guest_shot     = $game_array[$i]['game_guest_shot'];
    $guest_penalty  = $game_array[$i]['game_guest_penalty'];
    $guest_red      = $game_array[$i]['game_guest_red'];
    $guest_yellow   = $game_array[$i]['game_guest_yellow'];
    $tournament_id  = $game_array[$i]['game_tournament_id'];

    for ($j=0; $j<$home_foul; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_foul_made`=`lineup_foul_made`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_foul_recieve`=`lineup_foul_recieve`+'1'
                WHERE `lineup_id`=
                (
                    SELECT `lineup_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_position_id`!='1'
                    AND `lineup_game_id`='$game_id'
                    ORDER BY RAND()
                    LIMIT 1
                )";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_foul; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_foul_made`=`lineup_foul_made`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_foul_recieve`=`lineup_foul_recieve`+'1'
                WHERE `lineup_id`=
                (
                    SELECT `lineup_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_position_id`!='1'
                    AND `lineup_game_id`='$game_id'
                    ORDER BY RAND()
                    LIMIT 1
                )";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_yellow; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_yellow`=`lineup_yellow`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_YELLOW . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$home_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_yellow; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_yellow`=`lineup_yellow`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_YELLOW . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$guest_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_red; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_red`=`lineup_red`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_RED . "';
                    `event_game_id`='$game_id',
                    `event_minute`='70'+'20'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$home_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_red; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_red`=`lineup_red`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_RED . "';
                    `event_game_id`='$game_id',
                    `event_minute`='70'+'20'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$guest_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_offside; $j++)
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

        $sql = "UPDATE `lineup`
                SET `lineup_offside`=`lineup_offside`+'1'
                WHERE `lineup_id`=
                (
                    SELECT `lineup_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_position_id`>='13'
                    AND `lineup_game_id`='$game_id'
                    ORDER BY `lineup_position_id` DESC
                    LIMIT $offset, 1
                )
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_offside; $j++)
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

        $sql = "UPDATE `lineup`
                SET `lineup_offside`=`lineup_offside`+'1'
                WHERE `lineup_id`=
                (
                    SELECT `lineup_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_position_id`>='13'
                    AND `lineup_game_id`='$game_id'
                    ORDER BY `lineup_position_id` DESC
                    LIMIT $offset, 1
                )
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_shot; $j++)
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
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_shot`=`lineup_shot`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_shot; $j++)
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
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_shot`=`lineup_shot`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_ontarget; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_ontarget`=`lineup_ontarget`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_ontarget; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_ontarget`=`lineup_ontarget`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_penalty; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
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
                SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$home_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_penalty; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
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
                SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$guest_team_id'";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_score; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_GOAL . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$home_team_id'";
        $mysqli->query($sql);

        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_position_id`!='1'
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

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_score; $j++)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `event`
                SET `event_eventtype_id`='" . EVENT_GOAL . "';
                    `event_game_id`='$game_id',
                    `event_minute`='1'+'89'*RAND(),
                    `event_player_id`='$player_id',
                    `event_team_id`='$guest_team_id'";
        $mysqli->query($sql);

        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_position_id`!='1'
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

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_pass_scoring`=`statisticplayer_pass_scoring`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_pass_scoring`=`lineup_pass_scoring`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
}
*/

//тут обновляем статистику игроков, которую не надо пускать в циклы
/*
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
            `statisticplayer_mark`=`statisticplayer_mark`+`lineup_mark`
            `statisticplayer_pass`=`statisticplayer_pass`+`lineup_pass`
            `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+`lineup_pass_accurate`
        WHERE `statisticplayer_season_id`='$igosja_season_id'
        AND `shedule_date`=CURDATE()
        AND `game_played`='0'";
$mysqli->query($sql);
*/

//тут вычислим лучших игровок матча и в статистику
/*
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
*/

//тут обновляем статистику судьи, команд и менеджеров
/*
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
    $home_win       = 0;
    $home_draw      = 0;
    $home_loose     = 0;
    $guest_win      = 0;
    $guest_draw     = 0;
    $guest_loose    = 0;

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
                `statisticteam_goal`=`statisticteam_goal`+'$home_score',
                `statisticteam_ontarget`=`statisticteam_ontarget`+'$home_ontarget',
                `statisticteam_pass`=`statisticteam_pass`+'$guest_score',
                `statisticteam_penalty`=`statisticteam_penalty`+'$home_penalty',
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
}
*/

print 'Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек.<br/>';
print 'Потребление памяти (байт): ' . number_format(memory_get_usage(), 0, ",", " ");