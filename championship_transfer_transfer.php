<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `buyer`.`team_id` AS `buyer_id`,
               `buyer`.`team_name` AS `buyer_name`,
               `name_name`,
               `player_id`,
               `seller`.`team_id` AS `seller_id`,
               `seller`.`team_name` AS `seller_name`,
               `surname_name`,
               `transferhistory_date`,
               `transferhistory_price`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `player_id`=`transferhistory_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team` AS `buyer`
        ON `buyer`.`team_id`=`transferhistory_buyer_id`
        LEFT JOIN `standing` AS `buyer_standing`
        ON `buyer`.`team_id`=`buyer_standing`.`standing_team_id`
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transferhistory_seller_id`
        LEFT JOIN `standing` AS `seller_standing`
        ON `seller`.`team_id`=`seller_standing`.`standing_team_id`
        WHERE `transferhistory_season_id`='$igosja_season_id'
        AND `buyer_standing`.`standing_season_id`='$igosja_season_id'
        AND `seller_standing`.`standing_season_id`='$igosja_season_id'
        AND `buyer_standing`.`standing_tournament_id`='$get_num'
        AND `seller_standing`.`standing_tournament_id`='$get_num'
        ORDER BY `transferhistory_price` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');