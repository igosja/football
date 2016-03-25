<?php

function f_igosja_generator_cup_next_stage()
//Кубковые турниры - следующая стадия
{
    global $mysqli;

    $sql = "SELECT `shedule_tournamenttype_id`
            FROM `shedule`
            WHERE `shedule_date`=CURDATE()
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $tournamenttype_id = $shedule_array[0]['shedule_tournamenttype_id'];

    if (TOURNAMENT_TYPE_CUP == $tournamenttype_id)
    {
        $sql = "SELECT `game_first_game_id`,
                       `game_guest_score`,
                       `game_guest_shoot_out`,
                       `game_guest_team_id`,
                       `game_home_score`,
                       `game_home_shoot_out`,
                       `game_home_team_id`,
                       `game_stage_id`,
                       `game_tournament_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND `game_first_game_id`!='0'
                ORDER BY `game_id` ASC";
        $game_sql = f_igosja_mysqli_query($sql);

        $count_game = $game_sql->num_rows;
        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_game; $i++)
        {
            $game_id         = $game_array[$i]['game_first_game_id'];
            $home_score      = $game_array[$i]['game_home_score'];
            $home_shoot_out  = $game_array[$i]['game_home_shoot_out'];
            $home_team_id    = $game_array[$i]['game_home_team_id'];
            $guest_score     = $game_array[$i]['game_guest_score'];
            $guest_shoot_out = $game_array[$i]['game_guest_shoot_out'];
            $guest_team_id   = $game_array[$i]['game_guest_team_id'];
            $stage_id        = $game_array[$i]['game_stage_id'];
            $tournament_id   = $game_array[$i]['game_tournament_id'];

            $sql = "SELECT `game_guest_score`,
                           `game_home_score`
                    FROM `game`
                    WHERE `game_id`='$game_id'
                    LIMIT 1";
            $first_game_sql = f_igosja_mysqli_query($sql);

            $first_game_array = $first_game_sql->fetch_all(MYSQLI_ASSOC);

            $first_home_score  = $first_game_array[0]['game_home_score'];
            $first_guest_score = $first_game_array[0]['game_guest_score'];

            if ($home_score + $home_shoot_out + $first_guest_score > $guest_score + $guest_shoot_out + $first_home_score)
            {
                $looser = $guest_team_id;
            }
            else
            {
                $looser = $home_team_id;
            }

            $sql = "UPDATE `cupparticipant`
                    SET `cupparticipant_out`='$stage_id'
                    WHERE `cupparticipant_tournament_id`='$tournament_id'
                    AND `cupparticipant_team_id`='$looser'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        if (0 != $count_game)
        {
            $sql = "SELECT `shedule_id`
                    FROM `shedule`
                    WHERE `shedule_date`>CURDATE()
                    AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
                    ORDER BY `shedule_date` ASC
                    LIMIT 2";
            $shedule_sql = f_igosja_mysqli_query($sql);

            $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

            if (isset($shedule_array[0]['shedule_id']))
            {
                $shedule_1 = $shedule_array[0]['shedule_id'];
            }

            if (isset($shedule_array[1]['shedule_id']))
            {
                $shedule_2 = $shedule_array[1]['shedule_id'];
            }

            $sql = "SELECT `cupparticipant_tournament_id`
                    FROM `cupparticipant`
                    GROUP BY `cupparticipant_tournament_id`
                    ORDER BY `cupparticipant_tournament_id` ASC";
            $tournament_sql = f_igosja_mysqli_query($sql);

            $count_tournament = $tournament_sql->num_rows;
            $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0; $i<$count_tournament; $i++)
            {
                $tournament_id  = $tournament_array[$i]['cupparticipant_tournament_id'];

                $sql = "SELECT `cupparticipant_team_id`
                        FROM `cupparticipant`
                        WHERE `cupparticipant_tournament_id`='$tournament_id'
                        AND `cupparticipant_out`='0'
                        ORDER BY RAND()";
                $team_sql = f_igosja_mysqli_query($sql);

                $count_team = $team_sql->num_rows;
                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                for ($j=0; $j<$count_team; $j=$j+2)
                {
                    $team_1 = $team_array[$j]['cupparticipant_team_id'];
                    $team_2 = $team_array[$j+1]['cupparticipant_team_id'];

                    if (isset($shedule_1))
                    {
                        $sql = "INSERT INTO `game`
                                SET `game_guest_team_id`='$team_2',
                                    `game_home_team_id`='$team_1',
                                    `game_referee_id`='1',
                                    `game_stadium_id`='$team_1',
                                    `game_stage_id`='$stage_id'+'1',
                                    `game_shedule_id`='$shedule_1',
                                    `game_temperature`='15'+RAND()*'15',
                                    `game_tournament_id`='$tournament_id',
                                    `game_weather_id`='1'+RAND()*'3'";
                        f_igosja_mysqli_query($sql);

                        if (isset($shedule_2))
                        {
                            $game_id = $mysqli->insert_id;

                            $sql = "INSERT INTO `game`
                                    SET `game_first_game_id`='$game_id',
                                        `game_guest_team_id`='$team_1',
                                        `game_home_team_id`='$team_2',
                                        `game_referee_id`='1',
                                        `game_stadium_id`='$team_2',
                                        `game_stage_id`='$stage_id'+'1',
                                        `game_shedule_id`='$shedule_2',
                                        `game_temperature`='15'+RAND()*'15',
                                        `game_tournament_id`='$tournament_id',
                                        `game_weather_id`='1'+RAND()*'3'";
                            f_igosja_mysqli_query($sql);
                        }
                    }
                }
            }
        }
    }
}