<?php

function f_igosja_generator_lineup_event()
//Cоздаем события матча
{
    $sql = "SELECT `game_id`,
                   `game_guest_country_id`,
                   `game_guest_penalty`,
                   `game_guest_red`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_guest_yellow`,
                   `game_home_country_id`,
                   `game_home_penalty`,
                   `game_home_red`,
                   `game_home_score`,
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
            $score          = $game_array[$i]['game_' . $team . '_score'];
            $penalty        = $game_array[$i]['game_' . $team . '_penalty'];
            $red            = $game_array[$i]['game_' . $team . '_red'];
            $yellow         = $game_array[$i]['game_' . $team . '_yellow'];

            if (0 != $team_id)
            {
                for ($j=0; $j<$penalty; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_team_id`='$team_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$score-$penalty; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_team_id`='$team_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$yellow; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_YELLOW . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_team_id`='$team_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$red; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_RED . "',
                                `event_game_id`='$game_id',
                                `event_minute`='70'+'20'*RAND(),
                                `event_team_id`='$team_id'";
                    f_igosja_mysqli_query($sql);
                }
            }
            else
            {
                for ($j=0; $j<$penalty; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_PENALTY_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_country_id`='$country_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$score-$penalty; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_GOAL . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_country_id`='$country_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$yellow; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_YELLOW . "',
                                `event_game_id`='$game_id',
                                `event_minute`='1'+'89'*RAND(),
                                `event_country_id`='$country_id'";
                    f_igosja_mysqli_query($sql);
                }

                for ($j=0; $j<$red; $j++)
                {
                    $sql = "INSERT INTO `event`
                            SET `event_eventtype_id`='" . EVENT_RED . "',
                                `event_game_id`='$game_id',
                                `event_minute`='70'+'20'*RAND(),
                                `event_country_id`='$country_id'";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}