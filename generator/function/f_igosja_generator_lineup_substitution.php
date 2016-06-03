<?php

function f_igosja_generator_lineup_substitution()
//Замены по ходу матча
{
    $sql = "SELECT `game_id`,
                   `game_guest_country_id`,
                   `game_guest_team_id`,
                   `game_home_country_id`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $game_id            = $game_array[$i]['game_id'];
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $home_country_id    = $game_array[$i]['game_home_country_id'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $guest_country_id   = $game_array[$i]['game_guest_country_id'];
        $home_score         = 0;
        $guest_score        = 0;
        $home_red           = 0;
        $guest_red          = 0;
        $minute_array       = array('home' => array(), 'guest' => array());
        $score_array        = array();

        $sql = "SELECT `event_eventtype_id`,
                       `event_minute`,
                       `event_team_id`
                FROM `event`
                WHERE `event_game_id`='$game_id'
                ORDER BY `event_minute` ASC";
        $event_sql = f_igosja_mysqli_query($sql);

        $count_event = $event_sql->num_rows;
        $event_array = $event_sql->fetch_all(1);

        for ($j=0; $j<$count_event; $j++)
        {
            $eventtype_id = $event_array[$j]['event_eventtype_id'];

            if (in_array($eventtype_id, array(1, 3)))
            {
                $minute     = $event_array[$j]['event_minute'];
                $team_id    = $event_array[$j]['event_team_id'];

                if (7 == $eventtype_id)
                {
                    if ($team_id == $home_team_id && 0 == $home_red)
                    {
                        for ($k=$minute; $k<=90; $k++)
                        {
                            $minute_array['home'][$k][] = 9;
                            $minute_array['guest'][$k][] = 10;
                        }
                    }
                    elseif ($team_id == $guest_team_id && 0 == $guest_red)
                    {
                        for ($k=$minute; $k<=90; $k++)
                        {
                            $minute_array['guest'][$k][] = 9;
                            $minute_array['home'][$k][] = 10;
                        }
                    }
                }
                else
                {
                    if ($team_id == $home_team_id)
                    {
                        $home_score++;
                    }
                    elseif ($team_id == $guest_team_id)
                    {
                        $guest_score++;
                    }

                    $score_array[$minute] = array($home_score, $guest_score);
                }
            }
        }

        $prev_minute                = 1;
        $prev_home_condition_array  = array(1, 5, 11, 12);
        $prev_guest_condition_array = array(1, 5, 11, 12);

        foreach ($score_array as $key => $value)
        {
            for ($k=$prev_minute; $k<$key; $k++)
            {
                $minute_array['home'][$k]   = $prev_home_condition_array;
                $minute_array['guest'][$k]  = $prev_guest_condition_array;
            }

            $prev_minute = $key;

            if ($value[0] >= $value[1] + 3)
            {
                $prev_home_condition_array  = array(1, 6, 7, 8, 11);
                $prev_guest_condition_array = array(1, 2, 3, 4, 12);
            }
            elseif ($value[0] == $value[1] + 2)
            {
                $prev_home_condition_array  = array(1, 6, 7, 11);
                $prev_guest_condition_array = array(1, 2, 3, 12);
            }
            elseif ($value[0] == $value[1] + 1)
            {
                $prev_home_condition_array  = array(1, 6, 11);
                $prev_guest_condition_array = array(1, 2, 12);
            }
            elseif ($value[0] == $value[1])
            {
                $prev_home_condition_array  = array(1, 5, 11, 12);
                $prev_guest_condition_array = array(1, 5, 11, 12);
            }
            elseif ($value[0] + 1 == $value[1])
            {
                $prev_home_condition_array  = array(1, 2, 12);
                $prev_guest_condition_array = array(1, 6, 11);
            }
            elseif ($value[0] + 2 == $value[1])
            {
                $prev_home_condition_array  = array(1, 2, 3, 12);
                $prev_guest_condition_array = array(1, 6, 7, 11);
            }
            elseif ($value[0] + 3 <= $value[1])
            {
                $prev_home_condition_array  = array(1, 2, 3, 4, 12);
                $prev_guest_condition_array = array(1, 6, 7, 8, 11);
            }
        }

        for ($k=$prev_minute; $k<=90; $k++)
        {
            $minute_array['home'][$k]   = $prev_home_condition_array;
            $minute_array['guest'][$k]  = $prev_guest_condition_array;
        }

        for ($j=0; $j<$count_event; $j++)
        {
            $eventtype_id = $event_array[$j]['event_eventtype_id'];

            if (7 == $eventtype_id)
            {
                $minute     = $event_array[$j]['event_minute'];
                $team_id    = $event_array[$j]['event_team_id'];

                if ($team_id == $home_team_id && 0 == $home_red)
                {
                    for ($k=$minute; $k<=90; $k++)
                    {
                        $minute_array['home'][$k][] = 9;
                        $minute_array['guest'][$k][] = 10;
                    }
                }
                elseif ($team_id == $guest_team_id && 0 == $guest_red)
                {
                    for ($k=$minute; $k<=90; $k++)
                    {
                        $minute_array['guest'][$k][] = 9;
                        $minute_array['home'][$k][] = 10;
                    }
                }
            }
        }

        for ($k=0; $k<HOME_GUEST_LOOP; $k++)
        {
            if (0 == $k)
            {
                $team_id    = $home_team_id;
                $country_id = $home_country_id;
                $array_key  = 'home';
            }
            else
            {
                $team_id    = $guest_team_id;
                $country_id = $guest_country_id;
                $array_key  = 'guest';
            }

            $sql = "SELECT `lineupsubstitution_in`,
                           `lineupsubstitution_lineupcondition_id`,
                           `lineupsubstitution_minute`,
                           `lineupsubstitution_out`
                    FROM `lineupsubstitution`
                    WHERE `lineupsubstitution_game_id`='$game_id'
                    AND `lineupsubstitution_team_id`='$team_id'
                    AND `lineupsubstitution_country_id`='$country_id'
                    ORDER BY `lineupsubstitution_minute` ASC";
            $substitution_sql = f_igosja_mysqli_query($sql);

            $count_substitution = $substitution_sql->num_rows;
            $substitution_array = $substitution_sql->fetch_all(1);

            foreach ($minute_array[$array_key] as $key => $value)
            {
                foreach ($substitution_array as $item)
                {
                    if ($item['lineupsubstitution_minute'] <= $key &&
                        in_array($item['lineupsubstitution_lineupcondition_id'], $value))
                    {
                        $player_in  = $item['lineupsubstitution_in'];
                        $player_out = $item['lineupsubstitution_out'];

                        $sql = "SELECT COUNT(`lineup_id`) AS `count`
                                FROM `lineup`
                                WHERE `lineup_id`='$player_out'
                                AND `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$team_id'
                                AND `lineup_country_id`='$country_id'
                                AND `lineup_out`='0'
                                AND `lineup_yellow`<'2'
                                AND `lineup_red`='0'";
                        $out_sql = f_igosja_mysqli_query($sql);

                        $out_array = $out_sql->fetch_all(1);
                        $count_out = $out_array[0]['count'];

                        $sql = "SELECT COUNT(`lineup_id`) AS `count`
                                FROM `lineup`
                                WHERE `lineup_id`='$player_in'
                                AND `lineup_game_id`='$game_id'
                                AND `lineup_team_id`='$team_id'
                                AND `lineup_country_id`='$country_id'
                                AND `lineup_in`='0'
                                AND `lineup_yellow`<'2'
                                AND `lineup_red`='0'";
                        $in_sql = f_igosja_mysqli_query($sql);

                        $in_array = $in_sql->fetch_all(1);
                        $count_in = $in_array[0]['count'];

                        if (0 != $count_in && 0 != $count_out)
                        {
                            $sql = "UPDATE `lineup`
                                    SET `lineup_out`='$key'
                                    WHERE `lineup_id`='$player_out'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);

                            $sql = "UPDATE `lineup`
                                    SET `lineup_in`='$key'
                                    WHERE `lineup_id`='$player_in'
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);

                            for ($j=0; $j<$count_substitution; $j++)
                            {
                                if ($substitution_array[$j]['lineupsubstitution_in'] == $item['lineupsubstitution_in'] ||
                                    $substitution_array[$j]['lineupsubstitution_out'] == $item['lineupsubstitution_out'])
                                {
                                    unset($substitution_array[$j]);
                                }
                            }
                        }

                        sort($substitution_array);
                        $count_substitution = count($substitution_array);
                    }
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}