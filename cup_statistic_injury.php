<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT ROUND((`injury_end_date` - UNIX_TIMESTAMP()) / 60 / 60 / 24) AS `day`,
               `injurytype_name`,
               `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `injury`
        LEFT JOIN `injurytype`
        ON `injurytype_id`=`injury_injurytype_id`
        LEFT JOIN `player`
        ON `injury_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `cupparticipant`
        ON `cupparticipant_team_id`=`team_id`
        WHERE `injury_end_date`>UNIX_TIMESTAMP()
        AND `cupparticipant_tournament_id`='$num_get'
        AND `cupparticipant_out`='0'
        AND `cupparticipant_season_id`='$igosja_season_id'
        ORDER BY `team_id` ASC, `injury_id` ASC";
$injury_sql = $mysqli->query($sql);

$injury_array = $injury_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Травмы футболистов. ' . $seo_title;
$seo_description    = $tournament_name . '. Травмы футболистов. ' . $seo_description;
$seo_keywords       = $tournament_name . ', травмы футболистов, ' . $seo_keywords;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');