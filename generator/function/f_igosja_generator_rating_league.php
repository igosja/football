<?php

function f_igosja_generator_rating_league()
//Обновляем турнирные таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_guest_score`,
                   `game_home_team_id`,
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
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $tournamenttype = $game_array[$i]['tournament_tournamenttype_id'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;

        if (TOURNAMENT_TYPE_CHAMPIONS_LEAGUE == $tournamenttype)
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

            $sql = "UPDATE `ratingteamseason`
                    SET `ratingteamseason_game`=`ratingteamseason_game`+'1',
                        `ratingteamseason_win`=`ratingteamseason_win`+'$home_win',
                        `ratingteamseason_draw`=`ratingteamseason_draw`+'$home_draw',
                        `ratingteamseason_loose`=`ratingteamseason_loose`+'$home_loose',
                        `ratingteamseason_point`=`ratingteamseason_win`*'2'+`ratingteamseason_draw`
                    WHERE `ratingteamseason_team_id`='$home_team_id'
                    AND `ratingteamseason_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `ratingteamseason`
                    SET `ratingteamseason_game`=`ratingteamseason_game`+'1',
                        `ratingteamseason_win`=`ratingteamseason_win`+'$guest_win',
                        `ratingteamseason_draw`=`ratingteamseason_draw`+'$guest_draw',
                        `ratingteamseason_loose`=`ratingteamseason_loose`+'$guest_loose',
                        `ratingteamseason_win`=`ratingteamseason_win`*'2'+`ratingteamseason_draw`
                    WHERE `ratingteamseason_team_id`='$guest_team_id'
                    AND `ratingteamseason_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    usleep(1);

    print '.';
    flush();
}