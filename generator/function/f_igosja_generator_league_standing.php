<?php

function f_igosja_generator_league_standing()
//Обновляем турнирные таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_guest_score`,
                   `game_home_team_id`,
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
        $home_team_id   = $game_array[$i]['game_home_team_id'];
        $home_score     = $game_array[$i]['game_home_score'];
        $guest_team_id  = $game_array[$i]['game_guest_team_id'];
        $guest_score    = $game_array[$i]['game_guest_score'];
        $stage_id       = $game_array[$i]['game_stage_id'];
        $tournament_id  = $game_array[$i]['game_tournament_id'];
        $home_win       = 0;
        $home_draw      = 0;
        $home_loose     = 0;
        $guest_win      = 0;
        $guest_draw     = 0;
        $guest_loose    = 0;

        if ($stage_id >= 1 &&
            $stage_id <= 6 &&
            TOURNAMENT_CHAMPIONS_LEAGUE == $tournament_id)
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

            $sql = "UPDATE `league`
                    SET `league_game`=`league_game`+'1',
                        `league_win`=`league_win`+'$home_win',
                        `league_draw`=`league_draw`+'$home_draw',
                        `league_loose`=`league_loose`+'$home_loose',
                        `league_score`=`league_score`+'$home_score',
                        `league_pass`=`league_pass`+'$guest_score',
                        `league_point`=`league_win`*'3'+`league_draw`
                    WHERE `league_team_id`='$home_team_id'
                    AND `league_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `league`
                    SET `league_game`=`league_game`+'1',
                        `league_win`=`league_win`+'$guest_win',
                        `league_draw`=`league_draw`+'$guest_draw',
                        `league_loose`=`league_loose`+'$guest_loose',
                        `league_score`=`league_score`+'$guest_score',
                        `league_pass`=`league_pass`+'$home_score',
                        `league_point`=`league_win`*'3'+`league_draw`
                    WHERE `league_team_id`='$guest_team_id'
                    AND `league_season_id`='$igosja_season_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `league_group`
            FROM `league`
            WHERE `league_season_id`='$igosja_season_id'
            GROUP BY `league_group`
            ORDER BY `league_group` ASC";
    $group_sql = f_igosja_mysqli_query($sql);

    $count_group = $group_sql->num_rows;
    $group_array = $group_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_group; $i++)
    {
        $group = $group_array[$i]['league_group'];

        $sql = "SELECT `league_id`
                FROM `league`
                WHERE `league_group`='$group'
                AND `league_season_id`='$igosja_season_id'
                ORDER BY `league_point` DESC, `league_score`-`league_pass` DESC, `league_score` DESC";
        $league_sql = f_igosja_mysqli_query($sql);

        $count_league = $league_sql->num_rows;
        $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_league; $j++)
        {
            $league_id = $league_array[$j]['league_id'];

            $place = $j + 1;

            $sql = "UPDATE `league`
                    SET `league_place`='$place'
                    WHERE `league_id`='$league_id'";
            f_igosja_mysqli_query($sql);
        }
    }

    usleep(1);

    print '.';
    flush();
}