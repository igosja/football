<?php

function f_igosja_season_worldcup_position_record()
{
    global $igosja_season_id;

    $sql = "SELECT `worldcup_tournament_id`
            FROM `worldcup`
            WHERE `worldcup_season_id`='$igosja_season_id'
            ORDER BY `worldcup_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['worldcup_tournament_id'];

        $sql = "SELECT `worldcup_place`,
                       `worldcup_country_id`
                FROM `worldcup`
                WHERE `worldcup_tournament_id`='$tournament_id'
                ORDER BY `worldcup_place` DESC
                LIMIT 1";
        $country_sql = f_igosja_mysqli_query($sql);

        $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

        $country_id = $country_array[0]['worldcup_country_id'];
        $place      = $country_array[0]['worldcup_place'];

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_HIGHEST_POSITION . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_HIGHEST_POSITION . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_tournament_id`='$tournament_id',
                        `recordcountry_value`='$place'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_place = $record_array[0]['recordcountry_value'];

            if ($place < $record_place)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_value`='$place',
                            `recordcountry_country_id`='$country_id'
                        WHERE `recordcountry_tournament_id`='$tournament_id'
                        AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_HIGHEST_POSITION . "'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `recordcountry_value`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$country_id'
                AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_LOWEST_POSITION . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_LOWEST_POSITION . "',
                        `recordcountry_country_id`='$country_id',
                        `recordcountry_tournament_id`='$tournament_id',
                        `recordcountry_value`='$place'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_place = $record_array[0]['recordcountry_value'];

            if ($place > $record_place)
            {
                $sql = "UPDATE `recordcountry`
                        SET `recordcountry_value`='$place',
                            `recordcountry_country_id`='$country_id'
                        WHERE `recordcountry_tournament_id`='$tournament_id'
                        AND `recordcountry_recordcountrytype_id`='" . RECORD_COUNTRY_LOWEST_POSITION . "'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}