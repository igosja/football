<?php

function f_igosja_generator_team_series_to_record()
//Обровление командных рекордов из серий матчей (побед, без поражений, без пропущенных...)
{
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
        $series_sql = f_igosja_mysqli_query($sql);

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
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_team_id`='$team_id',
                            `recordteam_value`='$value',
                            `recordteam_date_end`='$date_end',
                            `recordteam_date_start`='$date_start',
                            `recordteam_recordteamtype_id`='$record'";
                f_igosja_mysqli_query($sql);
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
                    f_igosja_mysqli_query($sql);
                }
            }

            usleep(1);

            print '.';
            flush();
        }
    }
}