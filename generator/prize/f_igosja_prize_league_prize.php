<?php

function f_igosja_prize_league_prize()
{
    global $igosja_season_id;

    $sql = "SELECT `leagueparticipant_out`,
                   `leagueparticipant_team_id`
            FROM `leagueparticipant`
            WHERE `leagueparticipant_season_id`='$igosja_season_id'
            ORDER BY `leagueparticipant_id` ASC";
    $leagueparticipant_sql = f_igosja_mysqli_query($sql);

    $count_leagueparticipant = $leagueparticipant_sql->num_rows;
    $leagueparticipant_array = $leagueparticipant_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_leagueparticipant; $i++)
    {
        $team_id    = $leagueparticipant_array[$i]['leagueparticipant_team_id'];
        $out        = $leagueparticipant_array[$i]['leagueparticipant_out'];

        if     (-1 == $out) { $prize = 25000000; }
        elseif (49 == $out) { $prize = 23000000; }
        elseif (48 == $out) { $prize = 21000000; }
        elseif (47 == $out) { $prize = 19000000; }
        elseif (46 == $out) { $prize = 17000000; }
        elseif (5  == $out) { $prize = 15000000; }
        elseif (6  == $out) { $prize = 13000000; }
        elseif (42 == $out) { $prize = 11000000; }
        elseif (41 == $out) { $prize =  9000000; }
        elseif (40 == $out) { $prize =  7000000; }
        else                { $prize =  5000000; }

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