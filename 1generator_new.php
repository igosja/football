<?php

$start_time = microtime(true);

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/database.php');

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
    
}

exit;

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
    $home_yellow        = $home_yellow  + rand(0, 4);
    $guest_yellow       = $guest_yellow + rand(0, 4);
    $home_red           = $home_red  + floor(rand(0, 8) / 8);
    $guest_red          = $guest_red + floor(rand(0, 8) / 8);
    $home_possesion     = round($home_team_power / ( $home_team_power + $guest_team_power ) * 100 + rand(-10, 10));
    $guest_possesion    = 100 - $home_possesion;

    $sql = "UPDATE `game`
            SET `game_guest_corner`='$guest_corner',
                `game_guest_foul`='$',
                `game_guest_moment`='$guest_moment',
                `game_guest_offside`='$',
                `game_guest_ontarget`='$guest_on_target',
                `game_guest_pass`='$guest_pass',
                `game_guest_penalty`='$',
                `game_guest_possession`='$',
                `game_guest_red`='$',
                `game_guest_score`='$guest_score',
                `game_guest_shot`='$guest_shot',
                `game_guest_yellow`='$',
                `game_home_corner`='$home_corner',
                `game_home_foul`='$',
                `game_home_moment`='$home_moment',
                `game_home_offside`='$',
                `game_home_ontarget`='$home_on_target',
                `game_home_pass`='$home_pass',
                `game_home_penalty`='$',
                `game_home_possession`='$',
                `game_home_red`='$',
                `game_home_score`='$home_score',
                `game_home_shot`='$home_shot',
                `game_home_yellow`='$'
            WHERE `game_id`='$game_id'
            LIMIT 1";
    $mysqli->query($sql);
}

print 'Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек.<br/>';
print 'Потребление памяти (байт): ' . number_format(memory_get_usage(), 0, ",", " ");