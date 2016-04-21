<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `shedule_date`,
               `shedule_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        GROUP BY `shedule_id`
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');