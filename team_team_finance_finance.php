<?php

include ('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `team_finance`,
               `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

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
               `finance_expense_agent`,
               `finance_expense_base`,
               `finance_expense_build`,
               `finance_expense_loan`,
               `finance_expense_penalty`,
               `finance_expense_salary`,
               `finance_expense_scout`,
               `finance_expense_stadium`,
               `finance_expense_tax`,
               `finance_expense_transfer`,
               `finance_expense_transport`,
               `finance_income_attributes`+
               `finance_income_donat`+
               `finance_income_prize`+
               `finance_income_sponsor`+
               `finance_income_subscription`+
               `finance_income_ticket`+
               `finance_income_transfer`+
               `finance_income_tv` AS `finance_income`,
               `finance_income_attributes`,
               `finance_income_donat`,
               `finance_income_prize`,
               `finance_income_sponsor`,
               `finance_income_subscription`,
               `finance_income_ticket`,
               `finance_income_transfer`,
               `finance_income_tv`
        FROM `finance`
        WHERE `finance_season_id`='$igosja_season_id'
        AND `finance_team_id`='$get_num'
        LIMIT 1";
$finance_sql = $mysqli->query($sql);

$finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `historyfinanceteam_date`,
               `historyfinanceteam_value`,
               `historytext_name`
        FROM `historyfinanceteam`
        LEFT JOIN `historytext`
        ON `historyfinanceteam_historytext_id`=`historytext_id`
        WHERE `historyfinanceteam_team_id`='$get_num'
        ORDER BY `historyfinanceteam_date` DESC";
$history_sql = $mysqli->query($sql);

$history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('team_array', $team_array);
$smarty->assign('finance_array', $finance_array);
$smarty->assign('history_array', $history_array);

$smarty->display('main.html');