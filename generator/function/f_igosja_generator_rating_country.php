<?php

function f_igosja_generator_rating_country()
//Обновляем турнирные таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_country_id`,
                   `game_guest_score`,
                   `game_home_country_id`,
                   `game_home_score`,
                   `tournament_tournamenttype_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_country_id    = $game_array[$i]['game_home_country_id'];
        $home_score         = $game_array[$i]['game_home_score'];
        $guest_country_id   = $game_array[$i]['game_guest_country_id'];
        $guest_score        = $game_array[$i]['game_guest_score'];
        $tournamenttype     = $game_array[$i]['tournament_tournamenttype_id'];
        $home_win           = 0;
        $home_draw          = 0;
        $home_loose         = 0;
        $guest_win          = 0;
        $guest_draw         = 0;
        $guest_loose        = 0;

        if (TOURNAMENT_TYPE_WORLD_CUP == $tournamenttype)
        {
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

            $sql = "UPDATE `ratingcountryseason`
                    SET `ratingcountryseason_game`=`ratingcountryseason_game`+'1',
                        `ratingcountryseason_win`=`ratingcountryseason_win`+'$home_win',
                        `ratingcountryseason_draw`=`ratingcountryseason_draw`+'$home_draw',
                        `ratingcountryseason_loose`=`ratingcountryseason_loose`+'$home_loose',
                        `ratingcountryseason_point`=`ratingcountryseason_win`*'2'+`ratingcountryseason_draw`
                    WHERE `ratingcountryseason_country_id`='$home_country_id'
                    AND `ratingcountryseason_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `ratingcountryseason`
                    SET `ratingcountryseason_game`=`ratingcountryseason_game`+'1',
                        `ratingcountryseason_win`=`ratingcountryseason_win`+'$guest_win',
                        `ratingcountryseason_draw`=`ratingcountryseason_draw`+'$guest_draw',
                        `ratingcountryseason_loose`=`ratingcountryseason_loose`+'$guest_loose',
                        `ratingcountryseason_win`=`ratingcountryseason_win`*'2'+`ratingcountryseason_draw`
                    WHERE `ratingcountryseason_country_id`='$guest_country_id'
                    AND `ratingcountryseason_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `ratingcountry_country_id`
            FROM `ratingcountry`
            ORDER BY `ratingcountry_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_country; $i++)
    {
        $country_id     = $country_array[$i]['ratingcountry_country_id'];
        $rating_value   = 0;

        for ($j=0; $j<5; $j++)
        {
            $sql = "SELECT `ratingcountryseason_point`
                    FROM `ratingcountryseason`
                    WHERE `ratingcountryseason_country_id`='$country_id'
                    AND `ratingcountryseason_season_id`='$igosja_season_id'-'$j'
                    LIMIT 1";
            $season_sql = f_igosja_mysqli_query($sql);

            $count_season = $season_sql->num_rows;

            if (0 != $count_season)
            {
                $season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

                $season_rating = $season_array[0]['ratingcountryseason_point'] * (1 - 0.2 * $j);
            }
            else
            {
                $season_rating = 0;
            }

            $rating_value = $rating_value + $season_rating;

            $sql = "UPDATE `ratingcountry`
                    SET `ratingcountry_value`='$rating_value'
                    WHERE `ratingcountry_country_id`='$country_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `ratingcountry_id`
            FROM `ratingcountry`
            ORDER BY `ratingcountry_value` DESC";
    $ratingcountry_sql = f_igosja_mysqli_query($sql);

    $count_ratingcountry = $ratingcountry_sql->num_rows;
    $ratingcountry_array = $ratingcountry_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_ratingcountry; $i++)
    {
        $ratingcountry_id = $ratingcountry_array[$i]['ratingcountry_id'];

        $place = $i + 1;

        $sql = "UPDATE `ratingcountry`
                SET `ratingcountry_position`='$place'
                WHERE `ratingcountry_id`='$ratingcountry_id'";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}