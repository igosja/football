<?php

include (__DIR__ . '/include/include.php');

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
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT DATEDIFF(`injury_end_date`, SYSDATE()) AS `day`,
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
        LEFT JOIN `leagueparticipant`
        ON `leagueparticipant_team_id`=`team_id`
        WHERE `injury_end_date`>SYSDATE()
        AND `leagueparticipant_tournament_id`='$get_num'
        AND `leagueparticipant_out`='0'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        ORDER BY `team_id` ASC, `injury_id` ASC";
$injury_sql = $mysqli->query($sql);

$injury_array = $injury_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');