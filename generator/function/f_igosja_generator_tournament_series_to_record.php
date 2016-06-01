<?php

function f_igosja_generator_tournament_series_to_record()
//Обровление турнирных рекордов из серий матчей (побед, без поражений, без пропущенных...)
{
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
        $tournament_sql = f_igosja_mysqli_query($sql);

        $count_tournament = $tournament_sql->num_rows;

        $tournament_array = $tournament_sql->fetch_all(1);

        for ($i=0; $i<$count_tournament; $i++)
        {
            $tournament_id = $tournament_array[$i]['series_tournament_id'];

            $sql = "SELECT `series_country_id`,
                           `series_date_end`,
                           `series_date_start`,
                           `series_team_id`,
                           `series_value`
                    FROM `series`
                    WHERE `series_seriestype_id`='$series'
                    AND `series_tournament_id`='$tournament_id'
                    ORDER BY `series_value` DESC
                    LIMIT 1";
            $series_sql = f_igosja_mysqli_query($sql);

            $series_array = $series_sql->fetch_all(1);

            $team_id    = $series_array[0]['series_team_id'];
            $date_start = $series_array[0]['series_date_start'];
            $date_end   = $series_array[0]['series_date_end'];
            $value      = $series_array[0]['series_value'];

            if (0 == $team_id)
            {
                $team_id = $series_array[0]['series_country_id'];
            }

            $sql = "SELECT `recordtournament_value_1`
                    FROM `recordtournament`
                    WHERE `recordtournament_tournament_id`='$tournament_id'
                    AND `recordtournament_recordtournamenttype_id`='$record'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordtournament`
                        SET `recordtournament_tournament_id`='$tournament_id',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_value_1`='$value',
                            `recordtournament_date_end`='$date_end',
                            `recordtournament_date_start`='$date_start',
                            `recordtournament_recordtournamenttype_id`='$record'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordtournament_value_1'];

                if ($record_value < $value)
                {
                    $sql = "UPDATE `recordtournament`
                            SET `recordtournament_team_id`='$team_id',
                                `recordtournament_value_1`='$value',
                                `recordtournament_date_end`='$date_end',
                                `recordtournament_date_start`='$date_start'
                            WHERE `recordtournament_recordtournamenttype_id`='$record'
                            AND `recordtournament_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }

            usleep(1);

            print '.';
            flush();
        }
    }
}