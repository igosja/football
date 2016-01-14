<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `team_name`
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

$sql = "SELECT `name_name`,
               `offertype_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `transferhistory_buyer_id`,
               `transferhistory_date`,
               `transferhistory_price`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `transferhistory_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `transferhistory_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON `transferhistory_buyer_id`=`team_id`
        WHERE `transferhistory_seller_id`='$get_num'
        AND `transferhistory_season_id`='$igosja_season_id'
        ORDER BY `transferhistory_date` DESC";
$transferhistory_sell_sql = $mysqli->query($sql);

$transferhistory_sell_array = $transferhistory_sell_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`transferhistory_price`) AS `transferhistory_total_price`
        FROM `transferhistory`
        WHERE `transferhistory_seller_id`='$get_num'
        AND `transferhistory_season_id`='$igosja_season_id'";
$transferhistory_sell_sql = $mysqli->query($sql);

$transferhistory_sell_summ = $transferhistory_sell_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `offertype_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `transferhistory_buyer_id`,
               `transferhistory_date`,
               `transferhistory_price`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `transferhistory_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `transferhistory_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON `transferhistory_seller_id`=`team_id`
        WHERE `transferhistory_buyer_id`='$get_num'
        AND `transferhistory_season_id`='$igosja_season_id'
        ORDER BY `transferhistory_date` DESC";
$transferhistory_buy_sql = $mysqli->query($sql);

$transferhistory_buy_array = $transferhistory_buy_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`transferhistory_price`) AS `transferhistory_total_price`
        FROM `transferhistory`
        WHERE `transferhistory_buyer_id`='$get_num'
        AND `transferhistory_season_id`='$igosja_season_id'";
$transferhistory_buy_sql = $mysqli->query($sql);

$transferhistory_buy_summ = $transferhistory_buy_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('transferhistory_buy_array', $transferhistory_buy_array);
$smarty->assign('transferhistory_buy_summ', $transferhistory_buy_summ);
$smarty->assign('transferhistory_sell_array', $transferhistory_sell_array);
$smarty->assign('transferhistory_sell_summ', $transferhistory_sell_summ);

$smarty->display('main.html');