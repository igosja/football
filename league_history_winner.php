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

$sql = "SELECT `city_name`,
               `country_name`,
               `leagueparticipant_season_id`,
               `team_id`,
               `team_name`
        FROM `leagueparticipant`
        LEFT JOIN `team`
        ON `leagueparticipant_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `leagueparticipant_out`='" . CUP_WINNER_STAGE . "'
        AND `leagueparticipant_season_id`<'$igosja_season_id'
        AND `leagueparticipant_tournament_id`='$num_get'
        ORDER BY `leagueparticipant_season_id` DESC";
$winner_sql = $mysqli->query($sql);

$count_winner = $winner_sql->num_rows;
$winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_name`,
               `team_id`,
               `team_name`
        FROM `leagueparticipant`
        LEFT JOIN `team`
        ON `leagueparticipant_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `leagueparticipant_out`='" . CUP_FINAL_STAGE . "'
        AND `leagueparticipant_season_id`<'$igosja_season_id'
        AND `leagueparticipant_tournament_id`='$num_get'
        ORDER BY `leagueparticipant_season_id` DESC";
$looser_sql = $mysqli->query($sql);

$looser_array = $looser_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $header_title . '. Победители турнира. ' . $seo_title;
$seo_description    = $header_title . '. Победители турнира. ' . $seo_description;
$seo_keywords       = $header_title . ', победители турнира, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');