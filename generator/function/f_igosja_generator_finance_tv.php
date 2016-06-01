<?php

function f_igosja_generator_finance_tv()
//Финансы после матча
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_stage_id`,
                   `tournament_tournamenttype_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(1);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $stage_id           = $game_array[$i]['game_stage_id'];
        $tournamenttype_id  = $game_array[$i]['tournament_tournamenttype_id'];

        if (TOURNAMENT_TYPE_CHAMPIONSHIP == $tournamenttype_id)
        {
            $finance_tv = 500000;
        }
        elseif (TOURNAMENT_TYPE_CUP == $tournamenttype_id)
        {
            if     (43 == $stage_id) { $finance_tv =  100000; }
            elseif (44 == $stage_id) { $finance_tv =  200000; }
            elseif (45 == $stage_id) { $finance_tv =  300000; }
            elseif (46 == $stage_id) { $finance_tv =  400000; }
            elseif (47 == $stage_id) { $finance_tv =  600000; }
            elseif (48 == $stage_id) { $finance_tv =  800000; }
            else                     { $finance_tv = 1000000; }
        }
        elseif (TOURNAMENT_TYPE_CHAMPIONS_LEAGUE == $tournamenttype_id)
        {
            if     (39 == $stage_id) { $finance_tv =   62500; }
            elseif (40 == $stage_id) { $finance_tv =  125000; }
            elseif (41 == $stage_id) { $finance_tv =  250000; }
            elseif (42 == $stage_id) { $finance_tv =  500000; }
            elseif (1  == $stage_id) { $finance_tv = 1000000; }
            elseif (2  == $stage_id) { $finance_tv = 1000000; }
            elseif (3  == $stage_id) { $finance_tv = 1000000; }
            elseif (4  == $stage_id) { $finance_tv = 1000000; }
            elseif (5  == $stage_id) { $finance_tv = 1000000; }
            elseif (6  == $stage_id) { $finance_tv = 1000000; }
            elseif (46 == $stage_id) { $finance_tv = 2000000; }
            elseif (47 == $stage_id) { $finance_tv = 3000000; }
            elseif (48 == $stage_id) { $finance_tv = 4000000; }
            else                     { $finance_tv = 5000000; }
        }

        if (isset($finance_tv))
        {
            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+'$finance_tv'
                    WHERE `team_id` IN ('$home_team_id', '$guest_team_id')";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `finance`
                    SET `finance_income_tv`=`finance_income_tv`+'$finance_tv'
                    WHERE `finance_team_id` IN ('$home_team_id', '$guest_team_id')
                    AND `finance_season_id`='$igosja_season_id'";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `historyfinanceteam` (`historyfinanceteam_date`, `historyfinanceteam_historytext_id`, `historyfinanceteam_season_id`, `historyfinanceteam_team_id`, `historyfinanceteam_value`)
                    VALUES (UNIX_TIMESTAMP(), '" . HISTORY_TEXT_INCOME_TV . "', '$igosja_season_id', '$home_team_id', '$finance_tv'),
                           (UNIX_TIMESTAMP(), '" . HISTORY_TEXT_INCOME_TV . "', '$igosja_season_id', '$guest_team_id', '$finance_tv');";
            f_igosja_mysqli_query($sql);

            usleep(1);

            print '.';
            flush();
        }
    }
}