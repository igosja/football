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

$script_team = array();

$sql = "SELECT `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `team_name` ASC";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_team; $i++)
{
    $team_id    = $team_array[$i]['team_id'];
    $team_name  = $team_array[$i]['team_name'];

    $script_position = array();

    $sql = "SELECT `standinghistory_place`
            FROM `standinghistory`
            WHERE `standinghistory_team_id`='$team_id'
            AND `standinghistory_tournament_id`='$get_num'
            ORDER BY `standinghistory_stage_id` ASC";
    $position_sql = $mysqli->query($sql);

    $count_position = $position_sql->num_rows;
    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_position; $j++)
    {
        $script_position[] = $position_array[$j]['standinghistory_place'];
    }

    $script_position = implode(', ', $script_position);

    $script_team[] = '{name: "' . $team_name . '", data: [' . $script_position . ']}';
}

$script_team = implode(', ', $script_team);

$script_stage = array();

$sql = "SELECT MAX(`standinghistory_stage_id`) AS `standinghistory_stage_id`
        FROM `standinghistory`
        WHERE `standinghistory_tournament_id`='$get_num'";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$max_stage = $standing_array[0]['standinghistory_stage_id'];

for ($i=1; $i<=$max_stage; $i++)
{
    $script_stage[] = $i;
}

$script_stage = implode(', ', $script_stage);

$num            = $get_num;
$header_title   = $tournament_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');