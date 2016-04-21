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

$sql = "SELECT `name_name`,
               `referee_id`,
               `statisticreferee_game`,
               ROUND(`statisticreferee_mark`/`statisticreferee_game`, 2) AS `statisticreferee_mark`,
               `statisticreferee_penalty`,
               `statisticreferee_red`,
               `statisticreferee_yellow`,
               `surname_name`
        FROM `statisticreferee`
        LEFT JOIN `referee`
        ON `referee_id`=`statisticreferee_referee_id`
        LEFT JOIN `name`
        ON `referee_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `referee_surname_id`=`surname_id`
        WHERE `statisticreferee_tournament_id`='$num_get'
        AND `statisticreferee_season_id`='$igosja_season_id'
        AND `statisticreferee_game`!='0'
        ORDER BY `statisticreferee_game` DESC, `statisticreferee_mark` DESC";
$referee_sql = $mysqli->query($sql);

$referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');