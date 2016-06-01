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

$sql = "SELECT `name_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `injury_start_date`,
               `injurytype_day`,
               `injurytype_name`
        FROM `injury`
        LEFT JOIN `injurytype`
        ON `injurytype_id`=`injury_injurytype_id`
        WHERE `injury_player_id`='$num_get'
        ORDER BY `injury_start_date` ASC";
$injury_sql = $mysqli->query($sql);

$injury_array = $injury_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. Полученные травмы. ' . $seo_title;
$seo_description    = $header_title . '. Полученные травмы. ' . $seo_description;
$seo_keywords       = $header_title . ', полученные травмы, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');