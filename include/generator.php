<?php

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
        $data['home']['team']['power']          = 0;
        $data['home']['team']['player_number']  = 0;
        $data['guest']['team']['team_id']       = $guest_team_id;
        $data['guest']['team']['power']         = 0;
        $data['guest']['team']['player_number'] = 0;

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `playerattribute_value`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_captain_player_id_" . $j . "`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_LEADER . "'";
            $leader_sql = $mysqli->query($sql);

            $count_leader = $leader_sql->num_rows;

            if (1 == $count_leader)
            {
                break;
            }
        }

        if (0 == $count_leader)
        {
            $sql = "SELECT `playerattribute_value`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_LEADER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $leader_sql = $mysqli->query($sql);
        }

        $leader_array = $leader_sql->fetch_all(MYSQLI_ASSOC);

        $leader_value = $leader_array[0]['playerattribute_value'];
        $leader_value = round(1 + $leader_value / 1000, 2);

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_freekick_left_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'";
            $free_sql = $mysqli->query($sql);

            $count_free = $free_sql->num_rows;

            if (1 == $count_free)
            {
                break;
            }
        }

        if (0 == $count_free)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_FREE_KICK . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $free_sql = $mysqli->query($sql);
        }

        $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

        $free_id_1 = $free_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_freekick_right_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'";
            $free_sql = $mysqli->query($sql);

            $count_free = $free_sql->num_rows;

            if (1 == $count_free)
            {
                break;
            }
        }

        if (0 == $count_free)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_FREE_KICK . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $free_sql = $mysqli->query($sql);
        }

        $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

        $free_id_2 = $free_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_corner_left_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'";
            $corner_sql = $mysqli->query($sql);

            $count_corner = $corner_sql->num_rows;

            if (1 == $count_corner)
            {
                break;
            }
        }

        if (0 == $count_corner)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CORNER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $corner_sql = $mysqli->query($sql);
        }

        $corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

        $corner_id_1 = $corner_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_corner_right_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'";
            $corner_sql = $mysqli->query($sql);

            $count_corner = $corner_sql->num_rows;

            if (1 == $count_corner)
            {
                break;
            }
        }

        if (0 == $count_corner)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CORNER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $corner_sql = $mysqli->query($sql);
        }

        $corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

        $corner_id_2 = $corner_array[0]['lineup_player_id'];

        for ($j=1; $j<=7; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_penalty_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'";
            $penalty_sql = $mysqli->query($sql);

            $count_penalty = $penalty_sql->num_rows;

            if (1 == $count_penalty)
            {
                break;
            }
        }

        if (0 == $count_penalty)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$home_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_PENALTY . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $penalty_sql = $mysqli->query($sql);
        }

        $penalty_array = $penalty_sql->fetch_all(MYSQLI_ASSOC);

        $penalty_id = $penalty_array[0]['lineup_player_id'];

        $sql = "SELECT `lineup_condition`,
                       `lineup_id`,
                       `lineup_position_id`,
                       `lineup_red`,
                       `lineup_yellow`,
                       `player_id`,
                       `player_height`,
                       SUM(`playerattribute_value`) AS `player_power`,
                       `player_practice`
                FROM `lineup`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `playerattribute`
                ON `playerattribute_player_id`=`player_id`
                WHERE `lineup_team_id`='$home_team_id'
                AND `lineup_game_id`='$game_id'
                GROUP BY `player_id`
                ORDER BY `lineup_position_id` ASC";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_lineup; $j++)
        {
            $player_id = $lineup_array[$j]['player_id'];

            if ($player_id == $free_id_1)
            {
                $data['home']['team']['free'][0] = $j;
            }

            if ($player_id == $free_id_2)
            {
                $data['home']['team']['free'][1] = $j;
            }

            if ($player_id == $corner_id_1)
            {
                $data['home']['team']['corner'][0] = $j;
            }

            if ($player_id == $corner_id_2)
            {
                $data['home']['team']['corner'][1] = $j;
            }

            if ($player_id == $penalty_id)
            {
                $data['home']['team']['penalty'] = $j;
            }

            $data['home']['player'][$j]['lineup_id']        = $lineup_array[$j]['lineup_id'];
            $data['home']['player'][$j]['lineup_position']  = $lineup_array[$j]['lineup_position_id'];
            $data['home']['player'][$j]['player_id']        = $player_id;
            $data['home']['player'][$j]['condition']        = $lineup_array[$j]['lineup_condition'];
            $data['home']['player'][$j]['practice']         = $lineup_array[$j]['player_practice'];
            $data['home']['player'][$j]['height']           = $lineup_array[$j]['player_height'];
            $data['home']['player'][$j]['red']              = $lineup_array[$j]['lineup_red'];
            $data['home']['player'][$j]['yellow']           = $lineup_array[$j]['lineup_yellow'];

            if (0 == $lineup_array[$j]['lineup_red'] &&
                2 > $lineup_array[$j]['lineup_yellow'])
            {
                $data['home']['team']['power']         = $data['home']['team']['power'] + round($lineup_array[$j]['player_power'] * 1.1 * $leader_value);
                $data['home']['team']['player_number'] = $data['home']['team']['power'] + 1;
            }

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
                $data['home']['player'][$j]['attribute'][$attaribute_array[$k]['playerattribute_attribute_id']] = round($attaribute_array[$k]['playerattribute_value'] * 1.1);
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

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `playerattribute_value`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_captain_player_id_" . $j . "`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_LEADER . "'";
            $leader_sql = $mysqli->query($sql);

            $count_leader = $leader_sql->num_rows;

            if (1 == $count_leader)
            {
                break;
            }
        }

        if (0 == $count_leader)
        {
            $sql = "SELECT `playerattribute_value`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_LEADER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $leader_sql = $mysqli->query($sql);
        }

        $leader_array = $leader_sql->fetch_all(MYSQLI_ASSOC);

        $leader_value = $leader_array[0]['playerattribute_value'];
        $leader_value = round(1 + $leader_value / 1000, 2);

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_freekick_left_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'";
            $free_sql = $mysqli->query($sql);

            $count_free = $free_sql->num_rows;

            if (1 == $count_free)
            {
                break;
            }
        }

        if (0 == $count_free)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_FREE_KICK . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $free_sql = $mysqli->query($sql);
        }

        $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

        $free_id_1 = $free_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_freekick_right_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'";
            $free_sql = $mysqli->query($sql);

            $count_free = $free_sql->num_rows;

            if (1 == $count_free)
            {
                break;
            }
        }

        if (0 == $count_free)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_FREE_KICK . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $free_sql = $mysqli->query($sql);
        }

        $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

        $free_id_2 = $free_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_corner_left_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'";
            $corner_sql = $mysqli->query($sql);

            $count_corner = $corner_sql->num_rows;

            if (1 == $count_corner)
            {
                break;
            }
        }

        if (0 == $count_corner)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CORNER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $corner_sql = $mysqli->query($sql);
        }

        $corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

        $corner_id_1 = $corner_array[0]['lineup_player_id'];

        for ($j=1; $j<=5; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_corner_right_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'";
            $corner_sql = $mysqli->query($sql);

            $count_corner = $corner_sql->num_rows;

            if (1 == $count_corner)
            {
                break;
            }
        }

        if (0 == $count_corner)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_CORNER . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $corner_sql = $mysqli->query($sql);
        }

        $corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

        $corner_id_2 = $corner_array[0]['lineup_player_id'];

        for ($j=1; $j<=7; $j++)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    CROSS JOIN `team`
                    ON `lineup_player_id`=`team_penalty_player_id_" . $j . "`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'";
            $penalty_sql = $mysqli->query($sql);

            $count_penalty = $penalty_sql->num_rows;

            if (1 == $count_penalty)
            {
                break;
            }
        }

        if (0 == $count_penalty)
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `playerattribute`
                    ON `lineup_player_id`=`playerattribute_player_id`
                    WHERE `lineup_team_id`='$guest_team_id'
                    AND `lineup_game_id`='$game_id'
                    AND `playerattribute_attribute_id`='" . ATTRIBUTE_PENALTY . "'
                    ORDER BY `playerattribute_value` DESC
                    LIMIT 1";
            $penalty_sql = $mysqli->query($sql);
        }

        $penalty_array = $penalty_sql->fetch_all(MYSQLI_ASSOC);

        $penalty_id = $penalty_array[0]['lineup_player_id'];

        $sql = "SELECT `lineup_condition`,
                       `lineup_id`,
                       `lineup_position_id`,
                       `lineup_red`,
                       `lineup_yellow`,
                       `player_id`,
                       `player_height`,
                       SUM(`playerattribute_value`) AS `player_power`,
                       `player_practice`
                FROM `lineup`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `playerattribute`
                ON `playerattribute_player_id`=`player_id`
                WHERE `lineup_team_id`='$guest_team_id'
                AND `lineup_game_id`='$game_id'
                GROUP BY `player_id`
                ORDER BY `lineup_position_id` ASC";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_lineup; $j++)
        {
            $player_id = $lineup_array[$j]['player_id'];

            if ($player_id == $free_id_1)
            {
                $data['guest']['team']['free'][0] = $j;
            }

            if ($player_id == $free_id_2)
            {
                $data['guest']['team']['free'][1] = $j;
            }

            if ($player_id == $corner_id_1)
            {
                $data['guest']['team']['corner'][0] = $j;
            }

            if ($player_id == $corner_id_2)
            {
                $data['guest']['team']['corner'][1] = $j;
            }

            if ($player_id == $penalty_id)
            {
                $data['guest']['team']['penalty'] = $j;
            }

            $data['guest']['player'][$j]['lineup_id']       = $lineup_array[$j]['lineup_id'];
            $data['guest']['player'][$j]['lineup_position'] = $lineup_array[$j]['lineup_position_id'];
            $data['guest']['player'][$j]['player_id']       = $player_id;
            $data['guest']['player'][$j]['condition']       = $lineup_array[$j]['lineup_condition'];
            $data['guest']['player'][$j]['practice']        = $lineup_array[$j]['player_practice'];
            $data['guest']['player'][$j]['height']          = $lineup_array[$j]['player_height'];
            $data['guest']['player'][$j]['red']             = $lineup_array[$j]['lineup_red'];
            $data['guest']['player'][$j]['yellow']          = $lineup_array[$j]['lineup_yellow'];

            if (0 == $lineup_array[$j]['lineup_red'] &&
                2 > $lineup_array[$j]['lineup_yellow'])
            {
                $data['guest']['team']['power']         = $data['guest']['team']['power'] + round($lineup_array[$j]['player_power'] * $leader_value);
                $data['guest']['team']['player_number'] = $data['guest']['team']['power'] + 1;
            }

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

        if (1 == $minute)
        {
            $home_power  = $data['home']['team']['power'];
            $guest_power = $data['guest']['team']['power'];
            $home_possession = round($home_power / ($home_power + $guest_power) * 100);
            $guest_possession = 100 - $home_possession;
            
            $sql = "UPDATE `game`
                    SET `game_home_possession`='$home_possession',
                        `game_guest_possession`='$guest_possession'
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $mysqli->query($sql);
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
    $decision = rand(1, 6);

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
        $player = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player       = $data['take'];
        $data['take'] = 0;
    }

    $player_id          = $data[$data['team']]['player'][$player]['player_id'];
    $char               = $data[$data['team']]['player'][$player]['attribute'][ATTRIBUTE_FIELD_VIEW];
    $condition          = $data[$data['team']]['player'][$player]['condition'];
    $practice           = $data[$data['team']]['player'][$player]['practice'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];
    $char               = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);
    $vision             = rand($char, 200);

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
    $air = rand(1, 2);

    return $air;
}

function f_igosja_generator_shot($data)
//Удар по воротам
{
    global $mysqli;

    $player_opponent    = f_igosja_generator_select_player($data, $data['opponent']);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];

    $sql = "SELECT SUM(`lineup_shot`) AS `sum`
            FROM `lineup`
            WHERE `lineup_team_id`='$team_id'
            AND `lineup_game_id`='$game_id'";
    $sum_sql = $mysqli->query($sql);

    $sum_array = $sum_sql->fetch_all(MYSQLI_ASSOC);

    $sum = $sum_array[0]['sum'];

    if (15 <= $sum)
    {
        return 0;
    }

    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];
    $gk_player_id       = $data[$data['opponent']]['player'][0]['player_id'];
    $tournament_id      = $data['tournament']['tournament_id'];
    $season_id          = $data['season'];
    $minute             = $data['minute'];
    $air                = $data['air'];
    $player_pass        = $data['pass'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    if (0 == $data['take'])
    {
        $player_shot = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_shot  = $data['take'];
        $data['take'] = 0;
    }

    $lineup_id = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $player_id = $data[$data['team']]['player'][$player_shot]['player_id'];
    $condition = $data[$data['team']]['player'][$player_shot]['condition'];
    $practice  = $data[$data['team']]['player'][$player_shot]['practice'];

    if (0 < $player_pass)
    {
        $pass_player_id = $data[$data['team']]['player'][$player_pass]['player_id'];
        $pass_lineup_id = $data[$data['team']]['player'][$player_pass]['lineup_id'];
    }

    if ($air == 1) //Удар с земли
    {
        $distance = rand(1, 2);

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
            $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
                elseif (1 == $opposition)
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
            $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
                elseif (1 == $opposition)
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

        $char = round(($char_1 + ($char_2 + $char_3 + $char_8 / 2) * 50 / 100 + ($char_4 + $char_5 + $char_6 + $char_7) * 25 / 100) / 3.5);
        $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
            elseif (1 == $opposition)
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
        $player_air_pass = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_air_pass = $data['take'];
        $data['take']    = 0;
    }

    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_air_pass]['player_id'];
    $condition          = $data[$data['team']]['player'][$player_air_pass]['condition'];
    $practice           = $data[$data['team']]['player'][$player_air_pass]['practice'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $char_1 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_air_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
        $player_fast_pass = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_fast_pass = $data['take'];
        $data['take']     = 0;
    }

    $player_opponent    = f_igosja_generator_select_player($data, $data['opponent']);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_fast_pass]['player_id'];
    $condition          = $data[$data['team']]['player'][$player_fast_pass]['condition'];
    $practice           = $data[$data['team']]['player'][$player_fast_pass]['practice'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $char_1 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_PASS];
    $char_3 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_fast_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
        $player_long_pass = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_long_pass = $data['take'];
        $data['take']     = 0;
    }

    $player_take        = f_igosja_generator_select_player($data, $data['team'], $player_long_pass);
    $player_opponent    = f_igosja_generator_select_player($data, $data['opponent']);
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_long_pass]['player_id'];
    $condition          = $data[$data['team']]['player'][$player_long_pass]['condition'];
    $practice           = $data[$data['team']]['player'][$player_long_pass]['practice'];
    $take_player_id     = $data[$data['team']]['player'][$player_take]['player_id'];
    $opponent_id        = $data[$data['opponent']]['team']['team_id'];
    $opponent_player_id = $data[$data['opponent']]['player'][$player_opponent]['player_id'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $data['take'] = $player_take;

    $char_1 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_AIR_PASS];
    $char_2 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_PASS];
    $char_3 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_long_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4) * 25 / 100) / 2.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
        $player_pass = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_pass  = $data['take'];
        $data['take'] = 0;
    }

    $player_take        = f_igosja_generator_select_player($data, $data['team'], $player_pass);
    $data['take']       = $player_take;
    $game_id            = $data['game_id'];
    $team_id            = $data[$data['team']]['team']['team_id'];
    $minute             = $data['minute'];
    $player_id          = $data[$data['team']]['player'][$player_pass]['player_id'];
    $condition          = $data[$data['team']]['player'][$player_pass]['condition'];
    $practice           = $data[$data['team']]['player'][$player_pass]['practice'];
    $take_player_id     = $data[$data['team']]['player'][$player_take]['player_id'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $char_1 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_PASS];
    $char_2 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_pass]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
        $player_dribling = f_igosja_generator_select_player($data, $data['team']);
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
    $condition          = $data[$data['team']]['player'][$player_dribling]['condition'];
    $practice           = $data[$data['team']]['player'][$player_dribling]['practice'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $char_1 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_DRIBLING];
    $char_2 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_dribling]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
        $player_taking = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_taking = $data['take'];
        $data['take']    = 0;
    }

    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];
    $condition          = $data[$data['team']]['player'][$player_taking]['condition'];
    $practice           = $data[$data['team']]['player'][$player_taking]['practice'];

    $char_1 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_TAKING];
    $char_2 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_taking]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
    $gk_condition       = $data[$data['opponent']]['player'][0]['condition'];
    $gk_practice        = $data[$data['opponent']]['player'][0]['practice'];
    $tournament_id      = $data['tournament']['tournament_id'];
    $season_id          = $data['season'];
    $minute             = $data['minute'];
    $player_shot        = rand(0, 1);
    $player_shot        = $data[$data['team']]['team']['free'][$player_shot];
    $shot_player_id     = $data[$data['team']]['player'][$player_shot]['player_id'];
    $shot_lineup_id     = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $shot_condition     = $data[$data['team']]['player'][$player_shot]['condition'];
    $shot_practice      = $data[$data['team']]['player'][$player_shot]['practice'];
    $player_penalty     = $data[$data['team']]['team']['penalty'];
    $penalty_player_id  = $data[$data['team']]['player'][$player_penalty]['player_id'];
    $penalty_lineup_id  = $data[$data['team']]['player'][$player_penalty]['lineup_id'];
    $penalty_condition  = $data[$data['team']]['player'][$player_penalty]['condition'];
    $penalty_practice   = $data[$data['team']]['player'][$player_penalty]['practice'];
    $player_opposition  = f_igosja_generator_select_player($data, $data['opponent']);
    $lineup_id          = $data[$data['opponent']]['player'][$player_opposition]['lineup_id'];
    $player_id          = $data[$data['opponent']]['player'][$player_opposition]['player_id'];
    $condition          = $data[$data['opponent']]['player'][$player_opposition]['condition'];
    $practice           = $data[$data['opponent']]['player'][$player_opposition]['practice'];
    $team_power         = $data[$data['opponent']]['team']['power'];
    $team_player_number = $data[$data['opponent']]['team']['player_number'];

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
    $char_11    = $data[$data['team']]['player'][$player_penalty]['attribute'][ATTRIBUTE_PENALTY];
    $char_12    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_13    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];
    $char_14    = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_GK_PENALTY];
    $char_15    = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_FREE_KICK];
    $char_16    = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_GK_FREE_KICK];
    $char_17    = $data[$data['team']]['player'][$player_penalty]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_18    = $data[$data['team']]['player'][$player_penalty]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char = round(($char_1 + $char_2 + ($char_3 + $char_4 + $char_5 + $char_6 + $char_7 + $char_8 + $char_9) * 25 / 100) / 3.75);
    $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

    $opposition = rand($char, 200);

    if (130 < $opposition)
    {
        $result = 1;

        $foul_char = rand(100 - $char_10, 200);

        if (150 < $foul_char)
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

            if (200 == $foul_char)
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

                $char = round(($char_11 + ($char_17 + $char_18) * 25 / 100) / 1.5);
                $char = round($char * $penalty_practice * $penalty_condition / 100 / 100) * 10;

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
                        WHERE `statisticplayer_player_id`='$penalty_player_id'
                        AND `statisticplayer_tournament_id`='$tournament_id'
                        AND `statisticplayer_season_id`='$season_id'
                        AND `statisticplayer_team_id`='$team_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_shot`=`lineup_shot`+'1',
                            `lineup_ontarget`=`lineup_ontarget`+'1',
                            `lineup_penalty`=`lineup_penalty`+'1'
                        WHERE `lineup_id`='$penalty_lineup_id'
                        LIMIT 1";
                $mysqli->query($sql);

                $gk_char = round($char_14 * $gk_practice * $gk_condition / 100 / 100);
                $goalkeeper = rand($gk_char, 200);

                if ($char > $goalkeeper)
                {
                    $sql = "INSERT INTO `broadcasting`
                            SET `broadcasting_game_id`='$game_id',
                                `broadcasting_minute`='$minute',
                                `broadcasting_player_id`='$penalty_player_id',
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
                            WHERE `statisticplayer_player_id`='$penalty_player_id'
                            AND `statisticplayer_tournament_id`='$tournament_id'
                            AND `statisticplayer_season_id`='$season_id'
                            AND `statisticplayer_team_id`='$team_id'
                            LIMIT 1";
                    $mysqli->query($sql);

                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='$minute',
                                `event_player_id`='$penalty_player_id',
                                `event_team_id`='$team_id'";
                    $mysqli->query($sql);

                    $sql = "UPDATE `lineup`
                            SET `lineup_goal`=`lineup_goal`+'1',
                                `lineup_penalty_goal`=`lineup_penalty_goal`+'1'
                            WHERE `lineup_id`='$penalty_lineup_id'";
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
                if (199 == $foul_char)
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
                elseif (185 < $foul_char)
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
                $char = round($char * $shot_practice * $shot_condition / 100 / 100);

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

                    $opposition = f_igosja_generator_success($opposition);

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

                        $player_free    = round($char_15 * $shot_practice * $shot_condition / 100 / 100);
                        $player_free    = rand($player_free, 200);
                        $gk_free        = round($char_16 * $gk_practice * $gk_condition / 100 / 100);
                        $gk_free        = rand($gk_free, 200);

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
    $condition = $data[$data['opponent']]['player'][0]['condition'];
    $practice  = $data[$data['opponent']]['player'][0]['practice'];

    $char_1 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_REACTION];
    $char_2 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_HANDS];
    $char_3 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_IN_AREA];
    $char_4 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_CATCH];
    $char_5 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_DEXTERITY];
    $char_6 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_COORDINATE];

    $char = round(($char_1 + $char_2 * 50 / 100 + ($char_3 + $char_4 + $char_5 + $char_6) * 25 / 100) / 2.5);
    $char = round($char * $practice * $condition / 100 / 100);

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
    $gk_condition       = $data[$data['opponent']]['player'][0]['condition'];
    $gk_practice        = $data[$data['opponent']]['player'][0]['practice'];
    $minute             = $data['minute'];
    $player_corner      = rand(0, 1);
    $player_corner      = $data[$data['team']]['corner'][$player_corner];
    $corner_player_id   = $data[$data['team']]['player'][$player_corner]['player_id'];
    $condition          = $data[$data['team']]['player'][$player_corner]['condition'];
    $practice           = $data[$data['team']]['player'][$player_corner]['practice'];
    $player_defence     = f_igosja_generator_select_player($data, $data['opponent']);
    $defence_player_id  = $data[$data['opponent']]['player'][$player_defence]['player_id'];
    $team_power         = $data[$data['team']]['team']['power'];
    $team_player_number = $data[$data['team']]['team']['player_number'];

    $char_1 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_CATCH];
    $char_2 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_CORNER];
    $char_3 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_4 = $data[$data['team']]['player'][$player_corner]['attribute'][ATTRIBUTE_CONCENTRATION];

    $char_1  = $char_1 * $gk_practice * $gk_condition / 100 / 100;
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
        $char = round(($char * $practice * $condition / 100 / 100 + $team_power / MAX_TEAM_POWER) * $team_player_number / NUMBER_PLAYER_ON_FIELD / 2);

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
    $gk_condition   = $data[$data['opponent']]['player'][0]['condition'];
    $gk_practice    = $data[$data['opponent']]['player'][0]['practice'];
    $tournament_id  = $data['tournament']['tournament_id'];
    $season_id      = $data['season'];
    $minute         = $data['minute'];
    $player_pass    = $data['pass'];
    $pass_player_id = $data[$data['team']]['player'][$player_pass]['player_id'];
    $pass_lineup_id = $data[$data['team']]['player'][$player_pass]['lineup_id'];

    if (0 == $data['take'])
    {
        $player_shot = f_igosja_generator_select_player($data, $data['team']);
    }
    else
    {
        $player_shot  = $data['take'];
        $data['take'] = 0;
    }

    $lineup_id = $data[$data['team']]['player'][$player_shot]['lineup_id'];
    $player_id = $data[$data['team']]['player'][$player_shot]['player_id'];
    $condition = $data[$data['team']]['player'][$player_shot]['condition'];
    $practice  = $data[$data['team']]['player'][$player_shot]['practice'];

    $char_1 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_SHOT];
    $char_2 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_COMPOSURE];
    $char_3 = $data[$data['team']]['player'][$player_shot]['attribute'][ATTRIBUTE_CONCENTRATION];
    $char_4 = $data[$data['opponent']]['player'][0]['attribute'][ATTRIBUTE_ONE_ON_ONE];

    $char = round(($char_1 + ($char_2 + $char_3) * 25 / 100) / 1.5);
    $char = round($char * $practice * $condition / 100 / 100);

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

        $gk_play = round($char_4 * $gk_condition * $gk_practice / 100 / 100);
        $gk_play = rand($gk_play, 200);

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

function f_igosja_generator_referee_mark()
//Оценка судьи
{
    global $mysqli;

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `game_referee_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND()
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()";
    $mysqli->query($sql);
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

    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `player_condition`=`lineup_condition`,
                `player_practice`=`player_practice`+'10'+'5'*RAND()
            WHERE `shedule_date`=CURDATE()
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
}

function f_igosja_generator_statistic_team_user_referee()
//Обновляем статистику судей, команд и менеджеров
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

function f_igosja_generator_game_tire()
{
    global $mysqli;

    $sql = "UPDATE `lineup`
            LEFT JOIN `game`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            SET `lineup_condition`=`lineup_condition`-'1'
            WHERE `shedule_date`=CURDATE()
            AND `lineup_condition`>'50'
            AND `game_played`='0'";
    $mysqli->query($sql);
}

function f_igosja_generator_select_player($data, $team, $player_1 = 0)
//Выбор игрока, который владеет мячом
{
    $player = rand(1, 10);
    $red    = $data[$team]['player'][$player]['red'];
    $yellow = $data[$team]['player'][$player]['yellow'];

    if ($player == $player_1 ||
        $red == 1 ||
        $yellow == 2)
    {
        $player = f_igosja_generator_select_player($data, $team, $player_1);
    }

    return $player;
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
                            `recordteam_date_start`='$date_start'
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
                            `recordtournament_date_start`='$date_start'
                            `recordtournament_recordtournamenttype_id`='$record'";
                $mysqli->query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

                $record_value = $record_array[0]['recordteam_value'];

                if ($record_value < $value)
                {
                    $sql = "UPDATE `recordteam`
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
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $visitor        = $game_array[$i]['game_visitor'];
        $total_score    = $home_score + $guest_score;

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$home_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$home_team_id',
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
                        WHERE `recordteam_team_id`='$home_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$guest_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$guest_team_id',
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
                        WHERE `recordteam_team_id`='$guest_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_ATTENDANCE . "'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$home_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$home_team_id',
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
                        WHERE `recordteam_team_id`='$home_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$guest_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$guest_team_id',
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
                        WHERE `recordteam_team_id`='$guest_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_ATTENDANCE . "'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$home_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$home_team_id',
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
                        WHERE `recordteam_team_id`='$home_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordteam_value`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$guest_team_id'
                AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$guest_team_id',
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
                        WHERE `recordteam_team_id`='$guest_team_id'
                        AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_SCORE . "'";
                $mysqli->query($sql);
            }
        }

        if ($home_score > $guest_score)
        {
            $score = $home_score - $guest_score;

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$home_team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$home_team_id',
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
                            WHERE `recordteam_team_id`='$home_team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'";
                    $mysqli->query($sql);
                }
            }

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$guest_team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$guest_team_id',
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
                            WHERE `recordteam_team_id`='$guest_team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'";
                    $mysqli->query($sql);
                }
            }
        }
        elseif ($home_score < $guest_score)
        {
            $score = $guest_score - $home_score;

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$home_team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$home_team_id',
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
                            WHERE `recordteam_team_id`='$home_team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_LOOSE . "'";
                    $mysqli->query($sql);
                }
            }

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$guest_team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN. "'
                    LIMIT 1";
            $record_sql = $mysqli->query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$guest_team_id',
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
                            WHERE `recordteam_team_id`='$guest_team_id'
                            AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_WIN . "'";
                    $mysqli->query($sql);
                }
            }
        }
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
    }
}

function f_igosja_generator_mood_after_game()
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
            SET `player_mood`='7'
            WHERE `player_mood`>'7'";
    $mysqli->query($sql);
}

function f_igosja_generator_injury_after_game()
{
    global $mysqli;

    $sql = "UPDATE `injury`
            LEFT JOIN `player`
            ON `injury_player_id`=`player_id`
            SET `player_injury`='0'
            WHERE `injury_end_date`<=CURDATE()";
    $mysqli->query($sql);
}

function f_igosja_generator_game_moments()
{
    global $mysqli;

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_home_moment`=`game_home_shot`/(2 + 2*RAND()),
            `game_guest_moment`=`game_guest_shot`/(2 + 2*RAND())
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $mysqli->query($sql);
}

function f_igosja_generator_game_offside()
{
    global $mysqli;
    
    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id`";
    $game_sql = $mysqli->query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id        = $game_array[$i]['game_id'];
        $home_id        = $game_array[$i]['game_home_team_id'];
        $guest_id       = $game_array[$i]['game_guest_team_id'];
        $home_offside   = rand(3, 6);
        $guest_offside  = rand(3, 6);

        $sql = "UPDATE `game`
                SET `game_guest_offside`='$guest_offside',
                    `game_home_offside`='$home_offside'
                WHERE `game_id`='$game_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_offside`='2'
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$home_id'
                ORDER BY `lineup_position_id` DESC
                LIMIT 1";
        $mysqli->query($sql);

        $limit = $home_offside - 2;

        $sql = "UPDATE `lineup`
                SET `lineup_offside`='1'
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$home_id'
                ORDER BY `lineup_position_id` DESC
                LIMIT 1, $limit";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_offside`='2'
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$guest_id'
                ORDER BY `lineup_position_id` DESC
                LIMIT 1";
        $mysqli->query($sql);

        $limit = $guest_offside - 2;

        $sql = "UPDATE `lineup`
                SET `lineup_offside`='1'
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$guest_id'
                ORDER BY `lineup_position_id` DESC
                LIMIT 1, $limit";
        $mysqli->query($sql);
    }
}

function f_igosja_generator_standing_history()
{
    global $mysqli;
    global $igosja_season_id;

    $sql = "INSERT INTO `standinghistory` (`standinghistory_tournament_id`, `standinghistory_team_id`, `standinghistory_stage_id`, `standinghistory_place`)
            SELECT `standing_tournament_id`, `standing_team_id`, `standing_game`, `standing_place`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'";
    $mysqli->query($sql);
}

function f_igosja_generator_training()
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