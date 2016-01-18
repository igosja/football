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

$sql = "SELECT `standing_place`,
               `standing_season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `standing_tournament_id`=`tournament_id`
        WHERE `standing_team_id`='$get_num'
        ORDER BY `standing_season_id` DESC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_date`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        WHERE `history_team_id`='$get_num'
        AND `history_historytext_id`='1'
        ORDER BY `history_date` DESC";
$manager_sql = $mysqli->query($sql);

$manager_array = $manager_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('tournament_array', $tournament_array);
$smarty->assign('manager_array', $manager_array);

$smarty->display('main.html');