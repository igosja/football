<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
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
        WHERE `statisticuser_user_id`='$get_num'";
$career_sql = $mysqli->query($sql);

$career_array = $career_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_buy_max`,
               `user_buy_player`,
               `user_buy_price`,
               `user_national`,
               `user_sell_max`,
               `user_sell_player`,
               `user_sell_price`,
               `user_team`,
               `user_team_time_max`,
               `user_team_time_min`,
               `user_trophy`
        FROM `user`
        WHERE `user_id`='$get_num'
        LIMIT 1";
$summary_sql = $mysqli->query($sql);

$user_array = $summary_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');