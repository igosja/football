<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    $smarty->display($_SERVER['DOCUMENT_ROOT'] . '/wrong_page.php');
    exit;
}

$sql = "SELECT `game_home_team_id`,
               IF (`game_home_team_id`='$authorization_team_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               `game_played`,
               IF (`game_home_team_id`='$authorization_team_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$authorization_team_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');