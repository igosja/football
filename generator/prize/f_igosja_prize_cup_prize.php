<?php

function f_igosja_prize_cup_prize()
{
    global $igosja_season_id;

    $sql = "SELECT `cupparticipant_out`,
                   `cupparticipant_team_id`
            FROM `cupparticipant`
            WHERE `cupparticipant_season_id`='$igosja_season_id'
            ORDER BY `cupparticipant_id` ASC";
    $cupparticipant_sql = f_igosja_mysqli_query($sql);

    $count_cupparticipant = $cupparticipant_sql->num_rows;
    $cupparticipant_array = $cupparticipant_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_cupparticipant; $i++)
    {
        $team_id    = $cupparticipant_array[$i]['cupparticipant_team_id'];
        $out        = $cupparticipant_array[$i]['cupparticipant_out'];

        if     (-1 == $out) { $prize = 5000000; }
        elseif (49 == $out) { $prize = 4400000; }
        elseif (48 == $out) { $prize = 3800000; }
        elseif (47 == $out) { $prize = 3200000; }
        elseif (46 == $out) { $prize = 2600000; }
        elseif (45 == $out) { $prize = 2000000; }
        elseif (44 == $out) { $prize = 1400000; }
        else                { $prize = 800000; }

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'$prize'
                WHERE `team_id`='$team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `historyfinanceteam`
                SET `historyfinanceteam_date`=UNIX_TIMESTAMP(),
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