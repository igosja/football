<?php

function f_igosja_generator_country_series_to_record()
//Обровление командных рекордов из серий матчей (побед, без поражений, без пропущенных...)
{
    for ($j=0; $j<6; $j++)
    {
        if     (0 == $j) {$series = SERIES_WIN;         $record = RECORD_COUNTRY_WIN;}
        elseif (1 == $j) {$series = SERIES_NO_LOOSE;    $record = RECORD_COUNTRY_NO_LOOSE;}
        elseif (2 == $j) {$series = SERIES_NO_WIN;      $record = RECORD_COUNTRY_NO_WIN;}
        elseif (3 == $j) {$series = SERIES_LOOSE;       $record = RECORD_COUNTRY_LOOSE;}
        elseif (4 == $j) {$series = SERIES_NO_PASS;     $record = RECORD_COUNTRY_NO_PASS;}
        else             {$series = SERIES_NO_SCORE;    $record = RECORD_COUNTRY_NO_SCORE;}

        $sql = "SELECT `series_date_end`,
                       `series_date_start`,
                       `series_country_id`,
                       `series_value`
                FROM `series`
                WHERE `series_seriestype_id`='$series'
                AND `series_tournament_id`='0'
                ORDER BY `series_country_id` ASC";
        $series_sql = f_igosja_mysqli_query($sql);

        $count_series = $series_sql->num_rows;
        $series_array = $series_sql->fetch_all(1);

        for ($i=0; $i<$count_series; $i++)
        {
            $country_id = $series_array[$i]['series_country_id'];
            $date_start = $series_array[$i]['series_date_start'];
            $date_end   = $series_array[$i]['series_date_end'];
            $value      = $series_array[$i]['series_value'];

            $sql = "SELECT `recordcountry_value`
                    FROM `recordcountry`
                    WHERE `recordcountry_country_id`='$country_id'
                    AND `recordcountry_recordcountrytype_id`='$record'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordcountry`
                        SET `recordcountry_country_id`='$country_id',
                            `recordcountry_value`='$value',
                            `recordcountry_date_end`='$date_end',
                            `recordcountry_date_start`='$date_start',
                            `recordcountry_recordcountrytype_id`='$record'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(1);

                $record_value = $record_array[0]['recordcountry_value'];

                if ($record_value < $value)
                {
                    $sql = "UPDATE `recordcountry`
                            SET `recordcountry_value`='$value',
                                `recordcountry_date_end`='$date_end',
                                `recordcountry_date_start`='$date_start'
                            WHERE `recordcountry_recordcountrytype_id`='$record'
                            AND `recordcountry_country_id`='$country_id'
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