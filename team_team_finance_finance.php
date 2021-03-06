<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

if (isset($_GET['season']))
{
    $get_season = (int) $_GET['season'];
}
else
{
    $get_season = $igosja_season_id;
}

$sql = "SELECT `team_finance`,
               `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

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
        AND `finance_team_id`='$num_get'
        LIMIT 1";
$finance_sql = $mysqli->query($sql);

$finance_array = $finance_sql->fetch_all(1);

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
        WHERE `finance_season_id`='$igosja_season_id'-'1'
        AND `finance_team_id`='$num_get'
        LIMIT 1";
$finance_prev_sql = $mysqli->query($sql);

$finance_prev_array = $finance_prev_sql->fetch_all(1);

$sql = "SELECT `historyfinanceteam_date`,
               `historyfinanceteam_value`,
               `historytext_name`
        FROM `historyfinanceteam`
        LEFT JOIN `historytext`
        ON `historyfinanceteam_historytext_id`=`historytext_id`
        WHERE `historyfinanceteam_team_id`='$num_get'
        AND `historyfinanceteam_season_id`='$get_season'
        ORDER BY `historyfinanceteam_date` DESC";
$history_sql = $mysqli->query($sql);

$history_array = $history_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. ?????????????? ??????????. ' . $seo_title;
$seo_description    = $header_title . '. ?????????????? ??????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ?????????????? ??????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');