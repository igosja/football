<?php

function f_igosja_generator_standing()
//Обновляем турнирные таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_guest_score`,
                   `game_home_team_id`,
                   `game_home_score`,
                   `game_stage_id`,
                   `game_tournament_id`,
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

    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $stage_id       = $game_array[$i]['game_stage_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $tournamenttype = $game_array[$i]['tournament_tournamenttype_id'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;

        if ($stage_id >= 1 &&
            $stage_id <= 38 &&
            TOURNAMENT_TYPE_CHAMPIONSHIP == $tournamenttype)
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
            f_igosja_mysqli_query($sql);

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
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `standing_country_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            GROUP BY `standing_country_id`
            ORDER BY `standing_country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(1);

    for ($i=0; $i<$count_country; $i++)
    {
        $country_id = $country_array[$i]['standing_country_id'];

        $sql = "SELECT `standing_id`
                FROM `standing`
                WHERE `standing_country_id`='$country_id'
                AND `standing_season_id`='$igosja_season_id'
                ORDER BY `standing_point` DESC, `standing_score`-`standing_pass` DESC, `standing_score` DESC";
        $standing_sql = f_igosja_mysqli_query($sql);

        $count_standing = $standing_sql->num_rows;
        $standing_array = $standing_sql->fetch_all(1);

        for ($j=0; $j<$count_standing; $j++)
        {
            $standing_id = $standing_array[$j]['standing_id'];

            $place = $j + 1;

            $sql = "UPDATE `standing`
                    SET `standing_place`='$place'
                    WHERE `standing_id`='$standing_id'";
            f_igosja_mysqli_query($sql);
        }
    }

    usleep(1);

    print '.';
    flush();
}