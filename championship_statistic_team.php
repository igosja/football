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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    $smarty->display('wrong_page.html');

    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `statisticteam_goal`
        FROM `statisticteam`
        LEFT JOIN `team`
        ON `team_id`=`statisticteam_team_id`
        WHERE `statisticteam_tournament_id`='$get_num'
        AND `statisticteam_season_id`='$igosja_season_id'
        ORDER BY `statisticteam_goal` DESC, `team_id` ASC
        LIMIT 5";
$goal_sql = $mysqli->query($sql);

$goal_array = $goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `statisticteam_pass`
        FROM `statisticteam`
        LEFT JOIN `team`
        ON `team_id`=`statisticteam_team_id`
        WHERE `statisticteam_tournament_id`='$get_num'
        AND `statisticteam_season_id`='$igosja_season_id'
        ORDER BY `statisticteam_pass` DESC, `team_id` ASC
        LIMIT 5";
$pass_sql = $mysqli->query($sql);

$pass_array = $pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `statisticteam_red`
        FROM `statisticteam`
        LEFT JOIN `team`
        ON `team_id`=`statisticteam_team_id`
        WHERE `statisticteam_tournament_id`='$get_num'
        AND `statisticteam_season_id`='$igosja_season_id'
        ORDER BY `statisticteam_red` DESC, `team_id` ASC
        LIMIT 5";
$red_sql = $mysqli->query($sql);

$red_array = $red_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `statisticteam_yellow`
        FROM `statisticteam`
        LEFT JOIN `team`
        ON `team_id`=`statisticteam_team_id`
        WHERE `statisticteam_tournament_id`='$get_num'
        AND `statisticteam_season_id`='$igosja_season_id'
        ORDER BY `statisticteam_yellow` DESC, `team_id` ASC
        LIMIT 5";
$yellow_sql = $mysqli->query($sql);

$yellow_array = $yellow_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `series_value`
        FROM `series`
        LEFT JOIN `team`
        ON `team_id`=`series_team_id`
        WHERE `series_tournament_id`='$get_num'
        AND `series_seriestype_id`='" . SERIES_WIN . "'
        ORDER BY `series_value` DESC, `team_id` ASC
        LIMIT 5";
$win_sql = $mysqli->query($sql);

$win_array = $win_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `series_value`
        FROM `series`
        LEFT JOIN `team`
        ON `team_id`=`series_team_id`
        WHERE `series_tournament_id`='$get_num'
        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
        ORDER BY `series_value` DESC, `team_id` ASC
        LIMIT 5";
$no_loose_sql = $mysqli->query($sql);

$no_loose_array = $no_loose_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `series_value`
        FROM `series`
        LEFT JOIN `team`
        ON `team_id`=`series_team_id`
        WHERE `series_tournament_id`='$get_num'
        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
        ORDER BY `series_value` DESC, `team_id` ASC
        LIMIT 5";
$loose_sql = $mysqli->query($sql);

$loose_array = $loose_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `series_value`
        FROM `series`
        LEFT JOIN `team`
        ON `team_id`=`series_team_id`
        WHERE `series_tournament_id`='$get_num'
        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
        ORDER BY `series_value` DESC, `team_id` ASC
        LIMIT 5";
$nopass_sql = $mysqli->query($sql);

$nopass_array = $nopass_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $tournament_name);
$smarty->assign('goal_array', $goal_array);
$smarty->assign('pass_array', $pass_array);
$smarty->assign('red_array', $red_array);
$smarty->assign('yellow_array', $yellow_array);
$smarty->assign('win_array', $win_array);
$smarty->assign('no_loose_array', $no_loose_array);
$smarty->assign('loose_array', $loose_array);
$smarty->assign('nopass_array', $nopass_array);

$smarty->display('main.html');