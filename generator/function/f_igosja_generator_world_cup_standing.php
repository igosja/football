<?php

function f_igosja_generator_world_cup_standing()
//Обновляем турнирные таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_country_id`,
                   `game_guest_score`,
                   `game_home_country_id`,
                   `game_home_score`,
                   `game_stage_id`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
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
        $stage_id           = $game_array[$i]['game_stage_id'];
        $tournament_id      = $game_array[$i]['game_tournament_id'];
        $home_win           = 0;
        $home_draw          = 0;
        $home_loose         = 0;
        $guest_win          = 0;
        $guest_draw         = 0;
        $guest_loose        = 0;

        if (TOURNAMENT_WORLD_CUP == $tournament_id)
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

            $sql = "UPDATE `worldcup`
                    SET `worldcup_game`=`worldcup_game`+'1',
                        `worldcup_win`=`worldcup_win`+'$home_win',
                        `worldcup_draw`=`worldcup_draw`+'$home_draw',
                        `worldcup_loose`=`worldcup_loose`+'$home_loose',
                        `worldcup_score`=`worldcup_score`+'$home_score',
                        `worldcup_pass`=`worldcup_pass`+'$guest_score',
                        `worldcup_point`=`worldcup_win`*'3'+`worldcup_draw`
                    WHERE `worldcup_country_id`='$home_country_id'
                    AND `worldcup_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `worldcup`
                    SET `worldcup_game`=`worldcup_game`+'1',
                        `worldcup_win`=`worldcup_win`+'$guest_win',
                        `worldcup_draw`=`worldcup_draw`+'$guest_draw',
                        `worldcup_loose`=`worldcup_loose`+'$guest_loose',
                        `worldcup_score`=`worldcup_score`+'$guest_score',
                        `worldcup_pass`=`worldcup_pass`+'$home_score',
                        `worldcup_point`=`worldcup_win`*'3'+`worldcup_draw`
                    WHERE `worldcup_country_id`='$guest_country_id'
                    AND `worldcup_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `worldcup_id`
            FROM `worldcup`
            WHERE `worldcup_season_id`='$igosja_season_id'
            ORDER BY `worldcup_point` DESC, `worldcup_score`-`worldcup_pass` DESC, `worldcup_score` DESC";
    $worldcup_sql = f_igosja_mysqli_query($sql);

    $count_worldcup = $worldcup_sql->num_rows;
    $worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_worldcup; $i++)
    {
        $worldcup_id = $worldcup_array[$i]['worldcup_id'];

        $place = $i + 1;

        $sql = "UPDATE `worldcup`
                SET `worldcup_place`='$place'
                WHERE `worldcup_id`='$worldcup_id'";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}