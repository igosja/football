<?php

function f_igosja_season_championship_prize()
{
    global $igosja_season_id;

    $sql = "SELECT `standing_place`,
                   `standing_team_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            ORDER BY `standing_id` ASC";
    $standing_sql = f_igosja_mysqli_query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_standing; $i++)
    {
        $place      = $standing_array[$i]['standing_place'];
        $team_id    = $standing_array[$i]['standing_team_id'];

        if      (1 == $place) { $prize = 25000000; }
        elseif  (2 == $place) { $prize = 24500000; }
        elseif  (3 == $place) { $prize = 24010000; }
        elseif  (4 == $place) { $prize = 23529800; }
        elseif  (5 == $place) { $prize = 23059204; }
        elseif  (6 == $place) { $prize = 22598020; }
        elseif  (7 == $place) { $prize = 22146060; }
        elseif  (8 == $place) { $prize = 21703138; }
        elseif  (9 == $place) { $prize = 21269076; }
        elseif (10 == $place) { $prize = 20843694; }
        elseif (11 == $place) { $prize = 20426820; }
        elseif (12 == $place) { $prize = 20018284; }
        elseif (13 == $place) { $prize = 19617918; }
        elseif (14 == $place) { $prize = 19225560; }
        elseif (15 == $place) { $prize = 18841049; }
        elseif (16 == $place) { $prize = 18464228; }
        elseif (17 == $place) { $prize = 18094943; }
        elseif (18 == $place) { $prize = 17733044; }
        elseif (19 == $place) { $prize = 17378383; }
        else                  { $prize = 17030816; }

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'$prize'
                WHERE `team_id`='$team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `historyfinanceteam`
                SET `historyfinanceteam_date`=SYSDATE(),
                    `historyfinanceteam_historytext_id`='" . HISTORY_TEXT_INCOME_PRIZE . "',
                    `historyfinanceteam_season_id`='$igosja_season_id',
                    `historyfinanceteam_team_id`='$team_id',
                    `historyfinanceteam_value`='$prize'";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `finance`
                SET `finance_income_prize`=`finance_income_prize`+'$prize'
                WHERE `finance_season_id`='$igosja_season_id'
                AND `finance_team_id`='$team_id'";
        f_igosja_mysqli_query($sql);
    }
}