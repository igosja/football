<?php

include ('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
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

$sql = "SELECT `country_id`,
               `country_name`,
               `mood_id`,
               `mood_name`,
               `name_name`,
               `player_age`,
               `player_condition`,
               `player_height`,
               `player_id`,
               `player_number`,
               `player_practice`,
               `player_salary`,
               `player_weight`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        LEFT JOIN `player`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `mood`
        ON `player_mood_id`=`mood_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `team_id`='$get_num'
        AND `playerposition_value`='100'";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);

$smarty->display('main.html');