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
               `tournament_id`,
               `tournament_name`,
               `transfer_buyer_id`,
               `transfer_price`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `transfer_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON IF (`transfer_seller_id`='$get_num', `transfer_buyer_id`, `transfer_seller_id`)=`team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE (`transfer_buyer_id`='$get_num'
        OR `transfer_seller_id`='$get_num')
        AND `standing_season_id`='$igosja_season_id'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `transfer_date` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('transfer_array', $transfer_array);

$smarty->display('main.html');