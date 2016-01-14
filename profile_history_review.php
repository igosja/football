<?php

include ('include/include.php');

if (!isset($authorization_id))
{
    $smarty->display('wrong_page.html');

    exit;
}

$sql = "SELECT SUM(`statisticuser_draw`) AS `draw`,
               SUM(`statisticuser_game`) AS `game`,
               SUM(`statisticuser_loose`) AS `loose`,
               SUM(`statisticuser_pass`) AS `pass`,
               SUM(`statisticuser_score`) AS `score`,
               SUM(`statisticuser_win`) AS `win`,
               TO_DAYS(SYSDATE()) - TO_DAYS(`user_registration_date`) AS `day`
        FROM `statisticuser`
        LEFT JOIN `user`
        ON `user_id`=`statisticuser_user_id`
        WHERE `statisticuser_user_id`='$authorization_id'";
$career_sql = $mysqli->query($sql);

$career_array = $career_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_buy_max`,
               `user_buy_player`,
               `user_buy_price`,
               `user_country`,
               `user_sell_max`,
               `user_sell_player`,
               `user_sell_price`,
               `user_team`,
               `user_team_time_max`,
               `user_team_time_min`,
               `user_trophy`
        FROM `user`
        WHERE `user_id`='$authorization_id'
        LIMIT 1";
$summary_sql = $mysqli->query($sql);

$count_summary = $summary_sql->num_rows;

if (0 == $count_summary)
{
    $sql = "INSERT INTO `user`
            SET `user_user_id`='$authorization_id'";
    $mysqli->query($sql);

    $sql = "SELECT `user_buy_max`,
                   `user_buy_player`,
                   `user_buy_price`,
                   `user_country`,
                   `user_sell_max`,
                   `user_sell_player`,
                   `user_sell_price`,
                   `user_team`,
                   `user_team_time_max`,
                   `user_team_time_min`,
                   `user_trophy`
            FROM `user`
            WHERE `user_user_id`='$authorization_id'
            LIMIT 1";
    $summary_sql = $mysqli->query($sql);
}

$user_array = $summary_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $authorization_id);
$smarty->assign('header_title', $authorization_login);
$smarty->assign('career_array', $career_array);
$smarty->assign('user_array', $user_array);

$smarty->display('main.html');