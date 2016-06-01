<?php

function f_igosja_season_tax()
{
    global $igosja_season_id;

    $sql = "SELECT `finance_expense_agent`+
                   `finance_expense_base`+
                   `finance_expense_build`+
                   `finance_expense_loan`+
                   `finance_expense_penalty`+
                   `finance_expense_salary`+
                   `finance_expense_scout`+
                   `finance_expense_stadium`+
                   `finance_expense_tax`+
                   `finance_expense_transfer`+
                   `finance_expense_transport` AS `finance_expense`,
                   `finance_income_attributes`+
                   `finance_income_donat`+
                   `finance_income_prize`+
                   `finance_income_sponsor`+
                   `finance_income_subscription`+
                   `finance_income_ticket`+
                   `finance_income_transfer`+
                   `finance_income_tv` AS `finance_income`,
                   `finance_team_id`
            FROM `finance`
            WHERE `finance_season_id`='$igosja_season_id'
            AND `finance_team_id`!='0'
            ORDER BY `finance_team_id` ASC";
    $finance_sql = f_igosja_mysqli_query($sql);

    $count_finance = $finance_sql->num_rows;
    $finance_array = $finance_sql->fetch_all(1);

    for ($i=0; $i<$count_finance; $i++)
    {
        $team_id    = $finance_array[$i]['finance_team_id'];
        $income     = $finance_array[$i]['finance_income'];
        $expense    = $finance_array[$i]['finance_expense'];
        $profit     = $income - $expense;

        if (4 <= $profit) //Налог 25%, минимум прибыли нужно 4$
        {
            $tax = round($profit / 4);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-'$tax'
                    WHERE `team_id`='$team_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `historyfinanceteam`
                    SET `historyfinanceteam_date`=UNIX_TIMESTAMP(),
                        `historyfinanceteam_historytext_id`='" . HISTORY_TEXT_EXPENCE_TAX. "',
                        `historyfinanceteam_season_id`='$igosja_season_id',
                        `historyfinanceteam_team_id`='$team_id',
                        `historyfinanceteam_value`='$tax'";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `finance`
                    SET `finance_expense_tax`=`finance_expense_tax`+'$tax'
                    WHERE `finance_season_id`='$igosja_season_id'
                    AND `finance_team_id`='$team_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}